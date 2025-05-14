<script>
	// Функция переключения видимости форм
	function toggleForm(formId) {
		const form = document.getElementById(formId);
		form.style.display = form.style.display === 'none' ? 'block' : 'none';
	}

	// Плавная прокрутка к якорям
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
			e.preventDefault();

			const targetId = this.getAttribute('href');
			const targetElement = document.querySelector(targetId);

			if (targetElement) {
				window.scrollTo({
					top: targetElement.offsetTop - 100,
					behavior: 'smooth'
				});

				// Подсветка на 2 секунды
				targetElement.classList.add('highlight');
				setTimeout(() => {
					targetElement.classList.remove('highlight');
				}, 2000);
			}
		});
	});

	// Инициализация обработчиков для таблиц
	function initTableHandlers() {
		document.querySelectorAll('section[id]').forEach(section => {
			const table = section.querySelector('table');
			if (!table) return;

			const selectAll = table.querySelector('.select-all');
			const checkboxes = table.querySelectorAll('.row-checkbox');
			const deleteBtn = section.querySelector('.delete-btn');
			const selectedCount = section.querySelector('.selected-count');

			// Обработчик для "Выбрать все"
			if (selectAll) {
				selectAll.addEventListener('change', function () {
					const isChecked = this.checked;
					checkboxes.forEach(checkbox => {
						checkbox.checked = isChecked;
					});
					updateDeleteButton();
				});
			}

			// Обработчики для чекбоксов строк
			checkboxes.forEach(checkbox => {
				checkbox.addEventListener('change', function () {
					updateDeleteButton();
					updateSelectAll();
				});
			});

			// Обновление кнопки удаления
			function updateDeleteButton() {
				const checkedCount = section.querySelectorAll('.row-checkbox:checked').length;
				if (deleteBtn) {
					deleteBtn.disabled = checkedCount === 0;
				}
				if (selectedCount) {
					selectedCount.textContent = checkedCount;
				}
			}

			// Обновление чекбокса "Выбрать все"
			function updateSelectAll() {
				if (!selectAll) return;

				const checkedCount = section.querySelectorAll('.row-checkbox:checked').length;
				const totalCount = checkboxes.length;

				selectAll.checked = checkedCount === totalCount;
				selectAll.indeterminate = checkedCount > 0 && checkedCount < totalCount;
			}

			// Обработчик кнопки удаления
			if (deleteBtn) {
				deleteBtn.addEventListener('click', function () {
					const checkedBoxes = section.querySelectorAll('.row-checkbox:checked');
					if (checkedBoxes.length === 0) {
						alert('Не выбраны записи для удаления');
						return;
					}

					if (!confirm(`Вы уверены, что хотите удалить ${checkedBoxes.length} записей?`)) {
						return;
					}

					const formData = new FormData();
					formData.append('entity_type', section.id);

					checkedBoxes.forEach(checkbox => {
						formData.append('ids[]', checkbox.value);
					});

					fetch('/tk/controllers/delete_entity.php', {
						method: 'POST',
						body: formData
					})
						.then(response => {
							if (response.redirected) {
								window.location.href = response.url;
							} else {
								return response.text();
							}
						})
						.then(data => {
							if (data) {
								window.location.reload();
							}
						})
						.catch(error => {
							console.error('Error:', error);
							alert('Произошла ошибка при удалении');
						});
				});
			}
		});
	}

	// Инициализация при загрузке страницы
	document.addEventListener('DOMContentLoaded', initTableHandlers);

	// Функция для отображения уведомлений
	function showNotification(message, type = 'success') {
		const notification = document.createElement('div');
		notification.className = `notification ${type}`;
		notification.textContent = message;
		document.body.appendChild(notification);

		setTimeout(() => {
			notification.classList.add('fade-out');
			setTimeout(() => {
				notification.remove();
			}, 500);
		}, 3000);
	}
</script>
</body>

</html>