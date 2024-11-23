<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureServiceNorm
{
    public function __construct(
        private ParameterBagInterface $params
    ) {
    }

    public function upload(UploadedFile $picture, ?string $folder = ''): string
    {
        // On donne un nouveau nom à l'image
        $file = md5(uniqid(rand(), true)) . '.webp';

        // On récupère les informations de l'image
        $pictureInfos = getimagesize($picture);

        if ($pictureInfos === false) {
            throw new Exception('Format d\'image incorrect');
        }

        // On vérifie le type mime
        switch ($pictureInfos['mime']) {
            case 'image/png':
                $sourcePicture = imagecreatefrompng($picture);
                break;
            case 'image/jpeg':
                $sourcePicture = imagecreatefromjpeg($picture);
                break;
            case 'image/webp':
                $sourcePicture = imagecreatefromwebp($picture);
                break;
            default:
                throw new Exception('Format d\'image incorrect');
        }

        // On crée le chemin de stockage
        $path = $this->params->get('uploads_directory') . $folder;

        // On crée le dossier s'il n'existe pas
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // On stocke l'image originale
        $picture->move($path, $file);

        return $file;
    }
}