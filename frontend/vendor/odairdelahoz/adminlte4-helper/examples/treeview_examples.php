<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Treeview;
use AdminLTE\Components\Card;

// --- Example Data ---
$menuItems = [
    [
        'type' => 'header',
        'text' => 'MAIN NAVIGATION'
    ],
    [
        'text' => 'Dashboard',
        'icon' => 'bi bi-speedometer',
        'open' => true, // This item will be open by default
        'children' => [
            [
                'text' => 'Dashboard v1',
                'link' => '#',
                'icon' => 'bi bi-circle'
            ],
            [
                'text' => 'Dashboard v2',
                'link' => '#',
                'icon' => 'bi bi-circle',
                'active' => true // This item will be active
            ],
        ]
    ],
    [
        'text' => 'Widgets',
        'link' => '#',
        'icon' => 'bi bi-box-seam-fill',
        'badge' => ['text' => 'New', 'color' => 'success']
    ],
    [
        'type' => 'header',
        'text' => 'MULTI-LEVEL EXAMPLE'
    ],
    [
        'text' => 'Level 1',
        'icon' => 'bi bi-circle-fill',
        'children' => [
            ['text' => 'Level 2', 'link' => '#', 'icon' => 'bi bi-circle'],
            [
                'text' => 'Level 2 with Children',
                'icon' => 'bi bi-circle',
                'children' => [
                    ['text' => 'Level 3', 'link' => '#', 'icon' => 'bi bi-dot'],
                    ['text' => 'Level 3', 'link' => '#', 'icon' => 'bi bi-dot']
                ]
            ]
        ]
    ],
    [
        'type' => 'header',
        'text' => 'LABELS'
    ],
    ['text' => 'Important', 'icon' => 'bi bi-circle text-danger'],
    ['text' => 'Warning', 'icon' => 'bi bi-circle text-warning'],
    ['text' => 'Information', 'icon' => 'bi bi-circle text-info'],
];

$treeviewHtml = Treeview::render($menuItems);

echo Card::render('Sidebar Menu Treeview', $treeviewHtml, ['card_padding' => false]);
