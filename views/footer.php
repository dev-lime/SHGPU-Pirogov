<script>
    function toggleForm(formId) {
        const form = document.getElementById(formId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

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

    document.getElementById('select-all').addEventListener('change', function (e) {
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
        updateDeleteButton();
    });

    // Обновление счетчика выбранных элементов
    document.querySelectorAll('input[name="ids[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateDeleteButton);
    });

    function updateDeleteButton() {
        const checkedCount = document.querySelectorAll('input[name="ids[]"]:checked').length;
        const deleteBtn = document.getElementById('delete-selected');
        const countSpan = document.querySelector('.selected-count');

        deleteBtn.disabled = checkedCount === 0;
        countSpan.textContent = checkedCount;

        // Обновляет "Выбрать все"
        const totalCount = document.querySelectorAll('input[name="ids[]"]').length;
        document.getElementById('select-all').checked = checkedCount > 0 && checkedCount === totalCount;
    }

    // Подтверждение удаления
    document.getElementById('delete-form').addEventListener('submit', function (e) {
        const checkedCount = document.querySelectorAll('input[name="ids[]"]:checked').length;
        if (checkedCount === 0) {
            e.preventDefault();
            return;
        }

        if (!confirm(`Вы уверены, что хотите удалить ${checkedCount} записей?`)) {
            e.preventDefault();
        }
    });
</script>
</body>

</html>