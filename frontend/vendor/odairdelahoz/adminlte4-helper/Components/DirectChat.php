<?php
declare(strict_types=1);

namespace AdminLTE\Components;

class DirectChat {
    /**
     * Genera un componente Direct Chat.
     */
    public static function render(string $title, array $messages, array $options = []): string {
        $defaultOptions = ['color' => 'primary', 'show_form' => true];
        $options = array_merge($defaultOptions, $options);

        $html = '<div class="card direct-chat direct-chat-' . $options['color'] . '">';
        $html .= '  <div class="card-header"><h3 class="card-title">' . htmlspecialchars($title) . '</h3></div>';
        $html .= '  <div class="card-body"><div class="direct-chat-messages" style="height: 300px;">';

        foreach ($messages as $msg) {
            $alignClass = ($msg['align'] ?? 'left') === 'right' ? 'end' : '';
            $floatClass = $alignClass === 'end' ? 'float-start' : 'float-end';
            $floatClassReverse = $alignClass === 'end' ? 'float-end' : 'float-start';

            $html .= '<div class="direct-chat-msg ' . $alignClass . '">';
            $html .= '  <div class="direct-chat-infos clearfix">';
            $html .= '    <span class="direct-chat-name ' . $floatClassReverse . '">' . htmlspecialchars($msg['name']) . '</span>';
            $html .= '    <span class="direct-chat-timestamp ' . $floatClass . '">' . htmlspecialchars($msg['timestamp']) . '</span>';
            $html .= '  </div>';
            $html .= '  <img class="direct-chat-img" src="' . htmlspecialchars($msg['image']) . '" alt="message user image">';
            $html .= '  <div class="direct-chat-text">' . htmlspecialchars($msg['text']) . '</div>';
            $html .= '</div>';
        }

        $html .= '  </div></div>';

        if ($options['show_form']) {
            $html .= '<div class="card-footer">';
            $html .= '  <form action="#" method="post"><div class="input-group">';
            $html .= '    <input type="text" name="message" placeholder="Type Message ..." class="form-control">';
            $html .= '    <span class="input-group-append"><button type="button" class="btn btn-' . $options['color'] . '">Send</button></span>';
            $html .= '  </div></form>';
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }
}
