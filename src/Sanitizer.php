<?php

namespace Axn\RequestSanitizer;

class Sanitizer
{
    private static $builtInFilters = [
        'trim',
        'stripped'
    ];

    public static function sanitize(array $rules, array $input)
    {
        foreach ($rules as $attribute => $filters)
        {
            if (is_string($filters)) {
                $filters = array_reverse(explode('|', $filters));
            }

            foreach ($filters as $filter)
            {
                if (in_array($filter, static::builtInFilters))
                {
                    switch ($filter)
                    {
                        default:
                        case 'trim':
                            $input[$attribute] = static::trim($input[$attribute]);
                            break;

                        case 'stripped':
                            $input[$attribute] = static::strip($input[$attribute]);
                            break;

                    }
                }
                elseif (is_callable($filter))
                {
                    $input[$attribute] = call_user_func($filter, $input[$attribute]);
                }
            }
        }

        return $input;
    }

    private function trim($string)
    {
        //$string = trim($string, " \t\n\r\0\x0B&nbsp;");
        $string = str_replace('&nbsp;', '', $string);
        $string = trim($string);

        return $string;
    }

    private function strip($string)
    {
        $string = filter_var($string, FILTER_SANITIZE_STRING);

        return $string;
    }
}
