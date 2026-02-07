<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Modal {
    /**
     * Genera el HTML para una ventana modal.
     *
     * @param string $id ID único del modal.
     * @param string $title Título en la cabecera del modal.
     * @param string $body Contenido HTML del cuerpo del modal.
     * @param array $options Opciones adicionales.
     *   - 'footer' (string|null): Contenido del pie de página. Si es null, se usa un botón de cierre por defecto.
     *   - 'size' (string): Tamaño del modal ('sm', 'lg', 'xl').
     *   - 'static_backdrop' (bool): Si es true, el modal no se cierra al hacer clic fuera.
     * @return string HTML del componente.
     */
    public static function render(string $id, string $title, string $body, array $options = []): string {
        $defaultOptions = [
            'footer' => null,
            'size' => '',
            'static_backdrop' => false
        ];
        $options = array_merge($defaultOptions, $options);

        $modalDialogClasses = 'modal-dialog';
        if ($options['size']) {
            $modalDialogClasses .= ' modal-' . $options['size'];
        }

        $staticBackdropAttr = $options['static_backdrop'] ? 'data-bs-backdrop="static" data-bs-keyboard="false"' : '';

        $footerHtml = $options['footer'] ?? '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';

        $html = <<<HTML
<div class="modal fade" id="{$id}" tabindex="-1" aria-labelledby="{$id}Label" aria-hidden="true" {$staticBackdropAttr}>
  <div class="{$modalDialogClasses}">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="{$id}Label">{$title}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {$body}
      </div>
      <div class="modal-footer">
        {$footerHtml}
      </div>
    </div>
  </div>
</div>
HTML;

        return $html;
    }

    /**
     * Genera un botón para activar un modal.
     *
     * @param string $targetId ID del modal a activar.
     * @param string $text Texto del botón.
     * @param array $options Opciones adicionales.
     *   - 'class' (string): Clases CSS para el botón.
     * @return string HTML del botón.
     */
    public static function renderToggleButton(string $targetId, string $text, array $options = []): string {
        $defaultOptions = ['class' => 'btn btn-primary'];
        $options = array_merge($defaultOptions, $options);

        return '<button type="button" class="' . $options['class'] . '" data-bs-toggle="modal" data-bs-target="#' . $targetId . '">' . htmlspecialchars($text) . '</button>';
    }
}
