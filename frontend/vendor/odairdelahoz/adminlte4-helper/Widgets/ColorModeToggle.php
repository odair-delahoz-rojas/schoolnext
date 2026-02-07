<?php
declare(strict_types=1);

namespace AdminLTE\Widgets;

class ColorModeToggle
{
    /**
     * Build the HTML for the component.
     *
     * @return string
     */
    public function build(): string
    {
        $html = '<li class="nav-item">';
        $html .= '<a class="nav-link" data-lte-toggle="theme" href="#" role="button">';
        $html .= '<i class="fas fa-sun"></i>';
        $html .= '<i class="fas fa-moon"></i>';
        $html .= '</a>';
        $html .= '</li>';

        return $html;
    }
}
