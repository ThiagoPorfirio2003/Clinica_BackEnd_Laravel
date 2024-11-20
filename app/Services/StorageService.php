<?php

namespace App\Services;

use App\Support\PayloadWithStatus\StringWithStatus;
use App\Support\Status\MyHTTPStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService{

    private function saveOneFile(string $disk, string $path, string $name, UploadedFile $file) : StringWithStatus 
    {
        $saveStatus = MyHTTPStatus::createStatusServerError('El archivo no pudo ser guardado');
        $fullPath = Storage::disk($disk)->putFileAs($path, $file, $name);

        if($fullPath)
        {
            $saveStatus->changeStatusToCreated('El archivo ha sido guardado con éxito');
        }

        return new StringWithStatus($saveStatus, $fullPath);
    }
    
    private function savePublicFile(string $path, string $name, UploadedFile $file) : StringWithStatus
    {
        return $this->saveOneFile('public', $path, $name, $file);
    }

    public function saveUserAvatar(string $newFileName, UploadedFile $file) : StringWithStatus
    {
        /*
        $saveResult = $this->savePublicFile('/imgs/avatars', $newFileName, $file);

        if($saveResult->myHTTPStatus->status === 201)
        {
            $saveResult->setPayloadStrict() = Storage::url($saveResult->getPayload());
        }*/

        return $this->savePublicFile('/imgs/avatars', $newFileName, $file);
    }

    public function defineFileName(string $prefix, UploadedFile $file) : string
    {
        return $prefix . '_' . time() . '.' . $file->extension();
    }
}
