<?php

if (!function_exists('secure_route')) {
    function secure_route($name, $params = []) {
        $url = route($name, $params, false);

        return url($url, [], true);
    }
}
