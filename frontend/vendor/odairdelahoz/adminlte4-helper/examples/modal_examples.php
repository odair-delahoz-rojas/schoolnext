<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Modal;

// 1. Basic Modal
echo Modal::renderToggleButton('basicModal', 'Launch Basic Modal');
echo ' '; // spacer

// 2. Large Modal with custom footer
echo Modal::renderToggleButton('largeModal', 'Launch Large Modal', ['class' => 'btn btn-success']);
echo ' '; // spacer

// 3. XL Modal with static backdrop
echo Modal::renderToggleButton('staticModal', 'Launch Static Backdrop Modal', ['class' => 'btn btn-danger']);


// --- MODAL HTML DEFINITIONS ---

// 1. Basic Modal HTML
echo Modal::render(
    'basicModal',
    'Basic Modal Title',
    'This is the body of the basic modal. Click the close button or outside the modal to dismiss it.'
);

// 2. Large Modal HTML
$customFooter = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>' .
                '<button type="button" class="btn btn-primary">Save Changes</button>';
echo Modal::render(
    'largeModal',
    'Large Modal',
    'This is a large modal (<code>size: \'lg\'</code>) with a custom footer.',
    ['size' => 'lg', 'footer' => $customFooter]
);

// 3. Static Modal HTML
echo Modal::render(
    'staticModal',
    'Static Backdrop Modal',
    '<p>This is an extra-large modal (<code>size: \'xl\'</code>) with a static backdrop.</p><p>You cannot close it by clicking outside the modal area. Use the close button instead.</p>',
    ['size' => 'xl', 'static_backdrop' => true]
);

