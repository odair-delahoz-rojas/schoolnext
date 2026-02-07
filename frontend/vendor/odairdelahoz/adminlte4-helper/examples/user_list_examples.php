<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Widgets\UserList;

// --- Example Data ---
$users = [
    ['name' => 'Alexander Pierce', 'image' => '../../src/assets/img/user1-128x128.jpg', 'meta' => 'Today', 'link' => '#'],
    ['name' => 'Norman', 'image' => '../../src/assets/img/user8-128x128.jpg', 'meta' => 'Yesterday', 'link' => '#'],
    ['name' => 'Jane', 'image' => '../../src/assets/img/user7-128x128.jpg', 'meta' => '12 Jan', 'link' => '#'],
    ['name' => 'John', 'image' => '../../src/assets/img/user6-128x128.jpg', 'meta' => '12 Jan', 'link' => '#'],
    ['name' => 'Alexander', 'image' => '../../src/assets/img/user2-160x160.jpg', 'meta' => '13 Jan', 'link' => '#'],
    ['name' => 'Sarah', 'image' => '../../src/assets/img/user5-128x128.jpg', 'meta' => '14 Jan', 'link' => '#'],
    ['name' => 'Nora', 'image' => '../../src/assets/img/user4-128x128.jpg', 'meta' => '15 Jan', 'link' => '#'],
    ['name' => 'Nadia', 'image' => '../../src/assets/img/user3-128x128.jpg', 'meta' => '15 Jan', 'link' => '#'],
];

$options = [
    'badge_text' => '8 New Members',
    'badge_color' => 'danger',
    'footer_link' => '#'
];

echo UserList::render('Latest Members', $users, $options);
