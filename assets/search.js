// assets/search.js

let debounceTimer;
const debounceDelay = 300; // 300ms задержка

document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const searchTerm = this.value;
        if (searchTerm.length > 2) { // Минимум 3 символа для поиска
            searchInstructions(searchTerm);
        } else {
            document.getElementById('searchResults').innerHTML = '';
        }
    }, debounceDelay);
});
document.getElementById('clearButton').addEventListener('click', function() {
    document.getElementById('searchInput').value = ''; // Очищаем поле ввода
    document.getElementById('searchResults').innerHTML = ''; // Очищаем результаты
});
function searchInstructions(searchTerm) {
    $.ajax({
        url: '../index.php?page=search_instructions',
        type: 'POST',
        data: { search_term: searchTerm },
        success: function(response) {
            try {
                let results = JSON.parse(response);
                const searchResultsBody = $('#searchResults');
                searchResultsBody.empty(); // Очищаем предыдущие результаты

                if (results.error) {
                    alert(results.error);
                    return;
                }

                if (Array.isArray(results) && results.length > 0) {
                    results.forEach(function(instruction) {
                        searchResultsBody.append(`
                            <tr>
                                <td>
                                    <a href="#" class="instruction-link" data-file="/uploads/${instruction.filename}" data-id="${instruction.id}">${instruction.title}</a>
                                </td>
                                <td>${instruction.description}</td>
                            </tr>
                        `);
                    });
                } else {
                    searchResultsBody.append('<tr><td colspan="2" class="text-center">Нет результатов для данного запроса.</td></tr>');
                }
            } catch (e) {
                console.error("JSON parse error: ", e);
                alert('Ошибка обработки данных от сервера.');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error);
            console.error("Response Text: ", xhr.responseText);
            
            let errorMsg = 'Произошла ошибка при выполнении поиска.';
            try {
                const jsonResponse = JSON.parse(xhr.responseText);
                if (jsonResponse.error) {
                    errorMsg = jsonResponse.error; // Используем ошибку из ответа сервера
                }
            } catch (e) {
                // Если не удается разобрать JSON, используем стандартное сообщение
            }
            
            alert(errorMsg);
        }
    });
}


$(document).ready(function() {
    $(document).on('click', '.dropdown-item', function(e) {
        e.preventDefault();
        const subcategoryId = $(this).data('subcategory-id');
        const subcategoryName = $(this).text();
        console.log('Subcategory ID:', subcategoryId); // Отладочный вывод
        fetchInstructions(subcategoryId, subcategoryName);
    });

    function fetchInstructions(subcategoryId, subcategoryName) {
        if (!subcategoryId) {
            alert("ID подкатегории не указан.");
            return;
        }

        $.ajax({
            url: '../index.php?page=fetch_instructions',
            type: 'POST',
            data: { subcategory_id: subcategoryId },
            dataType: 'json',
            success: function(response) {
                console.log('Response from server:', response); // Отладочный вывод
                populateModal(response, subcategoryName);
            },
            error: function() {
                alert('Произошла ошибка при загрузке инструкций.');
            }
        });
    }

    function populateModal(response, subcategoryName) {
        const instructionListModal = $('#instructionListModal');
        instructionListModal.empty();
        $('#instructionsListModalLabel').text('Инструкции к ' + subcategoryName);

        if (response.success) {
            const instructions = response.instructions;
            if (instructions && instructions.length > 0) {
                instructions.forEach(function(instruction) {
                    instructionListModal.append(`
                        <tr>
                            <td><a href="#" class="instruction-link" data-file="/uploads/${instruction.filename}" data-id="${instruction.id}">${instruction.title}</a></td>
                            <td>${instruction.description}</td>
                        </tr>
                    `);
                });
            } else {
                instructionListModal.append('<tr><td colspan="2">Нет доступных инструкций для этой подкатегории.</td></tr>');
            }
        } else {
            instructionListModal.append(`<tr><td colspan="2">${response.message}</td></tr>`);
        }

        $('#instructionsListModal').modal('show');
    }
});