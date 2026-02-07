<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Card {
    /**
     * Genera un componente de Tarjeta (Card).
     */
    public static function render(string $title, string $body, array $options = []): string {
        $defaultOptions = [
            'footer' => null,
            'color' => null,
            'outline' => false,
            'collapsed' => false,
            'collapsable' => false,
            'removable' => false,
            'customClass' => ''
        ];
        $options = array_merge($defaultOptions, $options);

        $cardClasses = 'card';
        if ($options['color']) {
            $cardClasses .= $options['outline'] ? ' card-outline-' . $options['color'] : ' card-' . $options['color'];
        }
        if ($options['collapsed']) {
            $cardClasses .= ' collapsed-card';
        }
        if ($options['customClass']) {
            $cardClasses .= ' ' . $options['customClass'];
        }

        $cardTools = '';
        if ($options['collapsable'] || $options['removable']) {
            $cardTools .= '<div class="card-tools">';
            if ($options['collapsable']) {
                $cardTools .= '<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"><i class="bi bi-dash-lg"></i></button>';
            }
            if ($options['removable']) {
                $cardTools .= '<button type="button" class="btn btn-tool" data-lte-toggle="card-remove"><i class="bi bi-x-lg"></i></button>';
            }
            $cardTools .= '</div>';
        }

        $html = '<div class="' . $cardClasses . '">';
        $html .= '<div class="card-header">';
        $html .= '    <h3 class="card-title">' . htmlspecialchars($title) . '</h3>';
        $html .= $cardTools;
        $html .= '</div>';
        $html .= '<div class="card-body">';
        $html .= $body;
        $html .= '</div>';

        if ($options['footer'] !== null) {
            $html .= '<div class="card-footer">';
            $html .= $options['footer'];
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}
