<?php
declare(strict_types=1);
namespace AdminLTE\Components;

class Form {

    /**
     * Genera un campo de input genérico.
     * Es mejor usar los métodos específicos como text(), email(), etc.
     */
    private static function _buildInput(string $type, string $name, string $label, array $options = []): string
    {
        $defaultOptions = [
            'value' => '',
            'placeholder' => '',
            'help_text' => '',
            'id' => null,
            'error' => null,
            // Para 'range'
            'min' => null,
            'max' => null,
            'step' => null,
        ];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;

        $isInvalidClass = $options['error'] ? ' is-invalid' : '';
        $controlClass = 'form-control';

        if ($type === 'range') {
            $controlClass = 'form-range';
        }

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';

        $attributes = [
            'type="' . $type . '"',
            'class="' . $controlClass . $isInvalidClass . '"',
            'id="' . $id . '"',
            'name="' . $name . '"',
            'placeholder="' . htmlspecialchars($options['placeholder']) . '"'
        ];

        // El atributo 'value' no se usa en inputs de tipo 'file' por seguridad.
        if ($type !== 'file') {
            $attributes[] = 'value="' . htmlspecialchars($options['value']) . '"';
        }

        if ($type === 'range') {
            if ($options['min'] !== null) $attributes[] = 'min="' . $options['min'] . '"';
            if ($options['max'] !== null) $attributes[] = 'max="' . $options['max'] . '"';
            if ($options['step'] !== null) $attributes[] = 'step="' . $options['step'] . '"';
        }

        $html .= '  <input ' . implode(' ', $attributes) . '>';

        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        } elseif ($options['help_text']) {
            $html .= '<div class="form-text">' . htmlspecialchars($options['help_text']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un campo de input de tipo 'text'.
     */
    public static function text(string $name, string $label, array $options = []): string
    {
        return self::_buildInput('text', $name, $label, $options);
    }

    /**
     * Genera un campo de input de tipo 'password'.
     */
    public static function password(string $name, string $label, array $options = []): string
    {
        return self::_buildInput('password', $name, $label, $options);
    }

    /**
     * Genera un campo de input de tipo 'email'.
     */
    public static function email(string $name, string $label, array $options = []): string
    {
        return self::_buildInput('email', $name, $label, $options);
    }

    /**
     * Genera un campo de input de tipo 'number'.
     */
    public static function number(string $name, string $label, array $options = []): string
    {
        return self::_buildInput('number', $name, $label, $options);
    }

    /**
     * Genera un campo de input de tipo 'date'.
     */
    public static function date(string $name, string $label, array $options = []): string
    {
        return self::_buildInput('date', $name, $label, $options);
    }

    /**
     * Genera un campo de input de tipo 'file'.
     */
    public static function file(string $name, string $label, array $options = []): string
    {
        return self::_buildInput('file', $name, $label, $options);
    }

    /**
     * Genera un campo de input de tipo 'range'.
     */
    public static function range(string $name, string $label, array $options = []): string
    {
        return self::_buildInput('range', $name, $label, $options);
    }

    /**
     * Genera un campo de textarea completo.
     */
    public static function textarea(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['value' => '', 'rows' => 3, 'placeholder' => '', 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';
        $html .= '  <textarea class="form-control' . $isInvalidClass . '" id="' . $id . '" name="' . $name . '" rows="' . $options['rows'] . '" placeholder="' . htmlspecialchars($options['placeholder']) . '">' . htmlspecialchars($options['value']) . '</textarea>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un campo de select completo.
     */
    public static function select(string $name, string $label, array $selectOptions, array $options = []): string
    {
        $defaultOptions = ['selected_value' => null, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';
        $html .= '  <select class="form-select' . $isInvalidClass . '" id="' . $id . '" name="' . $name . '">';
        foreach ($selectOptions as $value => $text) {
            $selectedAttr = ($value == $options['selected_value']) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars((string) $value) . '"' . $selectedAttr . '>' . htmlspecialchars($text) . '</option>';
        }
        $html .= '  </select>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Checkbox.
     */
    public static function customCheckbox(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['value' => '1', 'checked' => false, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'check-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="form-check">';
        $html .= '  <input class="form-check-input' . $isInvalidClass . '" type="checkbox" name="' . $name . '" value="' . htmlspecialchars($options['value']) . '" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback d-block">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Radio button.
     */
    public static function customRadio(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['value' => '1', 'checked' => false, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'radio-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="form-check">';
        $html .= '  <input class="form-check-input' . $isInvalidClass . '" type="radio" name="' . $name . '" value="' . htmlspecialchars($options['value']) . '" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        if ($options['error']) {
            // For grouped radios, error might be better handled outside, but let's provide an option.
            $html .= '<div class="invalid-feedback d-block">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Input Group.
     */
    public static function inputGroup(string $name, array $options = []): string
    {
        $defaultOptions = ['type' => 'text', 'placeholder' => '', 'prepend' => null, 'append' => null, 'value' => '', 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="input-group mb-3">';
        if ($options['prepend']) {
            $html .= '<span class="input-group-text">' . $options['prepend'] . '</span>';
        }
        $html .= '<input type="' . $options['type'] . '" name="' . $name . '" class="form-control' . $isInvalidClass . '" placeholder="' . htmlspecialchars($options['placeholder']) . '" value="' . htmlspecialchars($options['value']) . '">';
        if ($options['append']) {
            $html .= '<span class="input-group-text">' . $options['append'] . '</span>';
        }
        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Switch.
     */
    public static function customSwitch(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['checked' => false, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);

        $id = $options['id'] ?? 'switch-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="form-check form-switch">';
        $html .= '  <input class="form-check-input' . $isInvalidClass . '" type="checkbox" name="' . $name . '" role="switch" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback d-block">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}
