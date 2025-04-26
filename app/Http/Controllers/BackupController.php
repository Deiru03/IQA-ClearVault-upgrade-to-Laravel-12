<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use App\Jobs\BackupUserDocuments; // Import the job class

class BackupController extends Controller
{
    public function index()
    {
        return view('components.backup.index'); // Render the backup configuration page
    }

    public function runBackup(Request $request)
    {
        // Validate the request
        $request->validate([
            'backup_database' => 'nullable|boolean',
            'backup_files' => 'nullable|boolean',
        ]);

        // Prepare the backup options
        $options = [];

        if ($request->backup_database) {
            $options['--only-db'] = true; // Backup only the database
        }

        if ($request->backup_files) {
            $options['--only-files'] = true; // Backup only the files
        }

        // Run the backup command with the selected options
        try {
            Artisan::call('backup:run', $options);

            // Retrieve the output after the command is executed
            $output = Artisan::output();

            // Debug the output
            dd('Backup Output: ' . $output);

            $backupPath = storage_path('app/private/OMSC IQA ClearVault');
            if (is_dir($backupPath)) {
                return redirect()->back()->with('success', 'Backup completed successfully! Backup saved to: ' . $backupPath);
            } else {
                return redirect()->back()->with('error', 'Backup completed, but the backup file could not be found.');
            }
        } catch (\Throwable $e) {
            dd('Backup Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }
    public function backupDatabase(Request $request)
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
    
        // Connect to the database
        $mysqli = new \mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
        if ($mysqli->connect_error) {
            return redirect()->back()->with('error', 'Failed to connect to the database: ' . $mysqli->connect_error);
        }
    
        // Start creating the SQL dump
        $sqlDump = "-- Database Backup\n";
        $sqlDump .= "-- Database: {$dbName}\n";
        $sqlDump .= "-- Generated on: " . now()->toDateTimeString() . "\n\n";
    
        // Fetch all tables
        $tables = $mysqli->query("SHOW TABLES");
        while ($table = $tables->fetch_array()) {
            $tableName = $table[0];
    
            // Add table structure
            $createTableResult = $mysqli->query("SHOW CREATE TABLE {$tableName}");
            $createTableRow = $createTableResult->fetch_array();
            $sqlDump .= "-- Structure for table `{$tableName}`\n";
            $sqlDump .= $createTableRow[1] . ";\n\n";
    
            // Add table data
            $sqlDump .= "-- Data for table `{$tableName}`\n";
            $rows = $mysqli->query("SELECT * FROM {$tableName}");
            while ($row = $rows->fetch_assoc()) {
                $values = array_map([$mysqli, 'real_escape_string'], array_values($row));
                $values = "'" . implode("', '", $values) . "'";
                $sqlDump .= "INSERT INTO `{$tableName}` VALUES ({$values});\n";
            }
            $sqlDump .= "\n";
        }
    
        // Close the database connection
        $mysqli->close();
    
        // Save the SQL dump to a file
        $backupPath = storage_path('app/private/OMSC IQA ClearVault/' . $dbName . '_' . now()->format('Y-m-d_H-i-s') . '.sql');
        if (!file_exists(storage_path('app/private/OMSC IQA ClearVault'))) {
            mkdir(storage_path('app/private/OMSC IQA ClearVault'), 0755, true);
        }
        file_put_contents($backupPath, $sqlDump);
    
        // Return the file for download without deleting it afterwards
        return response()->download($backupPath)->deleteFileAfterSend(false);
    }

    public function backupUserDocuments(Request $request)
    {
        $sourcePath = storage_path('app/public/user_uploaded_documents');
        $backupPath = storage_path('app/private/OMSC IQA ClearVault/user_uploaded_documents_' . now()->format('Y-m-d_H-i-s') . '.zip');
    
        // Check if the source directory exists
        if (!file_exists($sourcePath)) {
            return redirect()->back()->with('error', 'The user_uploaded_documents directory does not exist.');
        }
    
        // Ensure the backup directory exists
        if (!file_exists(storage_path('app/private/OMSC IQA ClearVault'))) {
            mkdir(storage_path('app/private/OMSC IQA ClearVault'), 0755, true);
        }
    
        // Create a zip archive
        $zip = new \ZipArchive();
        if ($zip->open($backupPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($sourcePath, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($sourcePath) + 1);
    
                    // Add file to the zip archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
    
            return redirect()->back()->with('success', 'User documents backup saved successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create the zip archive.');
        }
    }

    public function downloadBackup($fileName)
    {
        $backupPath = storage_path('app/private/OMSC IQA ClearVault/' . $fileName);

        if (file_exists($backupPath)) {
            return response()->download($backupPath);
        } else {
            return redirect()->back()->with('error', 'The requested backup file does not exist.');
        }
    }

    public function deleteBackup($fileName)
    {
        $backupPath = storage_path('app/private/OMSC IQA ClearVault/' . $fileName);

        if (file_exists($backupPath)) {
            unlink($backupPath);
            return redirect()->back()->with('success', 'Backup file deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'The requested backup file does not exist.');
        }
    }

    // public function backupUserDocuments(Request $request)
    // {
    //     BackupUserDocuments::dispatch();
    //     return redirect()->back()->with('success', 'Backup process started. You will be notified when it is complete.');
    // }
    // public function streamUserDocumentsBackup(Request $request)
    // {
    //     $sourcePath = storage_path('app/public/user_uploaded_documents');

    //     // Check if the source directory exists
    //     if (!file_exists($sourcePath)) {
    //         return redirect()->back()->with('error', 'The user_uploaded_documents directory does not exist.');
    //     }

    //     // Stream the zip file to the browser
    //     $zipFileName = 'user_uploaded_documents_' . now()->format('Y-m-d_H-i-s') . '.zip';

    //     return response()->streamDownload(function () use ($sourcePath) {
    //         $zip = new \ZipArchive();
    //         $tmpFile = tempnam(sys_get_temp_dir(), 'zip');

    //         if ($zip->open($tmpFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
    //             $files = new \RecursiveIteratorIterator(
    //                 new \RecursiveDirectoryIterator($sourcePath),
    //                 \RecursiveIteratorIterator::LEAVES_ONLY
    //             );

    //             foreach ($files as $file) {
    //                 if (!$file->isDir()) {
    //                     $filePath = $file->getRealPath();
    //                     $relativePath = substr($filePath, strlen($sourcePath) + 1);

    //                     // Add file to the zip archive
    //                     $zip->addFile($filePath, $relativePath);
    //                 }
    //             }

    //             $zip->close();

    //             // Output the zip file
    //             readfile($tmpFile);

    //             // Delete the temporary file
    //             unlink($tmpFile);
    //         }
    //     }, $zipFileName);
    // }
}
