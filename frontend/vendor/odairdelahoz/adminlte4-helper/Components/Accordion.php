<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Accordion {
    /**
     * Genera un componente Accordion.
     */
    public static function render(array $items, array $options = []): string {
        $defaultOptions = ['id' => 'accordion-example', 'card' => true];
        $options = array_merge($defaultOptions, $options);

        $accordionHtml = '<div class="accordion" id="' . $options['id'] . '">';
        $hasOpen = false;

        foreach ($items as $i => $item) {
            $itemId = $options['id'] . '-' . $i;
            $isOpen = ($item['open'] ?? false) && !$hasOpen;
            if ($isOpen) $hasOpen = true;

            $accordionHtml .= '<div class="accordion-item">';
            $accordionHtml .= '  <h2 class="accordion-header">';
            $accordionHtml .= '    <button class="accordion-button' . ($isOpen ? '' : ' collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $itemId . '-collapse" aria-expanded="' . ($isOpen ? 'true' : 'false') . '">' . htmlspecialchars($item['title']) . '</button>';
            $accordionHtml .= '  </h2>';
            $accordionHtml .= '  <div id="' . $itemId . '-collapse" class="accordion-collapse collapse' . ($isOpen ? ' show' : '') . '" data-bs-parent="#' . $options['id'] . '">';
            $accordionHtml .= '      <div class="accordion-body">' . $item['content'] . '</div>';
            $accordionHtml .= '  </div>';
            $accordionHtml .= '</div>';
        }

        $accordionHtml .= '</div>';

        if ($options['card']) {
            $cardTitle = is_string($options['card']) ? $options['card'] : 'Accordion';
            $accordionHtml = Card::render($cardTitle, $accordionHtml);
        }

        return $accordionHtml;
    }
}
