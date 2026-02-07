<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class ProgressBar {
    /**
     * Genera un componente Progress Bar.
     */
    public static function render(int $value, array $options = []): string {
        $defaultOptions = ['color' => 'primary', 'striped' => false, 'animated' => false, 'label' => false];
        $options = array_merge($defaultOptions, $options);

        $barClasses = 'progress-bar bg-' . $options['color'];
        if ($options['striped']) {
            $barClasses .= ' progress-bar-striped';
        }
        if ($options['animated']) {
            $barClasses .= ' progress-bar-animated';
        }

        $label = $options['label'] ? ($value . '%') : '';

        $html = '<div class="progress" role="progressbar" aria-valuenow="' . $value . '" aria-valuemin="0" aria-valuemax="100">';
        $html .= '  <div class="' . $barClasses . '" style="width: ' . $value . '%">' . $label . '</div>';
        $html .= '</div>';

        return $html;
    }
}
