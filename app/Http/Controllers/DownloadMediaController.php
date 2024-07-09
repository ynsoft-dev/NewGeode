<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class DownloadMediaController extends Controller
{
    public function download(Request $request)
    {
        $boxId = $request->input('box_id');

        // Récupérer la boîte
        $box = Box::findOrFail($boxId);

        // Récupérer les médias de la boîte sélectionnée
        $mediaFiles = $box->getMedia('files');
        $mediaImages = $box->getMedia('images');

        $mediaItems = $mediaFiles->merge($mediaImages);

        if ($mediaItems->isEmpty()) {
            return back()->withErrors(['message' => 'No files found for the selected box.']);
        }

        // Si la boîte contient plus d'un fichier, les compresser en un fichier zip
        if ($mediaItems->count() > 1) {
            return $this->downloadMultipleFiles($mediaItems);
        } else {
            $mediaItem = $mediaItems->first();
            return $this->downloadSingleFile($mediaItem);
        }
    }

    public function downloadSingle($mediaId)
    {
        $mediaItem = Media::findOrFail($mediaId);
        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    protected function downloadSingleFile(Media $mediaItem)
    {
        $filePath = $mediaItem->getPath();
        // if (!Storage::disk($mediaItem->disk)->exists($filePath)) {
        //     abort(404, 'File not found.');
        // }

        return response()->download($filePath, $mediaItem->file_name, [
            'Content-Disposition' => 'attachment; filename="' . $mediaItem->file_name . '"',
            'Content-Type' => mime_content_type($filePath),
        ]);
    }

    protected function downloadMultipleFiles($mediaItems)
    {
        // $zip = new ZipArchive;
        // $zipFileName = 'files.zip';
        // $zipFilePath = storage_path('app/' . $zipFileName);

        // if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
        //     foreach ($mediaItems as $mediaItem) {
        //         $zip->addFile($mediaItem->getPath(), $mediaItem->file_name);
        //     }
        //     $zip->close();

        //     return response()->download($zipFilePath)->deleteFileAfterSend(true);
        // } else {
        //     return back()->withErrors(['message' => 'Failed to create zip file.']);
        // }
       

        // Download the files associated with the media in a streamed way.
        // No prob if your files are very large.
        return MediaStream::create('my-files.zip')->addMedia($mediaItems);
    }
}
