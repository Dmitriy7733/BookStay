<?php
// /app/controllers/CategoryManagementController.php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryManagementController {
    private $db;
    private $CategoryModel;

    public function __construct($db) {
        $this->db = $db;
        $this->CategoryModel = new CategoryModel($db);
    }

    public function manageCategories() {
        /*if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = 2; // ID тестового пользователя
        $_SESSION['is_authenticated'] = true;
        $_SESSION['username'] = 'ТестовыйAdmin'; // добавьте имя пользователя для отображения
        $_SESSION['role'] = 'admin'; // убедитесь, что роль установлена
    }
        // Проверка прав доступа
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit();
        }*/

        // Получение всех категорий и подкатегорий для форм
        $categories = $this->CategoryModel->getCategories();
        $allCategories = $this->CategoryModel->getParentCategories();
        require_once __DIR__ . '/../views/admin_category.php';
    }

    public function addCategory() {
        /*if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = 2; // ID тестового пользователя
        $_SESSION['is_authenticated'] = true;
        $_SESSION['username'] = 'ТестовыйAdmin'; // добавьте имя пользователя для отображения
        $_SESSION['role'] = 'admin'; // убедитесь, что роль установлена
    }
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit();
        }*/

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        
        // Для AJAX запросов возвращаем JSON
        if (!empty($name)) {
            $result = $this->CategoryModel->addCategory($name);
            if ($result) {
                // Если это AJAX запрос, возвращаем JSON
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Категория успешно добавлена']);
                    exit();
                } else {
                    $_SESSION['success_message'] = 'Категория успешно добавлена';
                }
            } else {
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Ошибка при добавлении категории']);
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Ошибка при добавлении категории';
                }
            }
        } else {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Название категории не может быть пустым']);
                exit();
            }
        }
        
        // Редирект только для обычных запросов (не AJAX)
        if (!$this->isAjaxRequest()) {
            header('Location: index.php?page=categories_management');
            exit();
        }
    }
}

    public function addSubcategory() {
        /*if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = 2; // ID тестового пользователя
        $_SESSION['is_authenticated'] = true;
        $_SESSION['username'] = 'ТестовыйAdmin'; // добавьте имя пользователя для отображения
        $_SESSION['role'] = 'admin'; // убедитесь, что роль установлена
    }
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit();
        }*/

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $parentId = (int)$_POST['parent_id'];
        $name = trim($_POST['name']);
        
        if (!empty($name) && $parentId > 0) {
            $result = $this->CategoryModel->addSubcategory($parentId, $name);
            if ($result) {
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Подкатегория успешно добавлена']);
                    exit();
                } else {
                    $_SESSION['success_message'] = 'Подкатегория успешно добавлена';
                }
            } else {
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Ошибка при добавлении подкатегории']);
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Ошибка при добавлении подкатегории';
                }
            }
        } else {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Неверные данные']);
                exit();
            }
        }
        
        if (!$this->isAjaxRequest()) {
            header('Location: index.php?page=categories_management');
            exit();
        }
    }
    }

/**
 * Проверяет, является ли запрос AJAX
 */
private function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
    public function deleteCategory() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?page=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryId = (int)$_POST['id'];
        
        if ($categoryId > 0) {
            // Проверяем существование категории
            $categoryExists = $this->CategoryModel->categoryExists($categoryId);
            
            if (!$categoryExists) {
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Категория не найдена']);
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Категория не найдена';
                }
            } else {
                $result = $this->CategoryModel->deleteCategory($categoryId);
                
                if ($result) {
                    if ($this->isAjaxRequest()) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => 'Категория успешно удалена']);
                        exit();
                    } else {
                        $_SESSION['success_message'] = 'Категория успешно удалена';
                    }
                } else {
                    if ($this->isAjaxRequest()) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'error' => 'Ошибка при удалении категории']);
                        exit();
                    } else {
                        $_SESSION['error_message'] = 'Ошибка при удалении категории';
                    }
                }
            }
        } else {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Неверный ID категории']);
                exit();
            }
        }

        if (!$this->isAjaxRequest()) {
            header('Location: index.php?page=categories_management');
            exit();
        }
    }
}
    public function deleteSubcategory() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subcategoryId = (int)$_POST['id'];
        
        if ($subcategoryId > 0) {
            $result = $this->CategoryModel->deleteSubcategory($subcategoryId);
            if ($result) {
                // Для AJAX запросов возвращаем JSON
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Подкатегория успешно удалена']);
                    exit();
                } else {
                    $_SESSION['success_message'] = 'Подкатегория успешно удалена';
                }
            } else {
                // Для AJAX запросов возвращаем JSON
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Ошибка при удалении подкатегории']);
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Ошибка при удалении подкатегории';
                }
            }
        } else {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Неверный ID подкатегории']);
                exit();
            }
        }
        // Редирект только для обычных запросов (не AJAX)
        if (!$this->isAjaxRequest()) {
            header('Location: index.php?page=categories_management');
            exit();
        }
    }
}
}