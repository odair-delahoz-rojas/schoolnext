<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Badge {
    /**
     * Genera un componente Badge.
     */
    public static function render(string $text, array $options = []): string {
        $defaultOptions = ['color' => 'secondary', 'pill' => false, 'class' => ''];
        $options = array_merge($defaultOptions, $options);

        $classes = 'badge text-bg-' . $options['color'];
        if ($options['pill']) {
            $classes .= ' rounded-pill';
        }
        if ($options['class']) {
            $classes .= ' ' . $options['class'];
        }

        return '<span class="' . $classes . '">' . htmlspecialchars($text) . '</span>';
    }
}
