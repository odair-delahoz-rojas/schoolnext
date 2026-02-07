<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Table {
    /**
     * Genera una tabla HTML.
     *
     * @param array $headers Array de strings para las cabeceras.
     * @param array $data Array de arrays, donde cada subarray es una fila.
     * @param array $options Opciones adicionales.
     *   - 'classes' (string): Clases CSS para la tabla (e.g., 'table-bordered table-striped').
     *   - 'card' (bool|string): Si es true, envuelve la tabla en una tarjeta. Si es string, lo usa como título.
     *   - 'card_padding' (bool): Si es false y la tabla está en una tarjeta, elimina el padding del card-body.
     * @return string HTML del componente.
     */
    public static function render(array $headers, array $data, array $options = []): string {
        $defaultOptions = [
            'classes' => 'table',
            'card' => false,
            'card_padding' => true
        ];
        $options = array_merge($defaultOptions, $options);

        $tableHtml = '<table class="' . $options['classes'] . '">';
        
        // Cabecera
        $tableHtml .= '<thead><tr>';
        foreach ($headers as $header) {
            $tableHtml .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $tableHtml .= '</tr></thead>';

        // Cuerpo
        $tableHtml .= '<tbody>';
        foreach ($data as $row) {
            $tableHtml .= '<tr>';
            foreach ($row as $cell) {
                $tableHtml .= '<td>' . $cell . '</td>'; // No escapar celda para permitir HTML
            }
            $tableHtml .= '</tr>';
        }
        $tableHtml .= '</tbody>';

        $tableHtml .= '</table>';

        if ($options['card']) {
            $cardTitle = is_string($options['card']) ? $options['card'] : 'Table';
            $cardBodyClass = $options['card_padding'] ? '' : ' p-0';
            $cardBody = '<div class="card-body' . $cardBodyClass . '">' . $tableHtml . '</div>';
            return Card::render($cardTitle, $cardBody);
        }

        return $tableHtml;
    }
}
