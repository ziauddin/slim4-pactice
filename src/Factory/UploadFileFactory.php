<?php

namespace App\Factory;

use Slim\Psr7\UploadedFile;

/**
 * Factory.
 */
final class UploadFileFactory
{
    private string $path;

    /**
     * The constructor.
     *
     * @param string $path The file upload Path
     */
    public function __construct(string $path)
    {
        $this->path = (string)$path ?? '';
    }

    /**
     * @param UploadedFile $uploadedFile file uploaded file to move
     *
     * @return string filename of moved file name
     */
    public function moveUploadedFile(UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($this->path . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
