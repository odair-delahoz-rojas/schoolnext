<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Treeview {
    /**
     * Renders the entire treeview menu.
     *
     * @param array $items The array of menu items.
     * @param array $options Additional options.
     * @return string The HTML of the treeview.
     */
    public static function render(array $items, array $options = []): string {
        $html = '<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">';
        foreach ($items as $item) {
            $html .= self::renderNode($item);
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * Recursively renders a single node of the treeview.
     *
     * @param array $item The menu item to render.
     * @return string The HTML of the node.
     */
    private static function renderNode(array $item): string {
        $type = $item['type'] ?? 'item';

        if ($type === 'header') {
            return '<li class="nav-header">' . htmlspecialchars($item['text']) . '</li>';
        }

        $hasChildren = !empty($item['children']);
        $liClasses = ['nav-item'];
        if ($hasChildren && ($item['open'] ?? false)) {
            $liClasses[] = 'menu-open';
        }

        $html = '<li class="' . implode(' ', $liClasses) . '">';
        
        $linkClasses = ['nav-link'];
        if ($item['active'] ?? false) {
            $linkClasses[] = 'active';
        }

        $html .= '<a href="' . ($item['link'] ?? '#') . '" class="' . implode(' ', $linkClasses) . '">';
        
        if (isset($item['icon'])) {
            $html .= '<i class="nav-icon ' . $item['icon'] . '"></i>';
        }
        
        $html .= '<p>' . htmlspecialchars($item['text']);

        if (isset($item['badge'])) {
            $badgeColor = $item['badge']['color'] ?? 'primary';
            $html .= ' <span class="nav-badge badge text-bg-' . $badgeColor . ' me-3">' . htmlspecialchars($item['badge']['text']) . '</span>';
        }

        if ($hasChildren) {
            $html .= '<i class="nav-arrow bi bi-chevron-right"></i>';
        }
        
        $html .= '</p></a>';

        if ($hasChildren) {
            $html .= '<ul class="nav nav-treeview">';
            foreach ($item['children'] as $child) {
                $html .= self::renderNode($child);
            }
            $html .= '</ul>';
        }

        $html .= '</li>';
        return $html;
    }
}
