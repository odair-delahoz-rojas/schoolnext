<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class SmallBox {
    /**
     * Genera un componente Small Box.
     */
    public static function render(string $title, string $number, string $icon, array $options = []): string {
        $defaultOptions = [
            'color' => 'primary',
            'link' => '#',
            'link_text' => 'More info'
        ];
        $options = array_merge($defaultOptions, $options);

        $boxClasses = 'small-box text-bg-' . $options['color'];
        $iconClasses = 'small-box-icon bi ' . $icon;

        $html = '<div class="' . $boxClasses . '">';
        $html .= '  <div class="inner">';
        $html .= '    <h3>' . $number . '</h3>';
        $html .= '    <p>' . htmlspecialchars($title) . '</p>';
        $html .= '  </div>';
        $html .= '  <i class="' . $iconClasses . '"></i>';
        $html .= '  <a href="' . $options['link'] . '" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">';
        $html .= '    ' . htmlspecialchars($options['link_text']) . ' <i class="bi bi-link-45deg"></i>';
        $html .= '  </a>';
        $html .= '</div>';

        return $html;
    }
}
