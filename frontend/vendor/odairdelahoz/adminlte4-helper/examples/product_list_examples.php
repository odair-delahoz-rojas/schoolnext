<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Widgets\ProductList;

// --- Example Data ---
$products = [
    [
        'image' => '../../src/assets/img/prod-1.jpg',
        'name' => 'Samsung TV',
        'price' => '$1800',
        'price_color' => 'warning',
        'description' => 'Samsung 32" 1080p 60Hz LED Smart HDTV.',
        'link' => '#'
    ],
    [
        'image' => '../../src/assets/img/prod-2.jpg',
        'name' => 'Bicycle',
        'price' => '$700',
        'price_color' => 'info',
        'description' => '26" Mongoose Dolomite Men\'s 7-speed, Navy Blue.',
        'link' => '#'
    ],
    [
        'image' => '../../src/assets/img/prod-3.jpg',
        'name' => 'Xbox One',
        'price' => '$350',
        'price_color' => 'danger',
        'description' => 'Xbox One Console Bundle with Halo Master Chief Collection.',
        'link' => '#'
    ],
    [
        'image' => '../../src/assets/img/prod-4.jpg',
        'name' => 'PlayStation 4',
        'price' => '$399',
        'price_color' => 'primary',
        'description' => 'PlayStation 4 500GB Console (PS4)',
        'link' => '#'
    ],
];

echo ProductList::render('Recently Added Products', $products, ['footer_link' => '#']);

