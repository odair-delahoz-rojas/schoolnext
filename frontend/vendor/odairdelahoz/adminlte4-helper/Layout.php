<?php
declare(strict_types=1);
namespace AdminLTE;

class Layout {
    public string $title;
    public array $options;
    public string $distPath;
    private string $viewsPath;

    /**
     * Constructor de la clase Layout.
     *
     * @param string $title El título de la página.
     * @param array $options Opciones para configurar el layout.
     *   - 'fixed_header' (bool): Fija la cabecera.
     *   - 'fixed_sidebar' (bool): Fija la barra lateral (requiere fixed_header).
     *   - 'fixed_footer' (bool): Fija el pie de página.
     *   - 'collapsed_sidebar' (bool): Colapsa la barra lateral al inicio.
     *   - 'sidebar_mini' (bool): Usa el modo 'mini' para la barra lateral.
     *   - 'dist_path' (string): Ruta a la carpeta 'dist' para los assets.
     */
    public function __construct(string $title = 'AdminLTE 4', array $options = []) {
        $this->title = $title;
        $defaultOptions = [
            'fixed_header' => false,
            'fixed_sidebar' => false,
            'fixed_footer' => false,
            'collapsed_sidebar' => false,
            'sidebar_mini' => false,
            'dist_path' => 'dist' // Ruta por defecto a la carpeta dist
        ];
        $this->options = array_merge($defaultOptions, $options);
        $this->distPath = $this->options['dist_path'];
        $this->viewsPath = __DIR__ . '/Views/';
    }

    private function getBodyClasses(): string {
        $classes = ['sidebar-expand-lg', 'bg-body-tertiary'];
        if ($this->options['fixed_header']) {
            $classes[] = 'layout-fixed'; // En v4, layout-fixed maneja el sidebar y el header.
        }
        if ($this->options['fixed_footer']) {
            $classes[] = 'layout-footer-fixed';
        }
        if ($this->options['collapsed_sidebar']) {
            $classes[] = 'sidebar-collapse';
        }
        if ($this->options['sidebar_mini']) {
            $classes[] = 'sidebar-mini';
        }
        return implode(' ', $classes);
    }

    public function renderHead(): void {
        include $this->viewsPath . 'head.phtml';
    }

    public function renderBodyStart(): void {
        $bodyClasses = $this->getBodyClasses();
        include $this->viewsPath . 'body_start.phtml';
    }

    public function renderHeader(string $brandName = 'AdminLTE', array $menuItems = [], array $user = null): void {
        include $this->viewsPath . 'header.phtml';
    }

    public function renderSidebar(string $brandName = 'AdminLTE 4', string $userName = 'User Name', array $menuItems = []): void {
        include $this->viewsPath . 'sidebar.phtml';
    }

    public function renderContentWrapperStart(string $pageTitle = '', array $breadcrumbs = []): void {
        $breadcrumbsHtml = '';
        if (!empty($breadcrumbs)) {
            $breadcrumbsHtml .= '<div class="col-sm-6"><ol class="breadcrumb float-sm-end">';
            foreach ($breadcrumbs as $i => $crumb) {
                if ($i < count($breadcrumbs) - 1) {
                    $breadcrumbsHtml .= '<li class="breadcrumb-item"><a href="' . htmlspecialchars($crumb['link'] ?? '#') . '">' . htmlspecialchars($crumb['name']) . '</a></li>';
                } else {
                    $breadcrumbsHtml .= '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($crumb['name']) . '</li>';
                }
            }
            $breadcrumbsHtml .= '</ol></div>';
        }
        include $this->viewsPath . 'content_wrapper_start.phtml';
    }

    public function renderContentWrapperEnd(): void {
        include $this->viewsPath . 'content_wrapper_end.phtml';
    }

    public function renderFooter(string $copyright_link = 'https://adminlte.io', string $copyright_link_text = 'AdminLTE.io'): void {
        include $this->viewsPath . 'footer.phtml';
    }

    public function renderBodyEnd(array $javaScripts = []): void {
        include $this->viewsPath . 'body_end.phtml';
    }
}
