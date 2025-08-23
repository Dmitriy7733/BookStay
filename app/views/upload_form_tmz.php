<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor_tmz') {
    // Перенаправить на страницу входа или вывести сообщение об ошибке
    header('Location: index.php?page=login');
    exit();
}
include 'app/includes/header_editor.php';
?>

<div class="container mt-5">
    <h2>Загрузка инструкции</h2>
    <?php
    // Отображение сообщений об ошибках и успехах
    if (isset($_SESSION['error'])) {
        echo "<div id='error-message' style='color: red;'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<div id='success-message' style='color: green;'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
    }
    ?>
    <form action="index.php?page=upload_form_tmz" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="instructionTitle">Название инструкции</label>
            <input type="text" class="form-control" id="instructionTitle" name="special_title" required>
        </div>
        <div class="form-group">
            <label for="instructionFile">Выберите файл, который хотите добавить</label>
            <input type="file" class="form-control-file" id="instructionFile" name="file" required>
        </div>
        <div class="form-group">
            <label for="instructionDesignation">Обозначение</label>
            <textarea class="form-control" id="instructionDesignation" name="special_designation" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="categorySelect">Выберите категорию</label>
            <select class="form-control" id="categorySelect" name="special_category_id" required>
                <option value="">-- Выберите категорию --</option>
            </select>
        </div>
        <div class="form-group">
            <label for="subcategorySelect">Выберите подкатегорию</label>
            <select class="form-control" id="subcategorySelect" name="special_subcategory_id" required>
                <option value="">-- Выберите подкатегорию --</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Загрузить инструкцию</button>
    </form>
</div>

<?php include 'app/includes/footer_tmz.php'; ?>
<script src="../assets/upload_tmz.js"></script>
