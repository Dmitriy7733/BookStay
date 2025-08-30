// Функция для изменения окончания названия места
function getCorrectPrepositionForm(placeName) {
    // Список исключений и особых случаев
    const exceptions = {
        'Анапа': 'Анапе',
        'Сочи': 'Сочи',
        'Геленджик': 'Геленджике',
        'Крым': 'Крыму',
        'Абхазия': 'Абхазии',
        'Турция': 'Турции',
        'Египет': 'Египте',
        'Тайланд': 'Тайланде',
        'Греция': 'Греции',
        'Испания': 'Испании',
        'Италия': 'Италии',
        'Абрау-Дюрсо': 'Абрау-Дюрсо',
        'Ростов-на-Дону': 'Ростове-на-Дону'
    };
    
    // Проверяем, есть ли место в исключениях
    if (exceptions[placeName]) {
        return exceptions[placeName];
    }
    
    // Обрабатываем названия с дефисами
    if (placeName.includes('-')) {
        const parts = placeName.split('-');
        const processedParts = parts.map((part, index) => {
            // Первую часть обрабатываем по правилам, остальные оставляем как есть
            if (index === 0) {
                return getSimpleForm(part);
            }
            return part;
        });
        return processedParts.join('-');
    }
    
    // Обрабатываем простые названия
    return getSimpleForm(placeName);
}

// Вспомогательная функция для обработки простых названий
function getSimpleForm(name) {
    if (name.endsWith('а') && !name.endsWith('ска') && !name.endsWith('цка')) {
        return name.slice(0, -1) + 'е'; // Москва -> Москве
    } else if (name.endsWith('я')) {
        return name.slice(0, -1) + 'е'; // Казань -> Казани (но Казань - исключение)
    } else if (name.endsWith('ск') || name.endsWith('цк')) {
        return name + 'е'; // Новороссийск -> Новороссийске
    } else if (name.endsWith('ь')) {
        return name.slice.slice(0, -1) + 'и'; // Тверь -> Твери
    } else if (name.endsWith('ое') || name.endsWith('ее') || name.endsWith('ие')) {
        return name; // Береговое -> Береговое (оставляем как есть)
    } else if (name.endsWith('е') || name.endsWith('и') || name.endsWith('ы')) {
        return name; // Уже в правильной форме
    } else {
        return name + 'е'; // По умолчанию добавляем "е"
    }
}
