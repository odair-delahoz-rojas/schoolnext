<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Tabs {
    /**
     * Genera un componente de Pestañas (Tabs).
     */
    public static function render(array $tabs, array $options = []): string {
        $defaultOptions = ['id_prefix' => 'custom-tabs-', 'card' => true];
        $options = array_merge($defaultOptions, $options);

        $navHtml = '';
        $contentHtml = '';
        $hasActive = false;

        foreach ($tabs as $i => $tab) {
            $tabId = $options['id_prefix'] . ($tab['id'] ?? $i);
            $isActive = ($tab['active'] ?? false) && !$hasActive;
            if ($isActive) $hasActive = true;

            $navHtml .= '<li class="nav-item" role="presentation">';
            $navHtml .= '<button class="nav-link' . ($isActive ? ' active' : '') . '" id="' . $tabId . '-tab" data-bs-toggle="tab" data-bs-target="#' . $tabId . '-pane" type="button" role="tab" aria-controls="' . $tabId . '-pane" aria-selected="' . ($isActive ? 'true' : 'false') . '">' . htmlspecialchars($tab['title']) . '</button>';
            $navHtml .= '</li>';

            $contentHtml .= '<div class="tab-pane fade' . ($isActive ? ' show active' : '') . '" id="' . $tabId . '-pane" role="tabpanel" aria-labelledby="' . $tabId . '-tab" tabindex="0">' . $tab['content'] . '</div>';
        }

        $finalHtml = '<ul class="nav nav-tabs" role="tablist">' . $navHtml . '</ul>';
        $finalHtml .= '<div class="tab-content p-3">' . $contentHtml . '</div>';

        if ($options['card']) {
            $cardTitle = is_string($options['card']) ? $options['card'] : 'Tabs';
            $finalHtml = Card::render($cardTitle, $finalHtml, ['collapsable' => true]);
        }

        return $finalHtml;
    }
}
