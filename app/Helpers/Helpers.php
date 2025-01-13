<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('set_active_menu')) {
    
    function set_active_menu($uri, $output = 'active') {
        if( is_array($uri) ) {
            foreach ($uri as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($uri)){
                return $output;
            }
        }
    }
}

