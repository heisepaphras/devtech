<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryUploader
{
    private static function sdk(): Cloudinary
    {
        return app(Cloudinary::class);
    }

    /**
     * Upload an image file to Cloudinary and return the secure URL.
     */
    public static function uploadImage(UploadedFile $file, string $folder): string
    {
        $result = self::sdk()->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'academy/' . $folder,
        ]);

        return $result['secure_url'];
    }

    /**
     * Upload a raw file (e.g. PDF) to Cloudinary and return the secure URL.
     */
    public static function uploadRaw(UploadedFile $file, string $folder): string
    {
        $result = self::sdk()->uploadApi()->upload($file->getRealPath(), [
            'folder'        => 'academy/' . $folder,
            'resource_type' => 'raw',
        ]);

        return $result['secure_url'];
    }

    /**
     * Delete a previously uploaded image from Cloudinary using its stored URL.
     */
    public static function deleteImage(string $url): void
    {
        $publicId = self::extractPublicId($url, false);
        if ($publicId) {
            self::sdk()->uploadApi()->destroy($publicId);
        }
    }

    /**
     * Delete a previously uploaded raw file from Cloudinary using its stored URL.
     */
    public static function deleteRaw(string $url): void
    {
        $publicId = self::extractPublicId($url, true);
        if ($publicId) {
            self::sdk()->uploadApi()->destroy($publicId, ['resource_type' => 'raw']);
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

        // For image resources, strip the file extension — it is not part of the public_id.
        // For raw resources, the extension is included in the public_id.
        if (!$isRaw) {
            $path = (string) preg_replace('/\.[^.\/]+$/', '', $path);
        }

        return $path ?: null;
    }
}
