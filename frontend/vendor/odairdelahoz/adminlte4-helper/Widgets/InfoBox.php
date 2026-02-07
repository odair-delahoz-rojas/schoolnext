<?php
declare(strict_types=1);

namespace AdminLTE\Widgets;

class InfoBox {
    /**
     * Renderiza un Info Box.
     *
     * @param string $text El texto principal.
     * @param string $number El número o estadística.
     * @param string $icon La clase del icono (e.g., 'bi bi-gear-fill').
     * @param array $options Opciones adicionales.
     *   - 'color' (string): Color de fondo del icono (e.g., 'primary', 'success').
     * @return string HTML del componente.
     */
    public static function render(string $text, string $number, string $icon, array $options = []): string {
        $defaultOptions = ['color' => 'primary'];
        $options = array_merge($defaultOptions, $options);

        return <<<HTML
<div class="info-box">
  <span class="info-box-icon text-bg-{$options['color']} shadow-sm">
    <i class="{$icon}"></i>
  </span>
  <div class="info-box-content">
    <span class="info-box-text">{$text}</span>
    <span class="info-box-number">{$number}</span>
  </div>
</div>
HTML;
    }
}
