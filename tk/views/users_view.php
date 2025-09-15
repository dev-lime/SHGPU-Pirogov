<?php
require_once __DIR__ . '/../utils/auth.php';
requireRole('admin');

$con = getDBConnection();
$sql = "SELECT u.*, r.role_name, r.permissions 
        FROM users u 
        LEFT JOIN roles r ON u.role_id = r.role_id 
        ORDER BY u.user_id";
$result = pg_query($con);
$users = [];
while ($row = pg_fetch_assoc($result)) {
    if (isset($row['permissions'])) {
        $row['permissions'] = trim($row['permissions'], '{}');
        $row['permissions'] = explode(',', $row['permissions']);
    }
    $users[] = $row;
}

require_once __DIR__ . '/../models/RoleModel.php';
$roles = RoleModel::getAll();

require_once __DIR__ . '/../models/ClientModel.php';
require_once __DIR__ . '/../models/DispatcherModel.php';
require_once __DIR__ . '/../models/DriverModel.php';

$clients = ClientModel::getAll();
$dispatchers = DispatcherModel::getAll();
$drivers = DriverModel::getAll();

$config = [
    'title' => 'Пользователи',
    'entityType' => 'user',
    'primaryKey' => 'user_id',
    'items' => $users,
    'columns' => [
        ['field' => 'user_id', 'label' => 'ID'],
        ['field' => 'username', 'label' => 'Логин'],
        ['field' => 'role_name', 'label' => 'Роль'],
        [
            'field' => 'entity_info',
            'label' => 'Привязанная сущность',
            'type' => 'custom',
            'render' => function ($user) use ($clients, $dispatchers, $drivers) {
                if (!$user['entity_id'] || !$user['entity_type']) {
                    return 'Не привязана';
                }

                switch ($user['entity_type']) {
                    case 'client':
                        $entity = array_filter($clients, fn($c) => $c['client_id'] == $user['entity_id']);
                        $name = $entity ? current($entity)['full_name'] : 'Не найдено';
                        break;
                    case 'dispatcher':
                        $entity = array_filter($dispatchers, fn($d) => $d['dispatcher_id'] == $user['entity_id']);
                        $name = $entity ? current($entity)['full_name'] : 'Не найдено';
                        break;
                    case 'driver':
                        $entity = array_filter($drivers, fn($d) => $d['driver_id'] == $user['entity_id']);
                        $name = $entity ? current($entity)['full_name'] : 'Не найдено';
                        break;
                    default:
                        $name = 'Неизвестно';
                }

                return $user['entity_type'] . ': ' . $name . ' (ID: ' . $user['entity_id'] . ')';
            }
        ],
        [
            'field' => 'permissions',
            'label' => 'Права',
            'type' => 'custom',
            'render' => function ($user) {
                if (empty($user['permissions'])) {
                    return 'Нет прав';
                }
                return implode(', ', $user['permissions']);
            }
        ],
        [
            'field' => 'actions',
            'label' => 'Действия',
            'type' => 'custom',
            'render' => function ($user) {
                $html = '<div class="user-actions">';
                $html .= '<button onclick="editUser(' . $user['user_id'] . ')" class="edit-btn">✏️</button>';
                $html .= '<form action="/tk/controllers/delete_user.php" method="POST" class="inline-form">';
                $html .= '<input type="hidden" name="user_id" value="' . $user['user_id'] . '">';
                $html .= '<button type="submit" class="delete-btn" onclick="return confirm(\'Удалить пользователя?\')">🗑️</button>';
                $html .= '</form>';
                $html .= '</div>';
                return $html;
            }
        ]
    ],
    'fields' => [
        ['name' => 'username', 'label' => 'Логин', 'type' => 'text', 'required' => true],
        ['name' => 'password', 'label' => 'Пароль', 'type' => 'password', 'required' => true],
        [
            'name' => 'role_id',
            'label' => 'Роль',
            'type' => 'select',
            'options' => array_map(function ($role) {
                return ['value' => $role['role_id'], 'display' => $role['role_name']];
            }, $roles),
            'valueField' => 'value',
            'displayField' => 'display',
            'required' => true
        ],
        [
            'name' => 'entity_type',
            'label' => 'Тип сущности',
            'type' => 'select',
            'options' => [
                ['value' => '', 'display' => 'Не привязывать'],
                ['value' => 'client', 'display' => 'Клиент'],
                ['value' => 'dispatcher', 'display' => 'Диспетчер'],
                ['value' => 'driver', 'display' => 'Водитель']
            ],
            'valueField' => 'value',
            'displayField' => 'display'
        ],
        [
            'name' => 'entity_id',
            'label' => 'Сущность',
            'type' => 'select',
            'options' => [['value' => '', 'display' => 'Выберите сущность']],
            'valueField' => 'value',
            'displayField' => 'display'
        ]
    ]
];

require 'partials/table_template.php';
require 'partials/form_template.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const entityTypeSelect = document.querySelector('select[name="entity_type"]');
        const entityIdSelect = document.querySelector('select[name="entity_id"]');

        const entities = {
            client: <?= json_encode(array_map(function ($c) {
                return ['value' => $c['client_id'], 'display' => $c['full_name'] . ' (ID: ' . $c['client_id'] . ')'];
            }, $clients)) ?>,
            dispatcher: <?= json_encode(array_map(function ($d) {
                return ['value' => $d['dispatcher_id'], 'display' => $d['full_name'] . ' (ID: ' . $d['dispatcher_id'] . ')'];
            }, $dispatchers)) ?>,
            driver: <?= json_encode(array_map(function ($d) {
                return ['value' => $d['driver_id'], 'display' => $d['full_name'] . ' (ID: ' . $d['driver_id'] . ')'];
            }, $drivers)) ?>
        };

        if (entityTypeSelect && entityIdSelect) {
            entityTypeSelect.addEventListener('change', function () {
                const type = this.value;
                entityIdSelect.innerHTML = '<option value="">Выберите сущность</option>';

                if (type && entities[type]) {
                    entities[type].forEach(entity => {
                        const option = document.createElement('option');
                        option.value = entity.value;
                        option.textContent = entity.display;
                        entityIdSelect.appendChild(option);
                    });
                }
            });
        }
    });

    function editUser(userId) {
        alert('Редактирование пользователя ' + userId);
    }
</script>