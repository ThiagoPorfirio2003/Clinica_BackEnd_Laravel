<?php

namespace App\Services;

use App\Support\PayloadWithStatus\StringWithStatus;
use App\Support\Status\MyHTTPStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    //La raiz del sistema de archivos esta especificada en filesystems.php
    private const IMAGES_FOLDER_PATH = 'imgs/';
    private const AVATAR_IMG_PATH = self::IMAGES_FOLDER_PATH . 'avatars/';
    private const CURRENT_AVATAR_IMG_PATH = self::AVATAR_IMG_PATH . 'current/';
    private const PRIVATE_DISK = 'local';
    public const PUBLIC_DISK = 'public';

    private function saveFile(string $disk, string $path, string $name, UploadedFile $file) : StringWithStatus 
    {
        $saveStatus = MyHTTPStatus::createStatusServerError('El archivo no pudo ser guardado');
        $fullPath = Storage::disk($disk)->putFileAs($path, $file, $name);

        if($fullPath)
        {
            $saveStatus->changeStatusToCreated('El archivo ha sido guardado con éxito');
        }

        return new StringWithStatus($saveStatus, $fullPath);
    }
    
    public function createFileName(string $fileExt, ?string $prefix = null) : string
    {
        $fileName = time() . '.' . $fileExt;

        if($prefix)
        {
            $fileName = $prefix . '_' . $fileName;
        }

        return $fileName;
    }

    public function saveUserAvatar(int $userId, UploadedFile $userImg, ?string $fileName = null) : StringWithStatus
    {
        if(!$fileName)
        {
            $fileName = $this->createFileName($userImg->extension());
        }

        return $this->saveFile(self::PRIVATE_DISK, self::CURRENT_AVATAR_IMG_PATH . $userId, $fileName, $userImg);
    }


    //$userName es el path
    /*
    private function createUserAvatarName(int $id, int $imgNumber, string $fileExt) : string
    {
        $this->createFileName($id . '_' . $imgNumber, $fileExt);
    }
    */

    /*
    private function savePublicFile(string $path, string $name, UploadedFile $file) : StringWithStatus
    {
        return $this->saveOneFile('public', $path, $name, $file);
    }
    */

    /*
    public function saveUserAvatar(string $username, string $fileName, UploadedFile $file) : StringWithStatus
    {
        /
        $saveResult = $this->savePublicFile('/imgs/avatars', $newFileName, $file);

        if($saveResult->myHTTPStatus->status === 201)
        {
            $saveResult->setPayloadStrict() = Storage::url($saveResult->getPayload());
        }/

        return $this->savePublicFile('/imgs/avatars', $newFileName, $file);
    }*/
}
