// assets/search_tmz.js

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
        url: '../index.php?page=searchSpecialInstructions',
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
    
                console.log("Полученные результаты: ", results); // Отладка
    
                if (Array.isArray(results) && results.length > 0) {
                    results.forEach(function(special_instruction) {
                        searchResultsBody.append(`
                            <tr>
                                <td>
                                    <a href="#" class="instruction-link" data-file="/uploads_tmz/${special_instruction.filename}" data-id="${special_instruction.id}">${special_instruction.special_title}</a>
                                </td>
                                <td>${special_instruction.special_designation}</td>
                                <td>${special_instruction.category_name || 'Нет категории'}</td>
                                <td>${special_instruction.subcategory_name || 'Нет подкатегории'}</td>
                            </tr>
                        `);
                    });
                } else {
                    searchResultsBody.append('<tr><td colspan="4" class="text-center">Нет результатов для данного запроса.</td></tr>');
                }
            } catch (e) {
                console.error("JSON parse error: ", e);
                alert('Ошибка обработки данных от сервера.');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error);
            alert('Произошла ошибка при выполнении поиска.');
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
            url: '../index.php?page=fetchSpecialInstructions',
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
        $('#instructionsListModalLabel').text('Документы к подкатегории: ' + subcategoryName);

        if (response.success) {
            const instructions = response.instructions;
            if (instructions && instructions.length > 0) {
                instructions.forEach(function(instruction) {
                    instructionListModal.append(`
                            <tr>
                                <td><a href="#" class="instruction-link" data-file="/uploads_tmz/${instruction.filename}" data-id="${instruction.id}">${instruction.special_title}</a></td>
                                <td>${instruction.special_designation}</td>
                            </tr>
                        `);
                });
            } else {
                instructionListModal.append('<tr><td colspan="2">Нет доступной документации для этой подкатегории.</td></tr>');
            }
        } else {
            instructionListModal.append(`<tr><td colspan="2">${response.message}</td></tr>`);
        }

        $('#instructionsListModal').modal('show');
    }
});