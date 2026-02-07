<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Button
{
    /**
     * Genera un componente de botón.
     *
     * @param string $text El texto que se mostrará en el botón.
     * @param array $options Opciones para configurar el botón:
     *   - 'color': Color del botón (e.g., 'primary', 'success', 'danger'). Por defecto: 'primary'.
     *   - 'type': Tipo del botón ('button', 'submit', 'reset'). Solo para elemento <button>. Por defecto: 'button'.
     *   - 'size': Tamaño del botón ('lg', 'sm', 'xs'). Por defecto: ''.
     *   - 'outline': Si el botón debe ser de estilo 'outline'. Por defecto: false.
     *   - 'icon': Clase del icono (e.g., 'fas fa-plus'). Por defecto: ''.
     *   - 'element': Tipo de elemento HTML ('button' o 'a'). Por defecto: 'button'.
     *   - 'href': URL para botones de tipo 'a'. Por defecto: '#'.
     *   - 'customClass': Clases CSS adicionales. Por defecto: ''.
     * @param array $htmx_opts Opciones para configurar HTMX.
     * @return string El HTML del botón.
     */
    public static function render(string $text, array $options = [], array $htmx_opts = []): string
    {
        $defaultOptions = [
            'color' => 'primary',
            'type' => 'button',
            'size' => '',
            'outline' => false,
            'icon' => '',
            'element' => 'button',
            'href' => '#',
            'customClass' => '',
        ];
        $options = array_merge($defaultOptions, $options);

        $buttonClasses = 'btn';

        // Add color class
        if ($options['color']) {
            $buttonClasses .= $options['outline'] ? ' btn-outline-' . $options['color'] : ' btn-' . $options['color'];
        }

        // Add size class
        if ($options['size']) {
            $buttonClasses .= ' btn-' . $options['size'];
        }

        // Add custom class
        if ($options['customClass']) {
            $buttonClasses .= ' ' . $options['customClass'];
        }

        $iconHtml = '';
        if ($options['icon']) {
            $iconHtml = '<i class="' . htmlspecialchars($options['icon']) . '"></i> ';
        }

        $htmx_attributes = '';
        if (!empty($htmx_opts)) {
            foreach ($htmx_opts as $key => $value) {
                $htmx_attributes .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars((string)$value) . '"';
            }
        }

        $html = '';
        if ($options['element'] === 'a') {
            $html .= '<a href="' . htmlspecialchars($options['href']) . '" class="' . htmlspecialchars($buttonClasses) . '" role="button"' . $htmx_attributes . '>';
            $html .= $iconHtml . htmlspecialchars($text);
            $html .= '</a>';
        } else {
            // Default to button element
            $html .= '<button type="' . htmlspecialchars($options['type']) . '" class="' . htmlspecialchars($buttonClasses) . '"' . $htmx_attributes . '>';
            $html .= $iconHtml . htmlspecialchars($text);
            $html .= '</button>';
        }

        return $html;
    }
}
