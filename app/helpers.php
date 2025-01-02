<?php

if (!function_exists('getDirectorySize')) {
    function getDirectorySize($dir)
    {
        $size = 0;

        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : getDirectorySize($each);
        }

        return $size;
    }
}