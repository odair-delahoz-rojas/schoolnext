<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\DirectChat;

// --- Example Data ---
$messages = [
    [
        'name' => 'Alexander Pierce',
        'image' => '../../src/assets/img/user1-128x128.jpg',
        'timestamp' => '23 Jan 2:00 pm',
        'text' => 'Is this template really for free? That\'s unbelievable!',
        'align' => 'left'
    ],
    [
        'name' => 'Sarah Bullock',
        'image' => '../../src/assets/img/user3-128x128.jpg',
        'timestamp' => '23 Jan 2:05 pm',
        'text' => 'You better believe it!',
        'align' => 'right'
    ],
    [
        'name' => 'Alexander Pierce',
        'image' => '../../src/assets/img/user1-128x128.jpg',
        'timestamp' => '23 Jan 5:37 pm',
        'text' => 'Working with AdminLTE on a great new app! Wanna join?',
        'align' => 'left'
    ],
];

echo '<div class="row"><div class="col-md-6">';

// 1. Basic Direct Chat
echo '<h4>1. Basic Direct Chat (Primary)</h4>';
echo DirectChat::render('Chat Primary', $messages);

echo '</div><div class="col-md-6">';

// 2. Different Color and Form Hidden
echo '<h4>2. Success Color & No Form</h4>';
echo DirectChat::render('Chat Success', $messages, ['color' => 'success', 'show_form' => false]);

echo '</div></div>';
