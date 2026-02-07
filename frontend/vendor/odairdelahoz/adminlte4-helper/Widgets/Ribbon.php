<?php
declare(strict_types=1);

namespace AdminLTE\Widgets;

class Ribbon {
    /**
     * Renderiza un componente Ribbon (cinta decorativa).
     * Nota: AdminLTE 4 no parece tener clases CSS predefinidas para 'ribbon'.
     * Este componente genera la estructura HTML básica que necesitaría CSS personalizado.
     *
     * @param string $text El texto de la cinta.
     * @param array $options Opciones adicionales.
     *   - 'color' (string): Color de fondo (e.g., 'primary', 'success').
     *   - 'position' (string): Posición ('left', 'right').
     *   - 'class' (string): Clases CSS adicionales para el div de la cinta.
     * @return string HTML del componente.
     */
    public static function render(string $text, array $options = []): string {
        $defaultOptions = [
            'color' => 'primary',
            'position' => 'right',
            'class' => '',
        ];
        $options = array_merge($defaultOptions, $options);

        // Estilos básicos para simular una cinta si no hay clases de AdminLTE
        // Esto requeriría CSS adicional en tu proyecto para verse bien.
        $style = 'position: absolute; top: 0; ' . $options['position'] . ': 0;';
        $colorClass = 'text-bg-' . $options['color'];

        return <<<HTML
<div class="ribbon-wrapper ribbon-{$options['position']} {$options['class']}">
  <div class="ribbon {$colorClass}">
    {$text}
  </div>
</div>
HTML;
    }
}
