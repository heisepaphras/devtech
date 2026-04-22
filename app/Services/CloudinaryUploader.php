<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryUploader
{
    /**
     * Upload an image file to Cloudinary and return the secure URL.
     */
    public static function uploadImage(UploadedFile $file, string $folder): string
    {
        return Cloudinary::upload($file->getRealPath(), [
            'folder' => 'academy/' . $folder,
        ])->getSecurePath();
    }

    /**
     * Upload a raw file (e.g. PDF) to Cloudinary and return the secure URL.
     */
    public static function uploadRaw(UploadedFile $file, string $folder): string
    {
        return Cloudinary::uploadFile($file->getRealPath(), [
            'folder'        => 'academy/' . $folder,
            'resource_type' => 'raw',
        ])->getSecurePath();
    }

    /**
     * Delete a previously uploaded image from Cloudinary using its stored URL.
     */
    public static function deleteImage(string $url): void
    {
        $publicId = self::extractPublicId($url, false);
        if ($publicId) {
            Cloudinary::destroy($publicId);
        }
    }

    /**
     * Delete a previously uploaded raw file from Cloudinary using its stored URL.
     */
    public static function deleteRaw(string $url): void
    {
        $publicId = self::extractPublicId($url, true);
        if ($publicId) {
            Cloudinary::destroy($publicId, ['resource_type' => 'raw']);
        }
    }

    /**
     * Extract the Cloudinary public_id from a secure URL.
     *
     * Image URL:  https://res.cloudinary.com/{cloud}/image/upload/v{n}/{folder/name}.jpg
     * Raw URL:    https://res.cloudinary.com/{cloud}/raw/upload/v{n}/{folder/name}.pdf
     */
    private static function extractPublicId(string $url, bool $isRaw): ?string
    {
        if (!preg_match('#/upload/(?:v\d+/)?(.+)$#', $url, $matches)) {
            return null;
        }

        $path = $matches[1];

        // For image resources, strip the file extension as it's not part of the public_id.
        // For raw resources, the extension is included in the public_id.
        if (!$isRaw) {
            $path = (string) preg_replace('/\.[^.\/]+$/', '', $path);
        }

        return $path ?: null;
    }
}
