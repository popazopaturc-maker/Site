<?php
header('Content-Type: application/json');

$username = $_GET['username'] ?? '';
$hwid = $_GET['hwid'] ?? '';

if (empty($username) || empty($hwid)) {
    die(json_encode(['success' => false, 'error' => 'Недостаточно данных']));
}

$usersFile = __DIR__ . '/../users.json';
$users = [];

if (file_exists($usersFile)) {
    $users = json_decode(file_get_contents($usersFile), true);
}

$found = false;
foreach ($users as &$user) {
    if ($user['username'] === $username) {
        $found = true;
        if ($user['hwid'] !== $hwid) {
            die(json_encode(['success' => false, 'error' => 'Доступ только с этого ПК!']));
        }
        if ($user['subscription'] === 'Нету подписки') {
            die(json_encode(['success' => false, 'error' => 'Нет активной подписки']));
        }
        die(json_encode(['success' => true]));
    }
}

if (!$found) {
    die(json_encode(['success' => false, 'error' => 'Пользователь не найден']));
}
?>
