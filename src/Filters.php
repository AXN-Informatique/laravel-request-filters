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

    private static function applyBuiltInFilter($filter, $string)
    {
        switch ($filter)
        {
            default:
            case 'trim':
                return static::trim($string);

            case 'stripped':
                return static::strip($string);
        }
    }

    private static function trim($string)
    {
        //$string = trim($string, " \t\n\r\0\x0B&nbsp;");
        $string = str_replace('&nbsp;', '', $string);
        $string = trim($string);

        return $string;
    }

    private static function strip($string)
    {
        $string = filter_var($string, FILTER_SANITIZE_STRING);

        return $string;
    }
}