<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Timeline {
    /**
     * Genera un componente Timeline.
     */
    public static function render(array $items): string {
        $html = '<div class="timeline">';

        foreach ($items as $item) {
            if (($item['type'] ?? '') === 'label') {
                $html .= '<div class="time-label"><span class="text-bg-' . ($item['color'] ?? 'secondary') . '">' . htmlspecialchars($item['text']) . '</span></div>';
            } else {
                $html .= '<div>';
                $html .= '  <i class="timeline-icon ' . ($item['icon'] ?? '') . ' text-bg-' . ($item['icon_color'] ?? 'secondary') . '"></i>';
                $html .= '  <div class="timeline-item">';
                if (isset($item['time'])) {
                    $html .= '<span class="time"><i class="bi bi-clock-fill"></i> ' . htmlspecialchars($item['time']) . '</span>';
                }
                if (isset($item['header'])) {
                    $html .= '<h3 class="timeline-header">' . $item['header'] . '</h3>';
                }
                if (isset($item['body'])) {
                    $html .= '<div class="timeline-body">' . $item['body'] . '</div>';
                }
                if (isset($item['footer'])) {
                    $html .= '<div class="timeline-footer">' . $item['footer'] . '</div>';
                }
                $html .= '  </div>';
                $html .= '</div>';
            }
        }
        $html .= '<div><i class="timeline-icon bi bi-clock-fill text-bg-secondary"></i></div>';
        $html .= '</div>';
        return $html;
    }
}
