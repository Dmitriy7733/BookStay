<?php
include 'db.php';
//include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
try { //$db = getDb();

// Заполнение таблицы listings тестовыми данными
    $users = $db->query("SELECT id FROM users LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($users)) {
        // Создаем тестовых пользователей если их нет
        $testUsers = [
    ['testuser1@example.com', 'testuser1', 'password_hash_here', 'hotelier'],
    ['testuser2@example.com', 'testuser2', 'password_hash_here', 'hotelier'],
    ['testuser3@example.com', 'testuser3', 'password_hash_here', 'hotelier']
];

foreach ($testUsers as $userData) {
    $stmt = $db->prepare("INSERT INTO users (email, username, password_hash, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userData[0], $userData[1], password_hash('temp_password', PASSWORD_DEFAULT), $userData[3]]);
}
        
        $users = $db->query("SELECT id FROM users LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
    }

    // Получаем ID категорий и подкатегорий
    $categories = $db->query("SELECT id, name, parent_id FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    
    $mainCategories = array_filter($categories, fn($cat) => $cat['parent_id'] === null);
    $subCategories = array_filter($categories, fn($cat) => $cat['parent_id'] !== null);
    
    // Тестовые данные для listings
    $testListings = [
        [
            'title' => 'Уютная квартира в центре Анапы',
            'description' => 'Просторная 2-комнатная квартира с видом на море. Современный ремонт, вся необходимая техника. Рядом пляж и инфраструктура.',
            'address' => 'г. Анапа, ул. Ленина, д. 15',
            'distance_to_sea' => '200 м',
            'has_parking' => true,
            'food_options' => 'Без питания, Возможно заказать',
            'registry_number' => 'АН-12345',
            'legal_form' => 'individual_entrepreneur',
            'phone' => '+7 (999) 123-45-67',
            'max_adults' => 4,
            'max_children' => 2,
            'max_guests_total' => 6
        ],
        [
            'title' => 'Частный дом в Джемете',
            'description' => 'Комфортабельный дом для большой компании. Собственный двор, мангал, беседка. В 5 минутах от песчаного пляжа.',
            'address' => 'п. Джемете, ул. Пляжная, д. 8',
            'distance_to_sea' => '300 м',
            'has_parking' => true,
            'food_options' => 'Самостоятельно, Кухня оборудована',
            'registry_number' => 'ДЖ-67890',
            'legal_form' => 'self_employed',
            'phone' => '+7 (999) 765-43-21',
            'max_adults' => 8,
            'max_children' => 4,
            'max_guests_total' => 12
        ],
        [
            'title' => 'Студия в новом комплексе Сочи',
            'description' => 'Современная студия с панорамными окнами. Кондиционер, Wi-Fi, кухня-ниша. Идеально для молодой пары.',
            'address' => 'г. Сочи, ул. Олимпийская, д. 25',
            'distance_to_sea' => '500 м',
            'has_parking' => false,
            'food_options' => 'Без питания',
            'registry_number' => 'СЧ-54321',
            'legal_form' => 'legal_entity',
            'phone' => '+7 (999) 555-44-33',
            'max_adults' => 2,
            'max_children' => 1,
            'max_guests_total' => 3
        ],
        [
            'title' => 'Вилла в Гагре с бассейном',
            'description' => 'Роскошная вилла с приватным бассейном и садом. 4 спальни, просторная гостиная. Вид на горы и море.',
            'address' => 'г. Гагра, ул. Приморская, д. 12',
            'distance_to_sea' => '150 м',
            'has_parking' => true,
            'food_options' => 'Завтрак включен, Полный пансион',
            'registry_number' => 'АБ-98765',
            'legal_form' => 'individual_entrepreneur',
            'phone' => '+7 (999) 222-33-44',
            'max_adults' => 10,
            'max_children' => 6,
            'max_guests_total' => 16
        ],
        [
            'title' => 'Эконом вариант в Крыму',
            'description' => 'Небольшая комната в частном секторе. Все необходимое для бюджетного отдыха. Рядом магазины и остановка.',
            'address' => 'г. Евпатория, ул. Садовая, д. 7',
            'distance_to_sea' => '800 м',
            'has_parking' => false,
            'food_options' => 'Самостоятельно',
            'registry_number' => 'КР-11223',
            'legal_form' => 'self_employed',
            'phone' => '+7 (999) 777-88-99',
            'max_adults' => 2,
            'max_children' => 0,
            'max_guests_total' => 2
        ]
    ];

    // Вставляем тестовые объявления
    $listingIds = [];
    foreach ($testListings as $index => $listingData) {
        $userIndex = $index % count($users);
        $categoryIndex = $index % count($mainCategories);
        
        $mainCategory = array_values($mainCategories)[$categoryIndex];
        $subCategoriesForMain = array_filter($subCategories, fn($sub) => $sub['parent_id'] == $mainCategory['id']);
        
        $subCategory = !empty($subCategoriesForMain) ? array_values($subCategoriesForMain)[0] : null;
        
        $stmt = $db->prepare("INSERT INTO listings 
            (user_id, category_id, subcategory_id, title, description, address, 
             distance_to_sea, has_parking, food_options, registry_number, 
             legal_form, phone, max_adults, max_children, max_guests_total, is_approved, created_at) 
            VALUES 
            (:user_id, :category_id, :subcategory_id, :title, :description, :address,
             :distance_to_sea, :has_parking, :food_options, :registry_number,
             :legal_form, :phone, :max_adults, :max_children, :max_guests_total, :is_approved, NOW())");
        
        $stmt->execute([
            ':user_id' => $users[$userIndex],
            ':category_id' => $mainCategory['id'],
            ':subcategory_id' => $subCategory ? $subCategory['id'] : null,
            ':title' => $listingData['title'],
            ':description' => $listingData['description'],
            ':address' => $listingData['address'],
            ':distance_to_sea' => $listingData['distance_to_sea'],
            ':has_parking' => (int)$listingData['has_parking'],
            ':food_options' => $listingData['food_options'],
            ':registry_number' => $listingData['registry_number'],
            ':legal_form' => $listingData['legal_form'],
            ':phone' => $listingData['phone'],
            ':max_adults' => $listingData['max_adults'],
            ':max_children' => $listingData['max_children'],
            ':max_guests_total' => $listingData['max_guests_total'],
            ':is_approved' => 1 // Одобряем для тестов
        ]);
        
        // Сохраняем ID созданного объявления
        $listingIds[] = $db->lastInsertId();
    }

    // Заполнение таблицы listing_prices тестовыми данными
    $months = ['май', 'июнь', 'июль', 'август', 'сентябрь'];
    
    foreach ($listingIds as $listingId) {
        // Генерируем базовую цену для этого объявления (от 1000 до 5000)
        $basePrice = rand(1000, 5000);
        
        foreach ($months as $month) {
            // Добавляем сезонный коэффициент к цене
            $seasonCoefficient = [
                'май' => 0.8,
                'июнь' => 1.0,
                'июль' => 1.5,
                'август' => 1.8,
                'сентябрь' => 0.9
            ];
            
            $price = $basePrice * $seasonCoefficient[$month];
            
            // Округляем до сотен
            $price = round($price / 100) * 100;
            
            $stmt = $db->prepare("INSERT INTO listing_prices (listing_id, month, amount) VALUES (?, ?, ?)");
            $stmt->execute([$listingId, $month, $price]);
        }
    }
    echo "База данных успешно заполнена категориями курортов и тестовыми объявлениями!";
if (!empty($listingIds)) {
        $reasons = ['booked', 'maintenance', 'other'];
        
        foreach ($listingIds as $listingId) {
            // Создаем несколько заблокированных дат для каждого объявления
            $blockedDatesCount = rand(3, 8); // От 3 до 8 заблокированных дат на объявление
            
            for ($i = 0; $i < $blockedDatesCount; $i++) {
                // Генерируем случайную дату в пределах 2024 года
                $randomMonth = rand(5, 9); // май-сентябрь
                $randomDay = rand(1, 28); // избегаем проблем с разным количеством дней в месяцах
                $date = sprintf('2024-%02d-%02d', $randomMonth, $randomDay);
                
                // Случайная причина блокировки
                $reason = $reasons[array_rand($reasons)];
                
                try {
                    $stmt = $db->prepare("INSERT INTO blocked_dates (listing_id, date, reason) VALUES (?, ?, ?)");
                    $stmt->execute([$listingId, $date, $reason]);
                } catch (PDOException $e) {
                    // Игнорируем ошибки дубликатов (UNIQUE constraint)
                    if ($e->getCode() != 23000) { // SQLite код для constraint violation
                        throw $e;
                    }
                }
            }
        }
        
        echo " Таблица blocked_dates также успешно заполнена!";
    }
} catch (PDOException $e) { 
    echo "Ошибка: " . $e->getMessage(); 
}
// Данные из HTML для основной таблицы categories
/*$categoriesData = [
    [
        'name' => 'Анапа',
        'url' => '/anapa/',
        'subcategories' => [
            ['name' => 'Анапа', 'url' => '/anapa/'],
            ['name' => 'Витязево', 'url' => '/anapa/vityazevo/'],
            ['name' => 'Джемете', 'url' => '/anapa/dzhemete/'],
            ['name' => 'Сукко', 'url' => '/anapa/sukko/'],
            ['name' => 'Благовещенская', 'url' => '/anapa/blagoveshchenskaya-otdyh/'],
            ['name' => 'Большой Утриш', 'url' => '/anapa/utrish/'],
            ['name' => 'Станица Анапская', 'url' => '/anapa/anapskaya/'],
            ['name' => 'Цибанобалка', 'url' => '/anapa/tsibanobalka/'],
            ['name' => 'Су-Псех', 'url' => '/anapa/su-psekh/'],
            ['name' => 'х. Нижняя Гостагайка', 'url' => '/anapa/nizhnyaya-gostagayka/'],
            ['name' => 'Пятихатки', 'url' => '/anapa/pyatikhatki/'],
            ['name' => 'х. Красный', 'url' => '/anapa/krasnyy/']
        ]
    ],
    [
        'name' => 'Геленджик',
        'url' => '/gelendzhik/',
        'subcategories' => [
            ['name' => 'Геленджик', 'url' => '/gelendzhik/'],
            ['name' => 'Голубая Бухта', 'url' => '/gelendzhik/golubaya_buhta/'],
            ['name' => 'Кабардинка', 'url' => '/gelendzhik/kabardinka/'],
            ['name' => 'Дивноморское', 'url' => '/gelendzhik/divnomorskoe-otdyh/'],
            ['name' => 'Архипо-Осиповка', 'url' => '/gelendzhik/arhipo-osipovka/'],
            ['name' => 'Джанхот', 'url' => '/gelendzhik/dzhanhot/'],
            ['name' => 'Прасковеевка', 'url' => '/gelendzhik/praskoveevka/'],
            ['name' => 'Бетта', 'url' => '/gelendzhik/betta/'],
            ['name' => 'Криница', 'url' => '/gelendzhik/krinica/'],
            ['name' => 'Береговое', 'url' => '/gelendzhik/beregovoe/'],
            ['name' => 'п. Возрождение', 'url' => '/gelendzhik/vozrozhdenie/'],
            ['name' => 'Адербиевка', 'url' => '/gelendzhik/aderbievka/']
        ]
    ],
    [
        'name' => 'Сочи',
        'url' => '/sochi/',
        'subcategories' => [
            ['name' => 'Сочи', 'url' => '/sochi/'],
            ['name' => 'Адлер', 'url' => '/sochi/adler-otdih/'],
            ['name' => 'Имеретинская бухта, Олимпийский парк', 'url' => '/sochi/imeretinka/'],
            ['name' => 'Лазаревское', 'url' => '/sochi/lazarevskoe/'],
            ['name' => 'Лоо', 'url' => '/sochi/loo-otdih/'],
            ['name' => 'Вардане', 'url' => '/sochi/vardane/'],
            ['name' => 'Кудепста', 'url' => '/sochi/kudepsta/'],
            ['name' => 'Солоники', 'url' => '/sochi/soloniki/'],
            ['name' => 'Аше', 'url' => '/sochi/ashe/'],
            ['name' => 'Вишневка', 'url' => '/sochi/vishnevka/'],
            ['name' => 'Якорная щель', 'url' => '/sochi/yakornaya_shchel/'],
            ['name' => 'Дагомыс', 'url' => '/sochi/dagomys/'],
            ['name' => 'Хоста', 'url' => '/sochi/khosta/'],
            ['name' => 'Каткова щель', 'url' => '/sochi/katkova_shel/'],
            ['name' => 'Волконка', 'url' => '/sochi/volkonka/'],
            ['name' => 'Головинка', 'url' => '/sochi/golovinka/'],
            ['name' => 'Совет-Квадже', 'url' => '/sochi/sovet-kvadzhe/'],
            ['name' => 'Нижняя Хобза', 'url' => '/sochi/nizhnyaya_hobza/'],
            ['name' => 'Макопсе', 'url' => '/sochi/makopse/'],
            ['name' => 'Зубова щель', 'url' => '/sochi/zubova_shchel/'],
            ['name' => 'Красная Поляна', 'url' => '/sochi/krasnaya-polyana/'],
            ['name' => 'Роза Хутор', 'url' => '/sochi/roza_khutor/'],
            ['name' => 'Эсто-Садок', 'url' => '/sochi/estosadok/']
        ]
    ],
    [
        'name' => 'Крым',
        'url' => '/krym/',
        'subcategories' => [
            ['name' => 'Крым', 'url' => '/krym/'],
            ['name' => 'Алупка', 'url' => '/krym/alupka-otdih/'],
            ['name' => 'Алушта', 'url' => '/krym/alushta-otdih/'],
            ['name' => 'Азовский берег Крыма', 'url' => '/krym/azovskiy-bereg-kryma/'],
            ['name' => 'Большая Алушта', 'url' => '/krym/bolshaya-alushta/'],
            ['name' => 'Балаклава', 'url' => '/krym/balaklava-otdih/'],
            ['name' => 'Бахчисарай', 'url' => '/krym/bakhchisaray-otdih/'],
            ['name' => 'Береговое', 'url' => '/krym/beregovoe/'],
            ['name' => 'Большая Ялта', 'url' => '/krym/bolshaya-yalta/'],
            ['name' => 'Гаспра', 'url' => '/krym/gaspra-otdih/'],
            ['name' => 'Гурзуф', 'url' => '/krym/gurzuf-otdih/'],
            ['name' => 'Евпатория', 'url' => '/krym/evpatoriya-otdih/'],
            ['name' => 'Заозерное', 'url' => '/krym/zaozernoe/'],
            ['name' => 'Казантип', 'url' => '/krym/kazantipskiy-zaliv/'],
            ['name' => 'Канака и Приветное', 'url' => '/krym/kanaka-privetnoe/'],
            ['name' => 'Кацивели', 'url' => '/krym/kaciveli/'],
            ['name' => 'Керчь', 'url' => '/krym/kerch-otdih/'],
            ['name' => 'Коктебель', 'url' => '/krym/koktebel-otdih/'],
            ['name' => 'Кореиз', 'url' => '/krym/koreiz-otdih/'],
            ['name' => 'Курортное', 'url' => '/krym/kurortnoe/'],
            ['name' => 'Ласпи', 'url' => '/krym/laspi/'],
            ['name' => 'Ливадия', 'url' => '/krym/livadiya-otdih/'],
            ['name' => 'Малореченское', 'url' => '/krym/malorechenskoe/'],
            ['name' => 'Мирный и Поповкака', 'url' => '/krym/mirnyy-popovka/'],
            ['name' => 'Мисхор', 'url' => '/krym/miskhor/'],
            ['name' => 'Морское', 'url' => '/krym/morskoe/'],
            ['name' => 'Николаевка', 'url' => '/krym/nikolaevka/'],
            ['name' => 'Новый Свет', 'url' => '/krym/novyj-svet/'],
            ['name' => 'Новофедоровка', 'url' => '/krym/novofedorovka-otdih/'],
            ['name' => 'Оленевка', 'url' => '/krym/olenevka/'],
            ['name' => 'Орджоникидзе', 'url' => '/krym/ordzhonikidze/'],
            ['name' => 'Партенит и Утес', 'url' => '/krym/partenit-otdih/'],
            ['name' => 'Песчаное', 'url' => '/krym/peschanoe/'],
            ['name' => 'Приморский', 'url' => '/krym/primorskiy/'],
            ['name' => 'Рыбачье', 'url' => '/krym/rybache/'],
            ['name' => 'Саки', 'url' => '/krym/saki-otdih/'],
            ['name' => 'Сатера', 'url' => '/krym/satera/'],
            ['name' => 'ССевастополь', 'url' => '/krym/sevastopol-otdih/'],
            ['name' => 'Семидворье', 'url' => '/krym/semidvore/'],
            ['name' => 'Симеиз', 'url' => '/krym/Simeiz/'],
            ['name' => 'Симферополь', 'url' => '/krym/simferopol-otdih/'],
            ['name' => 'Солнечногорское', 'url' => '/krym/solnechnogorskoe/'],
            ['name' => 'Судак', 'url' => '/krym/sudak/'],
            ['name' => 'Старый Крым', 'url' => '/krym/staryy-krym/'],
            ['name' => 'Феодосия', 'url' => '/krym/feodosia-otdih/'],
            ['name' => 'Форос', 'url' => '/krym/foros/'],
            ['name' => 'Черноморское', 'url' => '/krym/chernomorskoe-otdih/'],
            ['name' => 'Штормовое', 'url' => '/krym/shtormovoe/'],
            ['name' => 'Ялта', 'url' => '/krym/yalta-otdih/']
        ]
    ],
    [
        'name' => 'Абхазия',
        'url' => '/abhazia/',
        'subcategories' => [
            ['name' => 'Алахадзы', 'url' => '/abhazia/alakhadzy/'],
            ['name' => 'Аныханста (Гребешок)', 'url' => '/abhazia/anykhansta/'],
            ['name' => 'Багрипш (Холодная речка)', 'url' => '/abhazia/bagripsh-otdyh/'],
            ['name' => 'Гагра', 'url' => '/abhazia/gagra/'],
            ['name' => 'Гечрипш (Гячрыпш)', 'url' => '/abhazia/gechripsh/'],
            ['name' => 'Гудаута', 'url' => '/abhazia/gudauta/'],
            ['name' => 'Лдзаа', 'url' => '/abhazia/ldzaa/'],
            ['name' => 'Новый Афон', 'url' => '/abhazia/afon/'],
            ['name' => 'Кындыг', 'url' => '/abhazia/kyndyg/'],
            ['name' => 'Очамчира', 'url' => '/abhazia/ochamchira/'],
            ['name' => 'Пицунда', 'url' => '/abhazia/pitsunda-otdyh/'],
            ['name' => 'Приморское', 'url' => '/abhazia/primorskoe/'],
            ['name' => 'Сухум', 'url' => '/abhazia/sukhum/'],
            ['name' => 'Цандрипш', 'url' => '/abhazia/tsandripsh/']
        ]
    ],
    [
        'name' => 'Адыгея',
        'url' => '/adygeya/',
        'subcategories' => [
            ['name' => 'Афипсип', 'url' => '/adygeya/afipsip/'],
            ['name' => 'Гуамка', 'url' => '/adygeya/guamka/'],
            ['name' => 'Гузерипль', 'url' => '/adygeya/guzeripl/'],
            ['name' => 'Даховская', 'url' => '/adygeya/dahovskaya/'],
            ['name' => 'Лагонаки', 'url' => '/adygeya/lagonaki/'],
            ['name' => 'Майкоп', 'url' => '/adygeya/maykop/'],
            ['name' => 'Мезмай', 'url' => '/adygeya/mezmay/'],
            ['name' => 'Тульский', 'url' => '/adygeya/tulskiy/'],
            ['name' => 'Хаджох (Каменномостский)', 'url' => '/adygeya/khadzhokh/'],
            ['name' => 'Хамышки', 'url' => '/adygeya/hamyshki/']
        ]
    ],
    [
        'name' => 'Ейск',
        'url' => '/eysk/',
        'subcategories' => [
            ['name' => 'Ейск', 'url' => '/eysk/'],
            ['name' => 'Глафировка', 'url' => '/eysk/glafirovka/'],
            ['name' => 'Должанская', 'url' => '/eysk/dolzhanskaya/'],
            ['name' => 'Новодеревянковский', 'url' => '/eysk/novoderevyankovskiy/'],
            ['name' => 'Ясенская переправа', 'url' => '/eysk/yasenskaya_pereprava/']
        ]
    ],
    [
        'name' => 'Туапсе',
        'url' => '/tuapse/',
        'subcategories' => [
            ['name' => 'Туапсе', 'url' => '/tuapse/'],
            ['name' => 'Агой', 'url' => '/tuapse/agoy/'],
            ['name' => 'Бухта Инал', 'url' => '/tuapse/buhta_inal/'],
            ['name' => 'Гизель-Дере', 'url' => '/tuapse/gizel-dere/'],
            ['name' => 'Дедеркой', 'url' => '/tuapse/dederkoy/'],
            ['name' => 'Джубга', 'url' => '/tuapse/dzhubga-otdih/'],
            ['name' => 'Лермонтово', 'url' => '/tuapse/lermontovo/'],
            ['name' => 'Небуг', 'url' => '/tuapse/nebug-otdih/'],
            ['name' => 'Новомихайловский', 'url' => '/tuapse/novomihaylovskiy/'],
            ['name' => 'Ольгинка', 'url' => '/tuapse/olginka/'],
            ['name' => 'Пляхо', 'url' => '/tuapse/plyakho/']
        ]
    ],
    [
        'name' => 'Новороссийск',
        'url' => '/novorossiysk/',
        'subcategories' => [
            ['name' => 'Новороссийск', 'url' => '/novorossiysk/'],
            ['name' => 'Широкая Балка', 'url' => '/novorossiysk/shirokaya_balka/'],
            ['name' => 'Абрау-Дюрсо', 'url' => '/novorossiysk/abrau_dyurso/'],
            ['name' => 'Южная Озереевка', 'url' => '/novorossiysk/yuzhnaya_ozereyka/']
        ]
    ],
    [
        'name' => 'Азовское море',
        'url' => '/asov/',
        'subcategories' => [
            ['name' => 'Азовское море', 'url' => '/asov/'],
            ['name' => 'Голубицкая', 'url' => '/asov/golubickaya/'],
            ['name' => 'Кучугуры', 'url' => '/asov/kuchugury/'],
            ['name' => 'Пересыпь', 'url' => '/asov/peresyp/'],
            ['name' => 'Тамань', 'url' => '/asov/taman-otdyh/'],
            ['name' => 'Волна', 'url' => '/asov/volna/'],
            ['name' => 'Волна революции', 'url' => '/asov/volna-revolucii/'],
            ['name' => 'За Родину', 'url' => '/asov/za_rodinu/'],
            ['name' => 'Темрюк', 'url' => '/asov/temryuk-otdyh/'],
            ['name' => 'Веселовка', 'url' => '/asov/veselovka/'],
            ['name' => 'Сенной', 'url' => '/asov/sennoy/'],
            ['name' => 'п. Ильич', 'url' => '/asov/ilich_azov/'],
            ['name' => 'Чумбур-Коса', 'url' => '/asov/chumbur-kosa/'],
            ['name' => 'Приморско-Ахтарск', 'url' => '/asov/primorsko-akhtarsk/'],
            ['name' => 'Белосарайская коса', 'url' => '/asov/belosarayskaya-kosa/'],
            ['name' => 'Бердянск', 'url' => '/asov/berdyansk/'],
            ['name' => 'Гаркуша', 'url' => '/asov/garkusha-otdykh/'],
            ['name' => 'Геническ', 'url' => '/asov/genichesk/'],
            ['name' => 'Кирилловка', 'url' => '/asov/kirillovka/'],
            ['name' => 'Приморский', 'url' => '/asov/primorskiy/'],
            ['name' => 'Юбилейный', 'url' => '/asov/yubileynyy/']
        ]
    ],
    [
        'name' => 'КавМинВоды',
        'url' => '/kavminvody/',
        'subcategories' => [
            ['name' => 'Ессентуки', 'url' => '/kavminvody/essentuki-otdih/'],
            ['name' => 'Железноводск', 'url' => '/kavminvody/zheleznovodsk-otdih/'],
            ['name' => 'Кисловодск', 'url' => '/kavminvody/kislovodsk-otdih/'],
            ['name' => 'Минеральные Воды', 'url' => '/kavminvody/mineralnye-vody-otdih/']
        ]
    ],
    [
        'name' => 'Горячий Ключ',
        'url' => '/gorkluch/',
        'subcategories' => [
            ['name' => 'Горячий Ключ', 'url' => '/gorkluch/']
        ]
    ],
    [
        'name' => 'Краснодар',
        'url' => '/krasnodar/',
        'subcategories' => [
            ['name' => 'Краснодар', 'url' => '/krasnodar/'],
            ['name' => 'Краснодарский край', 'url' => '/krasnodar/krasnodarskiy-kray/'],
            ['name' => 'Апшеронский район', 'url' => '/krasnodar/apsheronskiy-rayon/'],
            ['name' => 'Мостовской', 'url' => '/krasnodar/mostovskoy/'],
            ['name' => 'Холмская', 'url' => '/krasnodar/kholmskaya/'],
            ['name' => 'Варениковская', 'url' => '/krasnodar/varenikovskaya/']
        ]
    ]
];

// Вставка основных категорий и подкатегорий
$mainCategoryIds = [];

foreach ($categoriesData as $categoryData) {
    // Вставляем основную категорию
    $stmt = $db->prepare("INSERT INTO categories (name, url) VALUES (:name, :url)");
    $stmt->execute([
        ':name' => $categoryData['name'],
        ':url' => $categoryData['url']
    ]);
$categoryId = $db->lastInsertId(); $mainCategoryIds[$categoryData['name']] = $categoryId;

    // Вставляем подкатегории
    foreach ($categoryData['subcategories'] as $subcategory) {
        $stmt = $db->prepare("INSERT INTO categories (name, url, parent_id) VALUES (:name, :url, :parent_id)");
        $stmt->execute([
            ':name' => $subcategory['name'],
            ':url' => $subcategory['url'],
            ':parent_id' => $categoryId
        ]);
    }
}

echo "База данных успешно заполнена категориями курортов!";
} catch (PDOException $e) { echo "Ошибка: " . $e->getMessage(); }*/

    // Добавление пользователей
    /*$users = [
        [
            'username' => 'admin',
            'password' => password_hash('1234567', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'admin'
        ],
        [
            'username' => 'user',
            'password' => password_hash('1111111', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'user'
        ],
        [
            'username' => 'usertmz',
            'password' => password_hash('11111111', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'user_tmz'
        ],
        [
            'username' => 'editortmz',
            'password' => password_hash('22222222', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'editor_tmz'
        ],
        [
            'username' => 'DPopov',
            'password' => password_hash('7777777', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'admin_tmz'
        ],
        [
            'username' => 'YBelko',
            'password' => password_hash('12345678', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'admin_tmz'
        ],
        [
            'username' => 'SVolov',
            'password' => password_hash('123456789', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'admin_tmz'
        ],
        [
            'username' => 'admintmz',
            'password' => password_hash('3333333', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'admin_tmz'
        ],
        [
            'username' => 'manager',
            'password' => password_hash('77777777', PASSWORD_DEFAULT), // хэшируем пароль
            'role' => 'manager_tmz'
        ]
    ];

    foreach ($users as $user) {
        $stmt = getDb()->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->execute([
            ':username' => $user['username'],
            ':password' => $user['password'],
            ':role' => $user['role']
        ]);
    }

    echo "Таблицы успешно заполнены данными.";
} catch (PDOException $e) {
    echo "Ошибка при добавлении данных: " . $e->getMessage();
}*/
