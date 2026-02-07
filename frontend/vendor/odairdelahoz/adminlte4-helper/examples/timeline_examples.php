<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Timeline;
use AdminLTE\Components\Card;

// --- Example Data ---
$timelineItems = [
    // Label
    [
        'type' => 'label',
        'text' => '10 Feb. 2023',
        'color' => 'danger'
    ],
    // Event item
    [
        'icon' => 'bi bi-envelope',
        'icon_color' => 'primary',
        'time' => '12:05',
        'header' => '<a href="#">Support Team</a> sent you an email',
        'body' => 'Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.',
        'footer' => '<a class="btn btn-primary btn-sm">Read more</a> <a class="btn btn-danger btn-sm">Delete</a>'
    ],
    // Event item
    [
        'icon' => 'bi bi-person-fill',
        'icon_color' => 'success',
        'header' => '<a href="#">Sarah Bullock</a> accepted your friend request'
    ],
    // Label
    [
        'type' => 'label',
        'text' => '3 Jan. 2023',
        'color' => 'success'
    ],
    // Event item
    [
        'icon' => 'bi bi-camera-fill',
        'icon_color' => 'warning',
        'time' => '15:30',
        'header' => '<a href="#">Mina Lee</a> uploaded new photos',
        'body' => '<img src="https://placehold.co/150x100" alt="..."> <img src="https://placehold.co/150x100" alt="...">'
    ],
];

echo Card::render('Project Timeline', Timeline::render($timelineItems));
