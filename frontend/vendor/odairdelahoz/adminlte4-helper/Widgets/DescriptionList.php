<?php
declare(strict_types=1);

namespace AdminLTE\Widgets;

use AdminLTE\Components\Card;

class DescriptionList {
    /**
     * Renderiza una lista de descripción (dl, dt, dd).
     *
     * @param array $items Array de items. Cada item es un array asociativo con 'term' y 'description'.
     * @param array $options Opciones adicionales.
     *   - 'horizontal' (bool): Si es true, la lista será horizontal.
     *   - 'card' (bool|string): Si es true, envuelve la lista en una tarjeta. Si es string, lo usa como título.
     * @return string HTML del componente.
     */
    public static function render(array $items, array $options = []): string {
        $defaultOptions = [
            'horizontal' => false,
            'card' => false
        ];
        $options = array_merge($defaultOptions, $options);

        $dlClasses = '';
        if ($options['horizontal']) {
            $dlClasses .= 'row';
        }

        $html = '<dl class="row">';
        foreach ($items as $item) {
            $html .= '<dt class="col-sm-4">' . htmlspecialchars($item['term']) . '</dt>';
            $html .= '<dd class="col-sm-8">' . htmlspecialchars($item['description']) . '</dd>';
        }
        $html .= '</dl>';

        if ($options['card']) {
            $cardTitle = is_string($options['card']) ? $options['card'] : 'Description List';
            return Card::render($cardTitle, $html);
        }

        return $html;
    }
}
