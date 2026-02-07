<?php
declare(strict_types=1);

namespace AdminLTE\Widgets;

class UserMenu {
    /**
     * Renderiza el menú de usuario desplegable.
     *
     * @param string $username
     * @param string $name
     * @param string $image
     * @param string $title
     * @param string $profile_link
     * @param string $signout_link
     * @return string HTML del widget.
     */
    public static function render(
        string $username,
        string $name,
        string $image,
        string $title,
        string $profile_link = '#',
        string $signout_link = '#'
    ): string {
        $usernameHtml = htmlspecialchars($username);
        $nameHtml = htmlspecialchars($name);
        $imageHtml = htmlspecialchars($image);
        $titleHtml = htmlspecialchars($title);
        $profileLinkHtml = htmlspecialchars($profile_link);
        $signoutLinkHtml = htmlspecialchars($signout_link);

        return "
            <li class=\"nav-item dropdown user-menu\">
              <a href=\"#\" class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\">
                <img src=\"{$imageHtml}\" class=\"user-image rounded-circle shadow\" alt=\"User Image\">
                <span class=\"d-none d-md-inline\">{$usernameHtml}</span>
              </a>
              <ul class=\"dropdown-menu dropdown-menu-lg dropdown-menu-end\">
                <li class=\"user-header text-bg-secondary\">
                  <img src=\"{$imageHtml}\" class=\"rounded-circle shadow\" alt=\"User Image\">
                  <p>
                    {$nameHtml} <br/> {$titleHtml}
                  </p>
                </li>
                <li class=\"user-footer\">
                  <a href=\"{$profileLinkHtml}\" class=\"btn btn-default btn-flat\">Perfil</a>
                  <a href=\"{$signoutLinkHtml}\" class=\"btn btn-default btn-flat float-end\">Cerrar Sesión</a>
                </li>
              </ul>
            </li>";
    }
}
