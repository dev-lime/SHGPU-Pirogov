</div> <!-- .content-wrapper -->
</div> <!-- .main-content -->
</div> <!-- .layout -->

<script src="/tk/assets/js/main.js"></script>
<script>
    // Уведомления
    <?php if (isset($_GET['success'])): ?>
        showNotification('<?= addslashes($messages[$_GET['success']] ?? $_GET['success']) ?>', 'success');
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        showNotification('<?= addslashes($errorMessages[$_GET['error']] ?? $_GET['error']) ?>', 'error');
    <?php endif; ?>
</script>
</body>

</html>