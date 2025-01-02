<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Blade;

class BladeDirectives
{
    public static function register()
    {
        // Register the storageUsage directive
        Blade::directive('storageUsage', function ($expression) {
            return "<?php
                \$storageSizeASP = $expression;
                \$maxStorage = 999;
                \$percentage = number_format(min((\$storageSizeASP / (1024 * 1024 * \$maxStorage)) * 100, 100), 2);
                \$isHighUsage = \$percentage > 90;
            ?>";
        });

        // Register more directives here
        Blade::directive('anotherDirective', function ($expression) {
            return "<?php
                // Your custom logic here
            ?>";
        });
    }
}