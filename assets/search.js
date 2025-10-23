// assets/search.js

        // Функция для отладки поиска
function debugSearch() {
    console.log('Current search state:');
    console.log('City ID:', $('#city-id-input').val());
    console.log('City Name:', $('#city-input').val());
    console.log('Date From:', $('#dateFrom-input').val());
    console.log('Date To:', $('#dateTo-input').val());
    console.log('Adults:', $('#adult-input').val());
    console.log('Children:', $('#child-input').val());
}

// Обработчик отправки формы поиска
$('#searchMainForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        cityId: $('#city-id-input').val(),
        dateFrom: $('#dateFrom-input').val(),
        dateTo: $('#dateTo-input').val(),
        adult: $('#adult-input').val(),
        child: $('#child-input').val(),
        priceMin: $('#priceMinInput').val()|| null,
        priceMax: $('#priceMaxInput').val()|| null
    };
    console.log('Search form data:', formData); // ДЛЯ ОТЛАДКИ
    // Выполняем поиск
    performSearch(formData);
});
// Функция выполнения поиска
function performSearch(formData) {
    // Валидация обязательных полей
    if (!formData.cityId) {
        alert('Пожалуйста, выберите направление');
        return;
    }

    console.log('Search data with prices:', formData); // Для отладки

    $.ajax({
        url: '../index.php?page=search',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success && response.listings) {
                displaySearchResults(response.listings, response.searchParams, response.pagination);
            } else {
                alert(response.message || 'Объявления не найдены');
                $('#listingsContent').html('<div class="col-12"><p class="text-center">Объявления не найдены</p></div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('Ошибка соединения с сервером');
            $('#listingsContent').html('<div class="col-12"><p class="text-center">Ошибка загрузки данных</p></div>');
        }
    });
}


// Обработчик клика по полю цены
$('#priceField .field-text').on('click', function(e) {
       e.stopPropagation();
});

// Обработчик быстрых пресетов цен
$(document).on('click', '.price-preset', function() {
    const min = $(this).data('min');
    const max = $(this).data('max');

    $('#priceMinInput').val(min);
    $('#priceMaxInput').val(max);

    // Обновляем отображение
    updatePriceDisplay(min, max);

    // Активируем выбранный пресет
    $('.price-preset').removeClass('active');
    $(this).addClass('active');
});

$(document).on('click', '#applyPrice', function(e) {
    e.preventDefault();
    const minPrice = $('#priceMinInput').val();
    const maxPrice = $('#priceMaxInput').val();

    console.log('Before apply - Min:', minPrice, 'Max:', maxPrice);
    
    // Обновляем отображение
    updatePriceDisplay(minPrice, maxPrice);

    console.log('After apply:');
    debugPriceState();

    // Закрываем dropdown
    $('#priceDropdownButton').dropdown('hide');
});
// Обработчик для сброса фильтра цен
$(document).on('click', '#resetPrice', function() {
    $('#priceMinInput').val('');
    $('#priceMaxInput').val('');
    $('#price-min-input').val('');
    $('#price-max-input').val('');
    $('.price-preset').removeClass('active');
    updatePriceDisplay('', '');
    $('#priceDropdownButton').dropdown('hide');
    
    // Если есть активные фильтры - обновляем их отображение
    if ($('.active-filters').length > 0) {
        // Можно вызвать перерисовку активных фильтров или удалить блок
        $('.active-filters').remove();
    }
});
// Функция обновления отображаемого значения цены
function updatePriceDisplay(minPrice, maxPrice) {
    const $priceValue = $('#priceValue');
    const $pricePlaceholder = $('#pricePlaceholder');

    // Обновляем скрытые поля
    $('#price-min-input').val(minPrice);
    $('#price-max-input').val(maxPrice);

    if (!minPrice && !maxPrice) {
        $priceValue.hide();
        $pricePlaceholder.show().text('Любая цена');
    } else {
        let displayText = '';
        if (minPrice && maxPrice) {
            displayText = `${formatPrice(minPrice)} - ${formatPrice(maxPrice)} руб.`;
        } else if (minPrice) {
            displayText = `от ${formatPrice(minPrice)} руб.`;
        } else if (maxPrice) {
            displayText = `до ${formatPrice(maxPrice)} руб.`;
        }
        $priceValue.text(displayText).show();
        $pricePlaceholder.hide();
    }
}
function debugPriceState() {
    console.log('Price Min Input:', $('#priceMinInput').val());
    console.log('Price Max Input:', $('#priceMaxInput').val());
    console.log('Hidden Price Min:', $('#price-min-input').val());
    console.log('Hidden Price Max:', $('#price-max-input').val());
}


