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
                \$userId = $expression;
                \$totalSize = 0;

                \$uploadedClearances = \App\Models\UploadedClearance::where('user_id', \$userId)->get();

                foreach (\$uploadedClearances as \$clearance) {
                    \$filePath = storage_path('app/public/' . \$clearance->file_path);
                    if (file_exists(\$filePath)) {
                        \$totalSize += filesize(\$filePath);
                    }
                }

                \$storageSizeASP = \$totalSize;
                \$maxStorage = 1500;
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