<?php

if (! function_exists('active')) {
    function active($patterns)
    {
        foreach ((array) $patterns as $pattern) {
            if (request()->is($pattern)) {
                return 'bg-blue-50 text-blue-600 border-r-2 border-blue-600';
            }
        }
        return 'text-gray-700 hover:bg-gray-100 hover:text-gray-900';
    }
}

