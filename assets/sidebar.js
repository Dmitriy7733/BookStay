// assets/sidebar.js
// Обработчики для боковой панели
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация боковой панели
    initSidebar();
    
    // Обработчики для подкатеготегорий в боковой панели
    document.querySelectorAll('.nav-subcategory-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const subcategoryId = this.dataset.subcategoryId;
            const subcategoryName = this.dataset.subcategoryName;
            
            // Закрываем мобильную панель если открыта
            closeMobileSidebar();
            
            // Загружаем объявления
            loadListingsBySubcategory(subcategoryId, subcategoryName);
        });
    });
});

function initSidebar() {
    const mobileToggle = document.querySelector('.sidebar-mobile-toggle');
    const sidebar = document.querySelector('.sidebar-categories');
    const overlay = document.querySelector('.sidebar-overlay');
    
    // Создаем оверлей если его нет
    if (!overlay && document.querySelector('.sidebar-overlay')) {
        const newOverlay = document.createElement('div');
        newOverlay.className = 'sidebar-overlay';
        document.body.appendChild(newOverlay);
    }
    
    const actualOverlay = document.querySelector('.sidebar-overlay');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleMobileSidebar);
    }
    
    if (actualOverlay) {
        actualOverlay.addEventListener('click', closeMobileSidebar);
    }
    
    // Обработчики для категорий в боковой панели
    document.querySelectorAll('.nav-category-header').forEach(header => {
        header.addEventListener('click', function() {
            const subcategories = this.nextElementSibling;
            if (!subcategories) return;
            
            const isExpanded = subcategories.classList.contains('expanded');
            
            // Закрываем все остальные
            document.querySelectorAll('.nav-subcategories').forEach(sub => {
                sub.classList.remove('expanded');
            });
            document.querySelectorAll('.nav-category-header').forEach(h => {
                h.classList.remove('active');
            });
            
            // Открываем текущую, если не была открыта
            if (!isExpanded) {
                subcategories.classList.add('expanded');
                this.classList.add('active');
            }
        });
    });
}

function toggleMobileSidebar() {
    const sidebar = document.querySelector('.sidebar-categories');
    const overlay = document.querySelector('.sidebar-overlay');
    console.log('Кнопка нажата');
    if (sidebar.classList.contains('mobile-open')) {
        closeMobileSidebar();
    } else {
        openMobileSidebar();
    }
}

function openMobileSidebar() {
    const sidebar = document.querySelector('.sidebar-categories');
    const overlay = document.querySelector('.sidebar-overlay');
    sidebar.classList.remove('d-none'); // убрать скрытие
    sidebar.classList.add('mobile-open');
    if (overlay) overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeMobileSidebar() {
    const sidebar = document.querySelector('.sidebar-categories');
    const overlay = document.querySelector('.sidebar-overlay');
    
    sidebar.classList.remove('mobile-open');
    if (overlay) overlay.classList.remove('active');
    document.body.style.overflow = '';
}