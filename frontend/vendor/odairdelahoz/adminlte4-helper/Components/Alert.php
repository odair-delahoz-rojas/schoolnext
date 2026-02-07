<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Alert {
    /**
     * Genera un componente de Alerta.
     */
    public static function render(string $message, array $options = []): string {
        $defaultOptions = [
            'color' => 'info',
            'icon' => null,
            'dismissible' => false,
            'customClass' => ''
        ];
        $options = array_merge($defaultOptions, $options);

        $alertClasses = 'alert alert-' . $options['color'];
        if ($options['dismissible']) {
            $alertClasses .= ' alert-dismissible fade show';
        }
        if ($options['customClass']) {
            $alertClasses .= ' ' . $options['customClass'];
        }

        $iconHtml = '';
        if ($options['icon']) {
            $iconHtml = '<i class="' . $options['icon'] . ' me-2"></i> ';
        }

        $dismissButton = '';
        if ($options['dismissible']) {
            $dismissButton = '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        }

        $html = '<div class="' . $alertClasses . '" role="alert">';
        $html .= $iconHtml . $message;
        $html .= $dismissButton;
        $html .= '</div>';

        return $html;
    }
}
