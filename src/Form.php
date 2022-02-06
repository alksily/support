<?php

namespace Alksily\Support;

use Alksily\Support\Traits\Macroable;

/**
 * @method static string text(string $name, array $options = [])
 * @method static string search(string $name, array $options = [])
 * @method static string url(string $name, array $options = [])
 * @method static string email(string $name, array $options = [])
 * @method static string tel(string $name, array $options = [])
 * @method static string password(string $name, array $options = [])
 * @method static string number(string $name, array $options = [])
 * @method static string range(string $name, array $options = [])
 * @method static string time(string $name, array $options = [])
 * @method static string date(string $name, array $options = [])
 * @method static string datetime(string $name, array $options = [])
 * @method static string week(string $name, array $options = [])
 * @method static string month(string $name, array $options = [])
 * @method static string color(string $name, array $options = [])
 * @method static string textarea(string $name, array $options = [])
 * @method static string checkbox(string $name, array $options = [])
 * @method static string radio(string $name, array $options = [])
 * @method static string submit(string $name, array $options = [])
 * @method static string reset(string $name, array $options = [])
 * @method static string button(string $name, array $options = [])
 * @method static string file(string $name, array $options = [])
 * @method static string hidden(string $name, array $options = [])
 */
class Form
{
    use Macroable;

    /**
     * Array of field errors
     *
     * @var array
     */
    public static array $globalError = [];

    /**
     * Class name for input when error
     *
     * @var string
     */
    public static string $errorClassName = 'error';

    /**
     * Array of supported types
     *
     * @var array
     */
    protected static array $type = [
        'text', 'search', 'url', 'email', 'tel', 'password',
        'number', 'range',
        'time', 'date', 'datetime', 'week', 'month',
        'color',
        'textarea',
        'checkbox', 'radio', 'select',
        'submit', 'reset', 'button', 'file',
        'hidden',
    ];

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return string|null
     */
    public static function __callStatic(string $method, array $parameters): ?string
    {
        if (in_array($method, static::$type)) {
            if (count($parameters) == 2) {
                [$name, $data] = $parameters;
            } else {
                $name = reset($parameters);
                $data = [];
            }

            return static::render(array_merge($data, ['name' => $name, 'type' => $method]));
        }

        return null;
    }

    /**
     * @param string $name
     * @param array  $option
     * @param array  $data
     *
     * @return string
     */
    public static function select(string $name, array $option = [], array $data = []): string
    {
        return static::render(array_merge($data, ['name' => $name, 'type' => 'select', 'option' => $option]));
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected static function render(array $data = []): string
    {
        $default = [
            'method' => 'post',
            'id' => null,
            'class' => [],
            'error' => '',
            'style' => null,
            'type' => 'text',
            'name' => null,
            'data' => [],
            'placeholder' => null,
            'tabindex' => null,
            'form' => null,
            'list' => null,
            'readonly' => false,
            'disabled' => false,
            'required' => false,
            'autofocus' => false,
            'autocomplete' => null,
        ];
        $form = '';

        // determine the type of the required form
        switch ($data['type']) {
            case 'textarea':
                $attr = [
                    'maxlength' => null,
                    'cols' => null,
                    'rows' => null,
                    'wrap' => null,
                ];
                $data = array_merge($default, $attr, $data);

                $form .= '<textarea ' . static::getAttr($data, ['value', 'type']) . '>';
                $form .= $data['value'] ?? '';
                $form .= '</textarea>';

                break;
            case 'select':
                $attr = [
                    'option' => [],
                    'selected' => null,
                    'multiple' => false,
                ];
                $data = array_merge($default, $attr, $data);

                $form .= '<select ' . static::getAttr($data) . '>';
                foreach ($data['option'] as $key => $val) {
                    $form .= '<option';
                    $form .= ' value="' . $key . '"';

                    if ($data['selected'] && $data['selected'] == $key || is_array($data['selected']) && in_array($key, $data['selected'])) {
                        $form .= ' selected';
                    }

                    $form .= '>';
                    $form .= $val;
                    $form .= '</option>';
                }
                $form .= '</select>';

                break;
            default:
                // select a specific type
                switch ($data['type']) {
                    case 'radio':
                    case 'checkbox':
                        $attr = [
                            'value' => null,
                            'checked' => false,
                        ];

                        break;
                    case 'file':
                        $attr = [
                            'value' => null,
                            'accept' => null,
                            'multiple' => false,
                        ];

                        break;
                    case 'number':
                    case 'range':
                    case 'date':
                    case 'week':
                    case 'month':
                        $attr = [
                            'value' => null,
                            'max' => null,
                            'min' => null,
                            'step' => null,
                        ];

                        break;
                    case 'datetime':
                        $attr = [
                            'value' => null,
                            'max' => null,
                            'min' => null,
                            'step' => null,
                        ];
                        $data['type'] = 'datetime-local';

                        break;
                    default:
                        $attr = [
                            'value' => null,
                            'maxlength' => null,
                            'pattern' => null,
                        ];

                        break;
                }
                $data = array_merge($default, $attr, $data);
                $form .= '<input ' . static::getAttr($data) . ' />';

                break;
        }

        return $form;
    }

    /**
     * Method helper generating attributes and properties
     *
     * @param array $data
     * @param array $exclude
     *
     * @return string
     */
    protected static function getAttr(array &$data = [], array $exclude = []): string
    {
        $attr = [];

        // substituted values
        $value = match (strtolower($data['method'] ?? '')) {
            'get' => static::getValue($_GET, $data['name']),
            'post' => static::getValue($_POST, $data['name']),
            default => null,
        };

        if ($value) {
            switch ($data['type']) {
                case 'radio':
                case 'checkbox':
                    if ($value == $data['value']) {
                        $data['checked'] = true;
                    }
                    break;
                default:
                    $data['value'] = $value;
                    break;
            }
        }

        if (isset(static::$globalError[$data['name']])) {
            $data['error'] = static::$globalError[$data['name']];
        }

        if ($data['error']) {
            $data['class'][] = static::$errorClassName;
        }

        if ($data['class']) {
            $data['class'] = implode(' ', (is_array($data['class']) ? $data['class'] : [$data['class']]));
        }

        if ($data['data']) {
            foreach ($data['data'] as $key => $value) {
                $data['data-' . $key] = $value;
            }
        }

        $exclude = array_merge($exclude, ['data', 'method', 'option', 'selected', 'error']);
        foreach ($data as $key => $value) {
            if (in_array($key, $exclude) || is_array($value)) {
                continue;
            }

            if (is_bool($value) && $value) {
                $attr[] = $key;
            } elseif (!is_bool($value) && !is_null($value)) {
                $attr[] = $key . '="' . $value . '"';
            }
        }

        return implode(' ', $attr);
    }

    /**
     *
     *
     * @param array  $array
     * @param string $field
     *
     * @return mixed
     */
    protected static function getValue(array $array, string $field): mixed
    {
        foreach (explode('[', str_replace(']', '', $field)) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return null;
            }
        }

        return $array;
    }
}
