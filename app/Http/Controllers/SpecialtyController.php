<?php

namespace App\Http\Controllers;

use App\Entities\Specialties\NewSpecialtyDTO;
use App\Http\Requests\createSpecialtyRequest;
use App\Support\Status\MyHTTPStatus;
use Illuminate\Http\JsonResponse;

class SpecialtyController extends Controller
{
    //

    public function create(createSpecialtyRequest $createSpecialtyRequest) : JsonResponse
    {
        $creationStatus = MyHTTPStatus::createStatusServerError();

        $newSpecialtyModel = NewSpecialtyDTO::fromArray($createSpecialtyRequest->validated())->toModel();

        try
        {
            if($newSpecialtyModel->save())
            {
                $creationStatus->changeStatusToCreated('La especialidad ha sido guardada con éxito');
            }
        }
        catch(\Exception $e)
        {
            $creationStatus->message = $e->getMessage();
        }

        return response()->json($creationStatus, $creationStatus->status);
    }
}
