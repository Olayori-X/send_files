<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class FileController extends Controller
{
    public function generateFiles()
    {
        try {
            // Directory to store files
            $storagePath = 'C:/Users/PC/OneDrive/Desktop/send';

            // Ensure directory exists
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }

            // Create 100 .send files
            for ($i = 1; $i <= 100; $i++) {
                $filename = "file_$i.send";
                $content = "T$i"; // Customize content as needed
                File::put("$storagePath/$filename", $content);
            }

            // print_r($content);
            // Create a ZIP file of all .send files
            $zip = new ZipArchive;
            $zipFileName = 'send_files.zip';
            $zipFilePath = "/$storagePath/$zipFileName";
            dd($zipFilePath);

            if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
                // Add all the .send files to the ZIP
                foreach (File::files($storagePath) as $file) {
                    $zip->addFile($file->getRealPath(), basename($file));
                }
                $zip->close();
            }

            // Return the ZIP file as a download
            return response()->download($zipFilePath)->deleteFileAfterSend(true); // Optional: delete after download
        } catch (\Throwable $th) {
            return response()->json([
                'response' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
