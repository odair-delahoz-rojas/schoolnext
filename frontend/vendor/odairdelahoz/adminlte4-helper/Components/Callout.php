<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Callout {
    /**
     * Genera un componente Callout.
     */
    public static function render(string $content, array $options = []): string {
        $defaultOptions = ['title' => null, 'color' => 'info'];
        $options = array_merge($defaultOptions, $options);

        $html = '<div class="callout callout-' . $options['color'] . '">';
        if ($options['title']) {
            $html .= '<h5>' . htmlspecialchars($options['title']) . '</h5>';
        }
        $html .= '<p>' . $content . '</p>';
        $html .= '</div>';

        return $html;
    }
}
