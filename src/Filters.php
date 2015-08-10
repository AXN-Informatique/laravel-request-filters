<?php

namespace Axn\RequestFilters;

class Filters
{
    private static $builtInFilters = [
        'trim',
        'stripped'
    ];

    /**
     * Filter $input according with $filters and return filtered $input.
     *
     * @param array $input
     * @param array $filters
     * @return array
     */
    public static function filtering(array $input, array $filters)
    {
        foreach ($filters as $attribute => $filters)
        {
            if (empty($input[$attribute])) {
                continue;
            }

            if (is_string($filters)) {
                $filters = explode('|', $filters);
            }

            foreach ($filters as $filter)
            {
                if (in_array($filter, static::$builtInFilters)) {
                    $input[$attribute] = static::applyBuiltInFilter($filter, $input[$attribute]);
                }
                elseif (is_callable($filter)) {
                    $input[$attribute] = call_user_func($filter, $input[$attribute]);
                }
                elseif ($filter instanceof Closure) {
                    $input[$attribute] = $filter($input[$attribute]);
                }
            }
        }

        return $input;
    }

    /*
     * Built in filters
     */

    private static function applyBuiltInFilter($filter, $str)
    {
        switch ($filter)
        {
            default:
            case 'trim':
                return static::trim($str);

            case 'strip':
            case 'stripped': // BC
                return static::strip($str);

            case 'url':
                return static::url($str);
        }
    }

    private static function trim($str)
    {
        $str = str_replace('&nbsp;', ' ', $str);
        $str = trim($str);

        return $str;
    }

    private static function strip($str)
    {
        return filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    private static function email($str)
    {
        return filter_var($str, FILTER_SANITIZE_EMAIL);
    }

    private static function url($str)
    {
        return filter_var($str, FILTER_SANITIZE_URL);
    }
}
