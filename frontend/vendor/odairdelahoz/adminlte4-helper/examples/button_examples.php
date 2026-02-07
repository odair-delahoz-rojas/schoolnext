<?php
declare(strict_types=1);

require_once __DIR__ . '/../autoloader.php';

use AdminLTE\AdminLTE;
use AdminLTE\Components\Button;

$adminlte = new AdminLTE([
    'title' => 'Button Examples',
    'activeMenu' => 'button_examples' // Opcional: para resaltar el elemento del menú si existiera
]);

echo $adminlte->render('head');
echo $adminlte->render('body_start');
echo $adminlte->render('header');
echo $adminlte->render('sidebar');
echo $adminlte->render('content_wrapper_start');
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Ejemplos de Botones</h3>
                    </div>
                    <div class="card-body">
                        <h4>Botones Básicos</h4>
                        <div class="mb-3">
                            <?php echo Button::render('Primary Button'); ?>
                            <?php echo Button::render('Secondary Button', ['color' => 'secondary']); ?>
                            <?php echo Button::render('Success Button', ['color' => 'success']); ?>
                            <?php echo Button::render('Danger Button', ['color' => 'danger']); ?>
                            <?php echo Button::render('Warning Button', ['color' => 'warning']); ?>
                            <?php echo Button::render('Info Button', ['color' => 'info']); ?>
                            <?php echo Button::render('Light Button', ['color' => 'light']); ?>
                            <?php echo Button::render('Dark Button', ['color' => 'dark']); ?>
                        </div>

                        <h4>Botones Outline</h4>
                        <div class="mb-3">
                            <?php echo Button::render('Primary Outline', ['outline' => true]); ?>
                            <?php echo Button::render('Secondary Outline', ['color' => 'secondary', 'outline' => true]); ?>
                            <?php echo Button::render('Success Outline', ['color' => 'success', 'outline' => true]); ?>
                            <?php echo Button::render('Danger Outline', ['color' => 'danger', 'outline' => true]); ?>
                            <?php echo Button::render('Warning Outline', ['color' => 'warning', 'outline' => true]); ?>
                            <?php echo Button::render('Info Outline', ['color' => 'info', 'outline' => true]); ?>
                            <?php echo Button::render('Light Outline', ['color' => 'light', 'outline' => true]); ?>
                            <?php echo Button::render('Dark Outline', ['color' => 'dark', 'outline' => true]); ?>
                        </div>

                        <h4>Botones con Iconos</h4>
                        <div class="mb-3">
                            <?php echo Button::render('Add User', ['icon' => 'fas fa-user-plus']); ?>
                            <?php echo Button::render('Edit', ['color' => 'warning', 'icon' => 'fas fa-edit']); ?>
                            <?php echo Button::render('Delete', ['color' => 'danger', 'icon' => 'fas fa-trash']); ?>
                            <?php echo Button::render('Download', ['color' => 'info', 'icon' => 'fas fa-download']); ?>
                        </div>

                        <h4>Botones de Diferentes Tamaños</h4>
                        <div class="mb-3">
                            <?php echo Button::render('Large Button', ['size' => 'lg']); ?>
                            <?php echo Button::render('Default Button'); ?>
                            <?php echo Button::render('Small Button', ['size' => 'sm']); ?>
                            <?php echo Button::render('Extra Small Button', ['size' => 'xs']); ?>
                        </div>

                        <h4>Botones como Enlaces (Tag `a`)</h4>
                        <div class="mb-3">
                            <?php echo Button::render('Visit Google', ['element' => 'a', 'href' => 'https://www.google.com', 'color' => 'success']); ?>
                            <?php echo Button::render('Download File', ['element' => 'a', 'href' => '#', 'color' => 'info', 'icon' => 'fas fa-download']); ?>
                        </div>
                        
                        <h4>Botones con Opciones HTMX</h4>
                        <div class="mb-3">
                            <p>Estos botones no funcionarán a menos que se incluya HTMX en la página. (e.g. <code>&lt;script src="https://unpkg.com/htmx.org@1.9.10"&gt;&lt;/script&gt;</code>)</p>
                            <?php echo Button::render('Cargar Contenido', ['color' => 'info'], ['hx-get' => 'https://jsonplaceholder.typicode.com/posts/1', 'hx-target' => '#content-area', 'hx-swap' => 'innerHTML', 'hx-indicator' => '#spinner']); ?>
                            <?php echo Button::render(
                                'Haz Click',
                                ['color' => 'success'],
                                ['hx-trigger' => 'click', 'hx-swap' => 'outerHTML', 'hx-get' => 'https://jsonplaceholder.typicode.com/todos/1']
                            ); ?>
                            <?php echo Button::render(
                                'Enlace con HTMX',
                                ['element' => 'a', 'href' => '#', 'color' => 'warning'],
                                ['hx-get' => 'https://jsonplaceholder.typicode.com/comments/1', 'hx-indicator' => '#spinner', 'hx-target' => '#content-area']
                            ); ?>
                        </div>
                        <div id="content-area" class="mt-3 p-3 border bg-light">Área de destino para los botones HTMX. El contenido se cargará aquí.</div>
                        <i id="spinner" class="fas fa-spinner fa-spin fa-2x htmx-indicator"></i>
                        <style>.htmx-indicator{display:none;} .htmx-request .htmx-indicator{display:inline-block;}</style>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
echo $adminlte->render('content_wrapper_end');
echo $adminlte->render('footer');
echo $adminlte->render('body_end');
?>
