<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class Pagination {
    /**
     * Genera un componente Pagination.
     */
    public static function render(int $currentPage, int $totalPages, array $options = []): string {
        $defaultOptions = ['url_pattern' => '?page=%d', 'size' => '', 'class' => 'justify-content-center'];
        $options = array_merge($defaultOptions, $options);

        if ($totalPages <= 1) {
            return '';
        }

        $sizeClass = $options['size'] ? ' pagination-' . $options['size'] : '';
        $html = '<ul class="pagination' . $sizeClass . ' ' . $options['class'] . '">';

        // Previous button
        $prevDisabled = $currentPage <= 1 ? 'disabled' : '';
        $html .= '<li class="page-item ' . $prevDisabled . '"><a class="page-link" href="' . sprintf($options['url_pattern'], $currentPage - 1) . '">Previous</a></li>';

        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = $i == $currentPage ? 'active' : '';
            $html .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="' . sprintf($options['url_pattern'], $i) . '">' . $i . '</a></li>';
        }

        // Next button
        $nextDisabled = $currentPage >= $totalPages ? 'disabled' : '';
        $html .= '<li class="page-item ' . $nextDisabled . '"><a class="page-link" href="' . sprintf($options['url_pattern'], $currentPage + 1) . '">Next</a></li>';

        $html .= '</ul>';
        return $html;
    }
}
