<?php
declare(strict_types=1);

namespace AdminLTE\Widgets;

use AdminLTE\Components\Card;
use AdminLTE\Components\Badge;

class ProductList {
    /**
     * Renderiza un widget de lista de productos.
     *
     * @param string $title Título de la tarjeta.
     * @param array $products Array de productos. Cada producto es un array asociativo.
     *   - 'image' (string): URL de la imagen del producto.
     *   - 'name' (string): Nombre del producto.
     *   - 'price' (string): Precio del producto.
     *   - 'price_color' (string): Color del badge del precio.
     *   - 'description' (string): Descripción corta del producto.
     *   - 'link' (string): URL del producto.
     * @param array $options Opciones adicionales.
     *   - 'footer_link' (string|null): URL para el enlace en el pie de página.
     * @return string HTML del widget.
     */
    public static function render(string $title, array $products, array $options = []): string {
        $defaultOptions = [
            'footer_link' => null,
            'footer_text' => 'View All Products'
        ];
        $options = array_merge($defaultOptions, $options);

        $body = '<div class="px-2"><div class="list-group list-group-flush">';
        foreach ($products as $product) {
            $body .= '<div class="d-flex border-top py-2 px-1">';
            $body .= '  <div class="col-2"><img src="' . htmlspecialchars($product['image']) . '" alt="Product Image" class="img-size-50"></div>';
            $body .= '  <div class="col-10"><a href="' . htmlspecialchars($product['link'] ?? '#') . '" class="fw-bold">';
            $body .= '    ' . htmlspecialchars($product['name']);
            $body .= '    ' . Badge::render($product['price'], ['color' => $product['price_color'] ?? 'warning', 'class' => 'float-end']);
            $body .= '  </a>';
            $body .= '  <div class="text-truncate">' . htmlspecialchars($product['description']) . '</div>';
            $body .= '</div>';
        }
        $body .= '</div></div>';

        $cardOptions = [
            'collapsable' => true,
            'removable' => true,
            'customClass' => 'p-0' // Para que la lista ocupe todo el espacio
        ];

        if ($options['footer_link']) {
            $cardOptions['footer'] = '<div class="text-center"><a href="' . htmlspecialchars($options['footer_link']) . '" class="uppercase">' . htmlspecialchars($options['footer_text']) . '</a></div>';
        }

        return Card::render($title, $body, $cardOptions);
    }
}
