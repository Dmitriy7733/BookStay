<?php include 'app/includes/header.php'; ?>

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
    
    <form id="uploadForm" action="index.php?page=upload_form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="instructionTitle">Название инструкции</label>
            <input type="text" class="form-control" id="instructionTitle" name="title" required>
        </div>
        <div class="form-group">
            <label for="instructionFile">Выберите файл инструкции</label>
            <input type="file" class="form-control-file" id="instructionFile" name="file" required>
        </div>
        <div class="form-group">
            <label for="instructionDescription">Описание инструкции</label>
            <textarea class="form-control" id="instructionDescription" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="categorySelect">Выберите категорию</label>
            <select class="form-control" id="categorySelect" name="category_id" required>
                <option value="">-- Выберите категорию --</option>
            </select>
        </div>
        <div class="form-group">
            <label for="subcategorySelect">Выберите подкатегорию</label>
            <select class="form-control" id="subcategorySelect" name="subcategory_id" required>
                <option value="">-- Выберите подкатегорию --</option>
            </select>
        </div>
        <div class="form-group">
            <label for="captcha">Пожалуйста, введите текст с изображения:</label><br>
            <img src="../app/includes/captcha.php" alt="Капча" id="captchaImage">
            <button type="button" class="btn btn-secondary" onclick="refreshCaptcha()">Обновить капчу</button>
            <input type="text" class="form-control" id="captcha" name="captcha" required>
            <div id="captchaError" class="text-danger" style="display:none;"></div>
        </div>
        <button type="button" class="btn btn-success" onclick="submitUploadForm()">Загрузить инструкцию</button>
    </form>
</div>

<?php include 'app/includes/footer.php'; ?>

<script src="../assets/upload.js"></script>
<script>
function refreshCaptcha() {
    var captchaImage = document.getElementById('captchaImage');
    captchaImage.src = '../app/includes/captcha.php?' + Math.random();
}

function submitUploadForm() {
    var captchaInput = document.getElementById('captcha').value;
    var captchaError = document.getElementById('captchaError');

    fetch('../app/validate_captcha.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'captcha=' + encodeURIComponent(captchaInput)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('uploadForm').submit();
        } else {
            captchaError.textContent = data.message;
            captchaError.style.display = 'block';
        }
    });
}

</script>