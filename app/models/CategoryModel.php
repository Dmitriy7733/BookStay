<?php
// app/models/CategoryModel.php
class CategoryModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
public function autocompleteCities($query) {
    if (strlen($query) < 2) {
        return [];
    }
    
    $stmt = $this->db->prepare("
        SELECT id, name 
        FROM categories 
        WHERE parent_id IS NOT NULL  
        AND name LIKE :query 
        LIMIT 10 
    ");
    $stmt->execute([':query' => '%' . $query . '%']);
    
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ДЛЯ ОТЛАДКИ:
    error_log("Autocomplete results for '$query': " . print_r($cities, true));
    
    return $cities;
}
    
    public function getCityName($cityId) {
    $stmt = $this->db->prepare("SELECT name FROM categories WHERE id = :id AND parent_id IS NOT NULL");
    $stmt->execute([':id' => $cityId]);
    return $stmt->fetchColumn();
}
    public function getAllCategoriesWithSubcategories() {
        // Получаем все родительские категории
        $parentCategories = $this->db->query("SELECT * FROM categories WHERE parent_id IS NULL")->fetchAll(PDO::FETCH_ASSOC);
        
        // Для каждой родительской категории получаем подкатегории
        foreach ($parentCategories as &$category) {
            $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id = :parent_id");
            $stmt->execute([':parent_id' => $category['id']]);
            $category['subcategories'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $parentCategories;
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getParentCategories() {
        $stmt = $this->db->query("SELECT id, name FROM categories WHERE parent_id IS NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id = :category_id");
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
public function addCategory($name) {
    // Генерируем уникальный url
    $url = $this->generateUniqueUrl($name);
    // Вставляем новую категорию с сгенерированным url
    $stmt = $this->db->prepare("INSERT INTO categories (name, url) VALUES (?, ?)");
    return $stmt->execute([$name, $url]);
}

/**
 * Генерирует уникальный URL на основе имени категории
 */
private function generateUniqueUrl($name) {
    // Преобразуем имя в транслит или просто заменяем пробелы и специальные символы
    $baseUrl = $this->slugify($name);
    $url = $baseUrl;
    $counter = 1;

    // Проверяем, существует ли уже такой url
    while ($this->urlExists($url)) {
        $url = $baseUrl . '-' . $counter;
        $counter++;
    }
    return $url;
}

/**
 * Проверяет, существует ли уже такой url в таблице
 */
private function urlExists($url) {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE url = ?");
    $stmt->execute([$url]);
    return $stmt->fetchColumn() > 0;
}

/**
 * Преобразует строку в "slug" для URL
 */
private function slugify($text) {
    // Можно использовать более сложную транслитерацию, если нужно
    $text = mb_strtolower($text, 'UTF-8');
    // Заменяем не алфавитно-цифровые символы на дефисы
    $text = preg_replace('/[^a-z0-9]+/u', '-', $text);
    // Удаляем начальные и конечные дефисы
    $text = trim($text, '-');
    return $text;
}

public function addSubcategory($parentId, $name) {
    // Получаем URL родительской категории
    $parentUrl = $this->getCategoryUrl($parentId);
    
    // Генерируем уникальный URL для подкатегории
    $urlSegment = $this->generateUniqueUrlSegment($name, $parentId);
    
    // Формируем полный URL: родительский URL + сегмент подкатегории
    $fullUrl = $parentUrl . '/' . $urlSegment;
    
    // Вставляем новую подкатегорию
    $stmt = $this->db->prepare("INSERT INTO categories (name, parent_id, url) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $parentId, $fullUrl]);
}

/**
 * Получает URL родительской категории
 */
private function getCategoryUrl($categoryId) {
    $stmt = $this->db->prepare("SELECT url FROM categories WHERE id = ?");
    $stmt->execute([$categoryId]);
    return $stmt->fetchColumn();
}

/**
 * Генерирует уникальный сегмент URL для подкатегории
 */
private function generateUniqueUrlSegment($name, $parentId) {
    $baseUrl = $this->slugify($name);
    $urlSegment = $baseUrl;
    $counter = 1;

    // Проверяем уникальность полного URL
    while ($this->fullUrlExists($urlSegment, $parentId)) {
        $urlSegment = $baseUrl . '-' . $counter;
        $counter++;
    }
    return $urlSegment;
}

/**
 * Проверяет существование полного URL
 */
private function fullUrlExists($urlSegment, $parentId) {
    $parentUrl = $this->getCategoryUrl($parentId);
    $fullUrl = $parentUrl . '/' . $urlSegment;
    
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE url = ?");
    $stmt->execute([$fullUrl]);
    return $stmt->fetchColumn() > 0;
}
public function deleteCategory($categoryId) {
        try {
            $this->db->beginTransaction();
            error_log("Начало удаления категории ID: " . $categoryId);

            // Проверка существования категории
            if (!$this->categoryExists($categoryId)) {
                error_log("Категория не найдена: " . $categoryId);
                $this->db->rollBack();
                return false;
            }

            // Получить все ID подкатегорий перед удалением
            $subcategories = $this->getSubcategoriesForDelete($categoryId);
            error_log("Найдено подкатегорий: " . count($subcategories));

            // Сначала обнуляем подкатегории в объявлениях
            $this->updateListingsSubcategories($categoryId);
            error_log("Обновлены подкатегории в объявлениях");

            // Обнуляем категории в объявлениях
            $this->updateListingsCategories($categoryId);
            error_log("Обновлены категории в объявлениях");

            // Удаляем подкатегории
            foreach ($subcategories as $subcategory) {
                $this->deleteSubcategoryDirect($subcategory['id']);
            }
            error_log("Подкатегории удалены");

            // Удаляем основную категорию
            $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
            $result = $stmt->execute([$categoryId]);
            error_log("Основная категория удалена: " . ($result ? 'успешно' : 'ошибка'));

            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Ошибка при удалении категории: " . $e->getMessage());
            error_log("Trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Обновляет подкатегории в объявлениях на NULL для всех подкатегорий данной категории
     */
    private function updateListingsSubcategories($categoryId) {
        // Получаем все ID подкатегорий
        $stmt = $this->db->prepare("SELECT id FROM categories WHERE parent_id = ?");
        $stmt->execute([$categoryId]);
        $subcategoryIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Обновляем subcategory_id на NULL для всех найденных подкатегорий
        if (!empty($subcategoryIds)) {
            $placeholders = str_repeat('?,', count($subcategoryIds) - 1) . '?';
            $stmt = $this->db->prepare("
                UPDATE listings 
                SET subcategory_id = NULL 
                WHERE subcategory_id IN ($placeholders)
            ");
            $stmt->execute($subcategoryIds);
        }
    }

    /**
     * Обновляет категории в объявлениях на NULL для данной категории
     */
    private function updateListingsCategories($categoryId) {
        $stmt = $this->db->prepare("
            UPDATE listings 
            SET category_id = NULL 
            WHERE category_id = ?
        ");
        $stmt->execute([$categoryId]);
    }

    /**
     * Прямое удаление подкатегории
     */
    private function deleteSubcategoryDirect($subcategoryId) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$subcategoryId]);
    }

    public function deleteSubcategory($subcategoryId) {
        try {
            $this->db->beginTransaction();

            // Сначала обновляем объявления
            $this->updateListingsSubcategory($subcategoryId);

            // Затем удаляем подкатегорию
            $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
            $result = $stmt->execute([$subcategoryId]);

            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Error deleting subcategory: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновляет конкретную подкатегорию в объявлениях
     */
    private function updateListingsSubcategory($subcategoryId) {
        $stmt = $this->db->prepare("
            UPDATE listings 
            SET subcategory_id = NULL 
            WHERE subcategory_id = ?
        ");
        $stmt->execute([$subcategoryId]);
    }

    public function categoryExists($categoryId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchColumn() > 0;
    }

    public function getSubcategoriesForDelete($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function deleteCategoryData($categoryId) {
    // Получаем все ID подкатегорий
    $stmt = $this->db->prepare("SELECT id FROM categories WHERE parent_id = ?");
    $stmt->execute([$categoryId]);
    $subcategoryIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Обнуляем subcategory_id для всех найденных подкатегорий
    if (!empty($subcategoryIds)) {
        $placeholders = str_repeat('?,', count($subcategoryIds) - 1) . '?';
        $stmt = $this->db->prepare("
            UPDATE listings 
            SET subcategory_id = NULL 
            WHERE subcategory_id IN ($placeholders)
        ");
        $stmt->execute($subcategoryIds);
    }
    
    // Обнуляем category_id для основной категории

    $stmt = $this->db->prepare("
        UPDATE listings 
        SET category_id = NULL 
        WHERE category_id = ?
    ");
    $stmt->execute([$categoryId]);
}
private function deleteSubcategoryData($subcategoryId) {
    $stmt = $this->db->prepare("
        UPDATE listings 
        SET subcategory_id = NULL 
        WHERE subcategory_id = ?
    ");
    $stmt->execute([$subcategoryId]);
}

    private function deleteListingData($listingId) {
        // Удаляем связанные данные объявления
        $tables = [
            'listing_prices' => 'listing_id',
            'listing_photos' => 'listing_id', 
            'listing_views' => 'listing_id',
            'reviews' => 'listing_id',
            'blocked_dates' => 'listing_id'
        ];

        foreach ($tables as $table => $column) {
            $stmt = $this->db->prepare("DELETE FROM {$table} WHERE {$column} = ?");
            $stmt->execute([$listingId]);
        }
    }
    public function getParentCategoriesCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE parent_id IS NULL");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Получает количество подкатегорий
     */
    public function getSubcategoriesCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE parent_id IS NOT NULL");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Получает количество подкатегорий для конкретной категории
     */
    public function getSubcategoriesCountByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE parent_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchColumn();
    }

    /**
     * Получает все категории с количеством подкатегорий
     */
    public function getCategoriesWithSubcategoriesCount() {
        $stmt = $this->db->prepare("
            SELECT 
                c.id,
                c.name,
                c.url,
                COUNT(sc.id) as subcategories_count
            FROM categories c
            LEFT JOIN categories sc ON sc.parent_id = c.id
            WHERE c.parent_id IS NULL
            GROUP BY c.id, c.name, c.url
            ORDER BY c.name
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Получает полную статистику по категориям
     */
    public function getCategoriesStatistics() {
        return [
            'parent_categories_count' => $this->getParentCategoriesCount(),
            'subcategories_count' => $this->getSubcategoriesCount(),
            'total_categories' => $this->getParentCategoriesCount() + $this->getSubcategoriesCount()
        ];
    }
}