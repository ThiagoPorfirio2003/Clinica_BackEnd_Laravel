<?php

namespace App\Entities\Users\Profile;

use App\Entities\Users\UserRoles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class newUserProfileDTO extends BaseUserProfileDTO
{
    public function __construct(
        string $name,
        string $surname,
        Carbon $birthdate,
        int $dni,
        bool $isEnabled,
        UserRoles $role,
        public UploadedFile $img) 
    {
        parent::__construct($name, $surname, $birthdate, $dni, $isEnabled, $role);
    }

    /**
     * 
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data) : self
    {
        return new self(
            $data['name'],
            $data['surname'],
            $data['birthdate'],
            $data['dni'],
            $data['isEnabled'],
            $data['role'],
            $data['img']
        );
    }

    public function toModel(int $credentialId, string $imgName) : UserProfileModel
    {
        $userProfileModel = new UserProfileModel();

        $userProfileModel->name = $this->name;
        $userProfileModel->surname = $this->surname;
        $userProfileModel->birthdate = $this->birthdate;
        $userProfileModel->dni = $this->dni;
        $userProfileModel->is_enabled = $this->isEnabled;
        $userProfileModel->role = $this->role->label();
        $userProfileModel->credential_id = $credentialId;
        $userProfileModel->img_name = $imgName;

        return $userProfileModel;
    }
}