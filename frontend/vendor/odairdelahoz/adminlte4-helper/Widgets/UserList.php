<?php
declare(strict_types=1);

namespace AdminLTE\Widgets;

use AdminLTE\Components\Card;

class UserList {
    /**
     * Renderiza una tarjeta con una lista de usuarios.
     *
     * @param string $title Título de la tarjeta.
     * @param array $users Array de usuarios. Cada usuario es un array asociativo.
     *   - 'name' (string): Nombre del usuario.
     *   - 'image' (string): URL de la imagen.
     *   - 'link' (string): URL del perfil.
     *   - 'meta' (string): Texto secundario (e.g., fecha).
     * @param array $options Opciones adicionales.
     *   - 'badge_text' (string|null): Texto para la insignia en la cabecera.
     *   - 'badge_color' (string): Color de la insignia.
     *   - 'footer_link' (string|null): URL para el enlace en el pie de página.
     * @return string HTML del widget.
     */
    public static function render(string $title, array $users, array $options = []): string {
        $defaultOptions = [
            'badge_text' => null,
            'badge_color' => 'danger',
            'footer_link' => null
        ];
        $options = array_merge($defaultOptions, $options);

        // Construir el cuerpo de la tarjeta con la lista de usuarios
        $body = '<div class="row text-center m-1">';
        foreach ($users as $user) {
            $body .= '<div class="col-3 p-2">';
            $body .= '  <img class="img-fluid rounded-circle" src="' . htmlspecialchars($user['image']) . '" alt="User Image">';
            $body .= '  <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="' . htmlspecialchars($user['link'] ?? '#') . '">' . htmlspecialchars($user['name']) . '</a>';
            $body .= '  <div class="fs-8">' . htmlspecialchars($user['meta'] ?? '') . '</div>';
        }
        $body .= '</div>';

        // Opciones para la tarjeta principal
        $cardOptions = [
            'collapsable' => true,
            'removable' => true,
            'customClass' => 'p-0' // Para que la lista ocupe todo el espacio
        ];

        if ($options['badge_text']) {
            $cardOptions['tools'] = '<span class="badge text-bg-' . $options['badge_color'] . '">' . htmlspecialchars((string)$options['badge_text']) . '</span>';
        }
        
        if ($options['footer_link']) {
            $cardOptions['footer'] = '<div class="text-center"><a href="' . htmlspecialchars((string)$options['footer_link']) . '" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View All Users</a></div>';
        }

        // Usamos nuestro componente Card ya existente para renderizar el widget
        return Card::render($title, $body, $cardOptions);
    }
}
