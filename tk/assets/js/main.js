// Основные функции JavaScript
document.addEventListener('DOMContentLoaded', function () {
    initTableHandlers();
    initForms();
    initNotifications();
    initSidebar();
});

// Инициализация боковой панели
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    // Закрытие по клику вне панели
    if (overlay) {
        overlay.addEventListener('click', closeMobileSidebar);
    }

    // Закрытие по ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeMobileSidebar();
        }
    });

    // Адаптивное поведение
    function handleResize() {
        if (window.innerWidth >= 1025) {
            // На десктопе всегда показываем sidebar
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Обработчик изменения размера окна
    window.addEventListener('resize', handleResize);

    // Автоматическое закрытие sidebar при клике на ссылку на мобильных
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function () {
            if (window.innerWidth < 1025) {
                closeMobileSidebar();
            }
        });
    });
}

// Переключение компактного режима (десктоп)
function toggleSidebarCompact() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('compact');

    // Сохраняем состояние в localStorage
    localStorage.setItem('sidebarCompact', sidebar.classList.contains('compact'));
}

// Мобильное меню
function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');

    if (sidebar.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

function closeMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// Восстановление состояния sidebar при загрузке
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const isCompact = localStorage.getItem('sidebarCompact') === 'true';

    if (isCompact && window.innerWidth >= 1025) {
        sidebar.classList.add('compact');
    }

    initSidebar();
});

// Уведомления
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notification);

    // Анимация появления
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    // Автоматическое скрытие
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 5000);
}

function initNotifications() {
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 15px 20px;
            min-width: 300px;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.5s ease;
            z-index: 9999;
            border-left: 4px solid;
        }
        
        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification.success {
            border-left-color: var(--success);
        }
        
        .notification.error {
            border-left-color: var(--danger);
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .notification-content i {
            font-size: 18px;
        }
        
        .notification.success i {
            color: var(--success);
        }
        
        .notification.error i {
            color: var(--danger);
        }
    `;
    document.head.appendChild(style);
}

// Обработчики таблиц
function initTableHandlers() {
    document.querySelectorAll('.data-table').forEach(table => {
        const selectAll = table.querySelector('.select-all');
        const checkboxes = table.querySelectorAll('.row-checkbox');
        const deleteBtn = table.closest('.table-wrapper').querySelector('.delete-btn');
        const selectedCount = table.closest('.table-wrapper').querySelector('.selected-count');

        if (selectAll && checkboxes.length > 0) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateDeleteButton();
            });
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                updateSelectAll();
                updateDeleteButton();
            });
        });

        function updateDeleteButton() {
            const checkedCount = table.querySelectorAll('.row-checkbox:checked').length;
            if (deleteBtn) {
                deleteBtn.disabled = checkedCount === 0;
            }
            if (selectedCount) {
                selectedCount.textContent = checkedCount;
            }
        }

        function updateSelectAll() {
            if (!selectAll) return;

            const checkedCount = table.querySelectorAll('.row-checkbox:checked').length;
            const totalCount = checkboxes.length;

            selectAll.checked = checkedCount === totalCount;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        }
    });
}

// Обработчики форм
function initForms() {
    // Переключение видимости форм
    window.toggleForm = function (formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    };

    // Валидация форм
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = 'var(--danger)';
                    isValid = false;

                    // Показываем подсказку
                    let errorDiv = field.nextElementSibling;
                    if (!errorDiv || !errorDiv.classList.contains('field-error')) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'field-error';
                        errorDiv.style.color = 'var(--danger)';
                        errorDiv.style.fontSize = '12px';
                        errorDiv.style.marginTop = '5px';
                        field.parentNode.appendChild(errorDiv);
                    }
                    errorDiv.textContent = 'Это поле обязательно для заполнения';
                } else {
                    field.style.borderColor = '';
                    const errorDiv = field.nextElementSibling;
                    if (errorDiv && errorDiv.classList.contains('field-error')) {
                        errorDiv.remove();
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Пожалуйста, заполните все обязательные поля', 'error');
            }
        });
    });
}

// Вспомогательные функции
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// API функции
async function apiRequest(endpoint, options = {}) {
    try {
        const response = await fetch(`/tk/api/v1/${endpoint}`, {
            headers: {
                'Content-Type': 'application/json',
                ...options.headers
            },
            ...options
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('API request failed:', error);
        showNotification('Ошибка соединения с сервером', 'error');
        throw error;
    }
}