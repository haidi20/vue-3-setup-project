<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileHelper
{
    private static function getImageManager()
    {
        return new ImageManager(new Driver());
    }

    /**
     * Upload file to public storage disk
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $fileName
     * @return array
     */
    public static function uploadFile(UploadedFile $file, string $folder, ?string $fileName = null): array
    {
        try {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $fileName = $fileName ?: $originalName . '_' . time() . '.' . $extension;
            $fileName = self::sanitizeFileName($fileName);

            $path = $file->storeAs($folder, $fileName, 'public');

            return [
                'path' => $path,
                'name' => $fileName,
                'original_name' => $originalName . '.' . $extension,
                'extension' => $extension,
                'size' => $file->getSize(),
            ];
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check if a file exists in public storage disk
     *
     * @param string|null $path
     * @return bool
     */
    public static function fileExists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }
        return Storage::disk('public')->exists($path);
    }

    /**
     * Upload image with compression and optional resizing
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $fileName
     * @param int $quality
     * @param array|null $resize [width, height]
     * @return array
     * @throws \Exception
     */
    public static function uploadImage(
        UploadedFile $file,
        string $folder,
        ?string $fileName = null,
        int $quality = 85,
        ?array $resize = null
    ): array {
        try {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());

            $targetExtension = in_array($extension, ['gif', 'svg']) ? $extension : 'webp';

            $baseFileName = $fileName ?: $originalName . '_' . time();
            $baseFileName = self::sanitizeFileName($baseFileName);

            $fileName = $baseFileName . '.' . $targetExtension;

            $manager = self::getImageManager();
            $image = $manager->read($file->getRealPath());

            if ($resize && count($resize) === 2) {
                $image->resize($resize[0], $resize[1], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upSize();
                });
            }

            $path = $folder . '/' . $fileName;
            $dirPath = dirname(storage_path('app/public/' . $path));

            if (!file_exists($dirPath)) {
                mkdir($dirPath, 0755, true);
            }

            if ($targetExtension !== 'webp') {
                $image->save(storage_path('app/public/' . $path), $quality);
            } else {
                $image->toWebp($quality)->save(storage_path('app/public/' . $path));
            }

            return [
                'path' => $path,
                'name' => $fileName,
                'original_name' => $originalName . '.' . $extension,
                'extension' => $targetExtension,
                'size' => Storage::disk('public')->size($path),
                'dimensions' => [
                    'width' => $image->width(),
                    'height' => $image->height(),
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Error uploading image: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle update image with delete old file
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $oldPath
     * @param int $quality
     * @param array|null $resize
     * @return array
     * @throws \Exception
     */
    public static function updateImage(
        UploadedFile $file,
        string $folder,
        ?string $oldPath = null,
        int $quality = 85,
        ?array $resize = null
    ): array {
        if ($oldPath) {
            self::deleteFile($oldPath);
        }

        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return self::uploadImage($file, $folder, $fileName, $quality, $resize);
    }

    /**
     * Delete file from public storage disk
     *
     * @param string|null $path Path to file
     * @return bool
     */
    public static function deleteFile(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        try {
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Sanitize file name
     *
     * @param string $fileName
     * @return string
     */
    private static function sanitizeFileName(string $fileName): string
    {
        $fileName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $fileName);
        $fileName = preg_replace('/_+/', '_', $fileName);
        return $fileName;
    }

    // kebutuhan di seekerEducationRepository dan seekerSkillRepository

    public static function handleCertificateUpload($model, array $data, array $certificates, int $index, string $path, $oldCertificate = null)
    {
        // Cek apakah ada file baru
        if (
            isset($certificates[$index]) &&
            $certificates[$index] instanceof UploadedFile
        ) {
            $file = $certificates[$index];

            // Hapus file lama jika sudah ada
            if ($oldCertificate && self::fileExists($oldCertificate)) {
                self::deleteFile($oldCertificate);
            }

            // Upload file baru
            $uploadResult = self::uploadFile($file, $path);

            // Update model dengan informasi file baru
            $model->update([
                'certificate' => $uploadResult['path'],
            ]);
        } elseif (self::fileExists($oldCertificate)) {
            // Tidak ada file baru → gunakan file lama
            $model->update([
                'certificate' => $oldCertificate,
            ]);
        }
    }
}
