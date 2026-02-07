<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Layout;

// Determine which layout config to load
$layoutType = $_GET['layout'] ?? 'default';
$configFilePath = __DIR__ . '/layout_' . $layoutType . '_config.php';

// Default to default layout if config file not found
if (!file_exists($configFilePath)) {
    $layoutType = 'default';
    $configFilePath = __DIR__ . '/layout_default_config.php';
}

// Load the configuration for the selected layout
require_once $configFilePath;

// Instantiate the Layout class
$layout = new Layout($pageTitle, $layoutOptions);

// Render the page
$layout->renderHead();
$layout->renderBodyStart();

// Render main UI parts
$layout->renderHeader();
$layout->renderSidebar('AdminLTE 4', 'Layout Examples', $menuItems);

// Render content wrapper start and breadcrumbs
$breadcrumbs = [
    ['name' => 'Home', 'link' => '#'],
    ['name' => 'Layouts', 'link' => 'layout_preview.php'],
    ['name' => $pageTitle]
];
$layout->renderContentWrapperStart($pageTitle, $breadcrumbs);

// --- Page Specific Content ---
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Layout Options</h3>
            </div>
            <div class="card-body">
                <p>Select a layout to preview:</p>
                <a href="layout_preview.php?layout=default" class="btn btn-primary">Default Layout</a>
                <a href="layout_preview.php?layout=fixed" class="btn btn-primary">Fixed Header & Sidebar</a>
                <a href="layout_preview.php?layout=collapsed" class="btn btn-primary">Collapsed Sidebar</a>
                <a href="layout_preview.php?layout=fixed_collapsed" class="btn btn-primary">Fixed & Collapsed</a>
            </div>
        </div>
        <?php echo $pageContent; // Dynamic content from config file ?>
    </div>
</div>

<?php
// --- End Page Specific Content ---

// Render content wrapper end
$layout->renderContentWrapperEnd();

// Render footer and body end
$layout->renderFooter();
$layout->renderBodyEnd();
?>
