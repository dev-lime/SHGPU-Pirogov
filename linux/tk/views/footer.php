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

	// Обработчики для каждой таблицы на странице
	document.querySelectorAll('.table-container').forEach(tableContainer => {
		const selectAllCheckbox = tableContainer.querySelector('.select-all');
		const rowCheckboxes = tableContainer.querySelectorAll('.row-checkbox');
		const deleteBtn = tableContainer.querySelector('.delete-btn');
		const selectedCount = tableContainer.querySelector('.selected-count');
		const deleteForm = tableContainer.closest('section').querySelector('.delete-form');
		const entityType = tableContainer.querySelector('input[name="entity_type"]').value;

		// Обработчик для "Выбрать все"
		if (selectAllCheckbox) {
			selectAllCheckbox.addEventListener('change', function () {
				const isChecked = this.checked;
				rowCheckboxes.forEach(checkbox => {
					checkbox.checked = isChecked;
				});
				updateDeleteButton();
			});
		}

		// Обработчики для чекбоксов строк
		rowCheckboxes.forEach(checkbox => {
			checkbox.addEventListener('change', function () {
				updateDeleteButton();
				updateSelectAllCheckbox();
			});
		});

		// Обновление состояния кнопки удаления
		function updateDeleteButton() {
			const checkedCount = tableContainer.querySelectorAll('.row-checkbox:checked').length;
			deleteBtn.disabled = checkedCount === 0;
			if (selectedCount) {
				selectedCount.textContent = checkedCount;
			}
		}

		// Обновление состояния чекбокса "Выбрать все"
		function updateSelectAllCheckbox() {
			if (!selectAllCheckbox) return;

			const checkedCount = tableContainer.querySelectorAll('.row-checkbox:checked').length;
			const totalCount = rowCheckboxes.length;

			selectAllCheckbox.checked = checkedCount === totalCount;
			selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
		}

		// Обработчик для кнопки удаления
		if (deleteBtn) {
			deleteBtn.addEventListener('click', function () {
				const checkedCheckboxes = tableContainer.querySelectorAll('.row-checkbox:checked');
				if (checkedCheckboxes.length === 0) {
					alert('Не выбраны записи для удаления');
					return;
				}

				if (!confirm(`Вы уверены, что хотите удалить ${checkedCheckboxes.length} записей?`)) {
					return;
				}

				// Подготовка данных для отправки
				const formData = new FormData();
				formData.append('entity_type', entityType);

				checkedCheckboxes.forEach(checkbox => {
					formData.append('ids[]', checkbox.value);
				});

				// Отправка данных на сервер
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
							console.log(data);
							window.location.reload();
						}
					})
					.catch(error => {
						console.error('Error:', error);
					});
			});
		}
	});

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