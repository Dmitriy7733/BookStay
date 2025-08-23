$(document).on('click', '#downloadButton', function(e) {
    e.preventDefault();
    
    if (currentFileUrl) {
        // Создаем временную ссылку и инициируем скачивание
        var link = document.createElement('a');
        link.href = currentFileUrl; // Используем сохраненный URL
        link.download = ''; 
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        alert('Файл для скачивания недоступен.');
    }
});