function openComplaintModal(instructionId) {
    $('#complaintInstructionId').val(instructionId);
    $('#complaintModal').modal('show');
}

$(document).on('submit', '#complaintForm', function(e) {
    e.preventDefault(); // Предотвращаем обычное поведение формы
    var complaintText = $('#complaintText').val();
    var instructionId = $('#complaintInstructionId').val();
    var userId = $('#userId').val();
    console.log("Submitting complaint for Instruction ID: ", instructionId);

    // Проверяем корректность ID инструкции
    if (!instructionId || instructionId === "0") {
        alert("ID инструкции не найден. Пожалуйста, попробуйте снова.");
        return;
    }

    $.ajax({
        url: '../index.php?page=submit_complaint',
        type: 'POST',
        data: {
            instruction_id: instructionId,
            complaint_text: complaintText,
            user_id: userId
        },
        success: function(response) {
            console.log("Server response: ", response); // Добавлено для отладки
            let result;
            try {
                result = JSON.parse(response);
            } catch (e) {
                console.error('JSON Parse Error: ', e);
                alert('Ошибка обработки ответа сервера. Убедитесь, что сервер возвращает корректный JSON.');
                return;
            }
            if (result.success) {
                alert('Жалоба успешно отправлена!');
                $('#complaintModal').modal('hide');
            } else {
                alert(result.message || 'Произошла ошибка при отправке жалобы.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', xhr.responseText);
            alert('Произошла ошибка: ' + error);
        }
    });
});