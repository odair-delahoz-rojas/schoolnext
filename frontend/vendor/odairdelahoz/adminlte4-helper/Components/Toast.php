<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Toast {
    /**
     * Renderiza el HTML para un único toast.
     */
    public static function render(string $id, string $title, string $body, array $options = []): string {
        $defaultOptions = [
            'color' => null,
            'icon' => 'bi bi-circle me-2',
            'timestamp' => 'just now'
        ];
        $options = array_merge($defaultOptions, $options);

        $toastClasses = 'toast';
        if ($options['color']) {
            $toastClasses .= ' toast-' . $options['color'];
        }

        return <<<HTML
<div class="{$toastClasses}" id="{$id}" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <i class="{$options['icon']}"></i>
    <strong class="me-auto">{$title}</strong>
    <small>{$options['timestamp']}</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
    {$body}
  </div>
</div>
HTML;
    }

    /**
     * Renderiza el contenedor de toasts y los toasts dentro de él.
     */
    public static function renderContainer(array $toasts): string {
        $toastsHtml = '';
        foreach ($toasts as $toast) {
            $toastsHtml .= self::render($toast['id'], $toast['title'], $toast['body'], $toast['options'] ?? []);
        }

        return <<<HTML
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  {$toastsHtml}
</div>
HTML;
    }

    /**
     * Renderiza el script de JavaScript para mostrar toasts.
     */
    public static function renderJsTriggerScript(): string {
        return <<<HTML
<script>
  function showToast(toastId) {
    const toastEle = document.getElementById(toastId);
    if (toastEle) {
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastEle);
      toastBootstrap.show();
    }
  }
</script>
HTML;
    }
}
