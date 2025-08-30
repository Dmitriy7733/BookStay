<?php
/*function getDb() : PDO|null {
    static $db = null;
    if (is_null($db)) {
        $dbPath = dirname(__DIR__, 1) . '/instructions.db';
        $db = new PDO('sqlite:' . $dbPath);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->exec("PRAGMA foreign_keys = ON");
    }
    return $db;
}*/
function getDb() : PDO|null {
    static $db = null;
    if (is_null($db)) {
        try {
            // Настройки подключения к MySQL
            $host = 'localhost'; // или IP-адрес сервера
            $dbname = 'bookstay_db'; // имя вашей базы данных
            $username = 'root'; // имя пользователя MySQL
            $password = '1234567'; // пароль пользователя
            
            // Создание подключения к MySQL
            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            
            // Установка атрибутов PDO
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            // Для MySQL foreign keys включены по умолчанию, но можно проверить
            $db->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            // Сообщение об успешном подключении
            /*echo "<div style='background-color: #d4edda; color: #155724; padding: 10px; margin: 10px; border: 1px solid # #c3e6cb; border-radius: 4px;'>
                    ✅ Успешное подключение к базе данных!
                  </div>";*/
            
        } catch (PDOException $e) {
            // Обработка ошибок подключения
            error_log("Database connection failed: " . $e->getMessage());
            /*echo "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 4px;'>
                    ❌ Ошибка подключения к базе данных: " . htmlspecialchars($e->getMessage()) . "
                  </div>";*/
            return null;
        }
    }
    return $db;
}
$db = getDb();