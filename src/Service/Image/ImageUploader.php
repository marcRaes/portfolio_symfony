<?php

namespace App\Service\Image;

use App\Enum\ImageUploadType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class ImageUploader
{
    public function __construct(
        private string $baseUploadDir = __DIR__ . '/../../../public/uploads'
    ){}

    public function uploadAndResize(UploadedFile $file, string $filenameBase, ImageUploadType $type): string
    {
        $uploadDir = $this->baseUploadDir . '/' . $type->value;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $ext = $file->guessExtension() ?? 'jpg';
        $originalPath = "$uploadDir/{$filenameBase}.$ext";

        $file->move($uploadDir, "{$filenameBase}.$ext");

        if ($type === ImageUploadType::USER) {
            $thumb64Path = "$uploadDir/64x64_{$filenameBase}.$ext";
            $thumb200Path = "$uploadDir/175x200_{$filenameBase}.$ext";

            $this->resizeImage($originalPath, $thumb64Path, 64, 64);
            $this->resizeImage($originalPath, $thumb200Path, 175, 200);
        }

        return "{$filenameBase}.$ext";
    }

    private function resizeImage(string $src, string $dest, int $width, int $height): void
    {
        [$w, $h] = getimagesize($src);
        $srcImg = imagecreatefromstring(file_get_contents($src));
        $dstImg = imagecreatetruecolor($width, $height);
        imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $width, $height, $w, $h);
        imagejpeg($dstImg, $dest);
        imagedestroy($dstImg);
        imagedestroy($srcImg);
    }
}
