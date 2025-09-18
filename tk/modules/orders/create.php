<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/OrderModel.php';
require_once '../../models/ClientModel.php';
require_once '../../models/DriverModel.php';
require_once '../../models/VehicleModel.php';

requireAuth();
requirePermission('create_orders');

$pageTitle = 'Создание заказа';

// Получаем данные для выпадающих списков
$clients = ClientModel::getAll();
$drivers = DriverModel::getAll();
$vehicles = VehicleModel::getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $con = getDBConnection();

        $data = [
            'client_id' => (int) $_POST['client_id'],
            'driver_id' => !empty($_POST['driver_id']) ? (int) $_POST['driver_id'] : null,
            'vehicle_id' => !empty($_POST['vehicle_id']) ? (int) $_POST['vehicle_id'] : null,
            'origin' => trim($_POST['origin']),
            'destination' => trim($_POST['destination']),
            'cargo_description' => trim($_POST['cargo_description'] ?? ''),
            'weight_kg' => !empty($_POST['weight_kg']) ? (float) $_POST['weight_kg'] : null,
            'distance_km' => !empty($_POST['distance_km']) ? (float) $_POST['distance_km'] : null,
            'status' => 'new'
        ];

        $result = OrderModel::create($con, $data);

        if ($result) {
            header("Location: index.php?success=order_created");
            exit;
        } else {
            $error = "Ошибка при создании заказа";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Создание заказа</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" class="form-container">
    <div class="form-section">
        <h3>Основная информация</h3>
        <div class="form-grid">
            <div class="form-group">
                <label for="client_id">Клиент *</label>
                <select id="client_id" name="client_id" required>
                    <option value="">Выберите клиента</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['client_id'] ?>">
                            <?= htmlspecialchars($client['full_name']) ?>
                            <?php if ($client['company_name']): ?>
                                (<?= htmlspecialchars($client['company_name']) ?>)
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="driver_id">Водитель</label>
                <select id="driver_id" name="driver_id">
                    <option value="">Не назначен</option>
                    <?php foreach ($drivers as $driver): ?>
                        <option value="<?= $driver['driver_id'] ?>">
                            <?= htmlspecialchars($driver['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="vehicle_id">Транспорт</label>
                <select id="vehicle_id" name="vehicle_id">
                    <option value="">Не назначен</option>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?= $vehicle['vehicle_id'] ?>">
                            <?= htmlspecialchars($vehicle['plate_number']) ?>
                            (<?= htmlspecialchars($vehicle['model']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h3>Маршрут и груз</h3>
        <div class="form-grid">
            <div class="form-group">
                <label for="origin">Откуда *</label>
                <input type="text" id="origin" name="origin" required>
            </div>

            <div class="form-group">
                <label for="destination">Куда *</label>
                <input type="text" id="destination" name="destination" required>
            </div>

            <div class="form-group">
                <label for="distance_km">Расстояние (км)</label>
                <input type="number" id="distance_km" name="distance_km" min="0" step="0.1">
            </div>

            <div class="form-group">
                <label for="weight_kg">Вес груза (кг)</label>
                <input type="number" id="weight_kg" name="weight_kg" min="0" step="0.1">
            </div>
        </div>

        <div class="form-group">
            <label for="cargo_description">Описание груза</label>
            <textarea id="cargo_description" name="cargo_description" rows="3"></textarea>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Создать заказ
        </button>
        <a href="index.php" class="btn btn-secondary">Отмена</a>
    </div>
</form>

<link rel="stylesheet" href="/tk/assets/css/forms.css">

<?php require '../../templates/footer.php'; ?>