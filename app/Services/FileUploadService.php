<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class FileUploadService
{
    public function storeImage(
        UploadedFile $file,
        string $directory,
        string $disk = 'public'
    ): string {
        $this->ensureValidUpload($file);

        $extension = strtolower(
            $file->extension()
                ?: $file->getClientOriginalExtension()
                ?: 'jpg'
        );

        $filename = Str::uuid()->toString().'.'.$extension;
        $storedPath = trim($directory, '/').'/'.$filename;
        $temporaryPath = $file->getPathname();

        $stream = fopen($temporaryPath, 'rb');

        if ($stream === false) {
            throw new RuntimeException(
                'Não foi possível abrir o arquivo temporário.'
            );
        }

        try {
            $stored = Storage::disk($disk)->put(
                $storedPath,
                $stream
            );
        } finally {
            fclose($stream);
        }

        if (! $stored) {
            throw new RuntimeException(
                'Não foi possível armazenar o arquivo.'
            );
        }

        return $storedPath;
    }

    public function delete(
        ?string $path,
        string $disk = 'public'
    ): void {
        if ($path === null || $path === '') {
            return;
        }

        Storage::disk($disk)->delete($path);
    }

    private function ensureValidUpload(
        UploadedFile $file
    ): void {
        $temporaryPath = $file->getPathname();

        if (
            ! $file->isValid()
            || $temporaryPath === ''
            || ! is_file($temporaryPath)
        ) {
            throw new RuntimeException(
                'O arquivo enviado não pôde ser processado.'
            );
        }
    }
}