// Функция форматирования цены
function formatPrice(price) {
    return parseInt(price || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

// Закрытие dropdown при клике вне его
$(document).click(function(e) {
    if (!$(e.target).closest('.search-field, .dropdown-menu-custom').length) {
        $('.dropdown-menu-custom').removeClass('show-dropdown');
    }
});

// Функция отображения результатов поиска
function displaySearchResults(listings, searchParams, pagination) {
    // Скрываем категории и показываем контейнер объявлений
    $('#categoriesContainer').hide();
    $('#listingsContainer').show();
    
    // Показываем заголовок поиска, скрываем заголовок подкатегорий
    $('#searchResultsTitle').show();
    $('#subcategoryTitle').hide();
    
    // Обновляем основной заголовок
    const cityName = searchParams.cityName;
    const correctForm = getCorrectPrepositionForm(cityName);
    $('#mainTitle').text(`Результаты поиска: отдых в ${correctForm}`);
    displayActiveFilters(searchParams);
    // Отображаем объявления
    displayListings(listings, cityName);
    
    // Отображаем пагинацию, если есть
    if (pagination && pagination.totalPages > 1) {
        displayPagination(pagination);
    } else {
        $('#searchPagination').hide();
    }
}

function displayActiveFilters(searchParams) {
    let activeFilters = [];
    
    // Удаляем предыдущий блок активных фильтров
    $('.active-filters').remove();
    
    // Фильтр по цене
    if (searchParams.priceMin || searchParams.priceMax) {
        let priceText = 'Цена: ';
        if (searchParams.priceMin && searchParams.priceMax) {
            priceText += `${formatPrice(searchParams.priceMin)} - ${formatPrice(searchParams.priceMax)} руб.`;
        } else if (searchParams.priceMin) {
            priceText += `от ${formatPrice(searchParams.priceMin)} руб.`;
        } else if (searchParams.priceMax) {
            priceText += `до ${formatPrice(searchParams.priceMax)} руб.`;
        }
        activeFilters.push(priceText);
    }
    
    // Фильтр по датам
    if (searchParams.dateFrom && searchParams.dateTo) {
        activeFilters.push(`Даты: ${searchParams.dateFrom} - ${searchParams.dateTo}`);
    }
    
    // Фильтр по гостям
    const guests = [];
    if (parseInt(searchParams.adults) > 0) {
        guests.push(`${searchParams.adults} взр.`);
    }
    if (parseInt(searchParams.children) > 0) {
        guests.push(`${searchParams.children} дет.`);
    }
    if (guests.length > 0) {
        activeFilters.push(`Гости: ${guests.join(', ')}`);
    }
    
    if (activeFilters.length > 0) {
        let filtersHtml = `
            <div class="active-filters mb-3 p-3 bg-light rounded">
                <strong>Активные фильтры:</strong>
                ${activeFilters.map(filter => `<span class="badge badge-primary ml-2">${filter}</span>`).join('')}
                <button class="btn btn-sm btn-outline-secondary ml-2" id="clearAllFilters">Очистить все</button>
            </div>
        `;
        
        $('#listingsContent').before(filtersHtml);
        
        $('#clearAllFilters').click(function() {
            resetAllFilters();
            // Удаляем блок активных фильтров
            $('.active-filters').remove();
            
            // Повторяем поиск без фильтров
            performSearch({
                cityId: searchParams.cityId,
                dateFrom: searchParams.dateFrom,
                dateTo: searchParams.dateTo,
                adult: searchParams.adults,
                child: searchParams.children
            });
        });
    }
}

// Функция сброса всех фильтров
function resetAllFilters() {
    $('#priceMinInput').val('');
    $('#priceMaxInput').val('');
    $('#price-min-input').val('');
    $('#price-max-input').val('');
    $('.price-preset').removeClass('active');
    updatePriceDisplay('', '');
    
    // Также сбросить можно другие фильтры если нужно
    // $('#dateFrom-input').val('');
    // $('#dateTo-input').val('');
}

// Функция для автозаполнения направления с выпадающими подсказками
function setupCityAutocomplete() {
    const $cityInput = $('#city-input');
    const $cityIdInput = $('#city-id-input');
    let isHandlingSuggestionClick = false;

    // Создаем контейнер для подсказок
    const $suggestionsContainer = $('<div class="inline-suggestions"></div>');
    $cityInput.closest('.search-field').append($suggestionsContainer);

    $cityInput.on('input focus', function() {
        const query = $(this).val().trim();
        clearTimeout($(this).data('timeoutId'));

        if (query.length < 2) {
            $suggestionsContainer.hide().empty();
            $cityIdInput.val('');
            return;
        }

        const timeoutId = setTimeout(() => {
            $.ajax({
                url: '../index.php?page=autocomplete_cities',
                type: 'POST',
                data: { query: query },
                dataType: 'json',
                success: function(cities) {
                    displayInlineSuggestions(cities);
                },
                error: function() {
                    $suggestionsContainer.hide().empty();
                }
            });
        }, 300);

        $(this).data('timeoutId', timeoutId);
    });

    function displayInlineSuggestions(cities) {
        if (!cities || cities.length === 0) {
            $suggestionsContainer.hide().empty();
            $cityIdInput.val('');
            return;
        }

        let suggestionsHtml = '';
        cities.slice(0, 5).forEach(city => {
            const regionInfo = city.region ? ` <span class="region-text">${city.region}</span>` : '';
            suggestionsHtml += `
                <div class="inline-suggestion-item" data-city-id="${city.id}" data-city-name="${city.name}">
                    <i class="fas fa-map-marker-alt suggestion-icon"></i>
                    <span class="suggestion-text">
                        <strong>${city.name}</strong>${regionInfo}
                    </span>
                </div>
            `;
        });
        $suggestionsContainer.html(suggestionsHtml).show();
    }

    // Обработчик клика по подсказке с задержкой
    $suggestionsContainer.on('click', '.inline-suggestion-item', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        isHandlingSuggestionClick = true;
        
        const cityId = $(this).data('city-id');
        const cityName = $(this).data('city-name');
        $cityInput.val(cityName);
        $cityIdInput.val(cityId);
        $suggestionsContainer.hide();
        
        // Сбрасываем флаг после небольшой задержки
        setTimeout(() => {
            isHandlingSuggestionClick = false;
        }, 100);
    });

    // Обработчик клика по полю ввода
    $cityInput.on('click', function(e) {
        e.stopPropagation();
        if ($(this).val().trim().length >= 2 && !$suggestionsContainer.is(':visible')) {
            $(this).trigger('input');
        }
    });
}

// Инициализация при загрузке
$(document).ready(function() {
    setupCityAutocomplete();

    // Улучшенный обработчик клика вне подсказок
    $(document).on('click', function(e) {
        const $target = $(e.target);
        const isCityInput = $target.is('#city-input') || $target.closest('#city-input').length > 0;
        const isSuggestion = $target.closest('.inline-suggestions').length > 0;
        
        if (!isCityInput && !isSuggestion) {
            $('.inline-suggestions').hide();
        }
    });

    // Обработка ESC
    $('#city-input').on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('.inline-suggestions').hide();
            $(this).blur(); // Убрать фокус с поля
        }
    });
});
// Обработчик клика по пагинации
$(document).on('click', '#searchPagination .page-link', function(e) {
    e.preventDefault();
    const page = $(this).data('page');
    
    // Получаем текущие параметры поиска
    const searchParams = {
        cityId: $('#city-id-input').val(),
        dateFrom: $('#dateFrom-input').val(),
        dateTo: $('#dateTo-input').val(),
        adult: $('#adult-input').val(),
        child: $('#child-input').val(),
        page: page
    };
    
    // Выполняем поиск с новой страницей
    performSearch(searchParams);
});
