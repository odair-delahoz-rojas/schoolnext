<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Callout;

// 1. Basic Callouts
echo '<h4>1. Basic Callouts</h4>';
echo '<p>Different colors available using the <code>color</code> option.</p>';
echo Callout::render('This is an info callout.', ['color' => 'info']);
echo Callout::render('This is a danger callout.', ['color' => 'danger']);
echo Callout::render('This is a success callout.', ['color' => 'success']);
echo Callout::render('This is a warning callout.', ['color' => 'warning']);
echo '<hr>';

// 2. Callouts with Titles
echo '<h4>2. Callouts with Titles</h4>';
echo '<p>Using the <code>title</code> option.</p>';
echo Callout::render('Follow the instructions to continue.', ['title' => 'I am an Info Callout', 'color' => 'info']);
echo Callout::render('Something went wrong, please try again.', ['title' => 'I am a Danger Callout', 'color' => 'danger']);
echo Callout::render('Your action was completed successfully.', ['title' => 'I am a Success Callout', 'color' => 'success']);
echo '<hr>';

// 3. Callout with HTML content
echo '<h4>3. Callout with HTML content</h4>';
echo '<p>You can pass HTML strings to the content.</p>';
$htmlContent = 'This callout contains a <ul><li>List item 1</li><li>List item 2</li></ul> and a <strong>bold text</strong>.';
echo Callout::render($htmlContent, ['title' => 'HTML Content', 'color' => 'warning']);
echo '<hr>';
