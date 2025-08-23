var currentFileUrl = ''; // Переменная для хранения URL текущего файла
    var currentInstructionId; // Переменная для хранения ID инструкции
    var openInstructionModals = 0; // Объявляем переменную openInstructionModals

$(document).on('click', '.instruction-link', function(e) {
    e.preventDefault();
    console.log("Instruction link clicked."); // Лог для проверки
    currentFileUrl = $(this).data('file').replace('http://', 'https://');
    currentInstructionId = $(this).data('id'); // Получаем ID инструкции
    $('#instructionModal').modal('show');
    openInstructionModals++;
    $('#instructionContent').html(`<iframe id="instructionIframe" src="${currentFileUrl}" width="100%" height="400px" style="border:none;"></iframe>`);
    // Устанавливаем значение instructionId в скрытое поле формы жалобы
    $('#complaintInstructionId').val(currentInstructionId);
});