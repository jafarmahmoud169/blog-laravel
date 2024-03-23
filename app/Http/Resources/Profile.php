<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id'=> $this->profile->user_id,
            'user id'=> $this->id,
            'user name'=> $this->name,
            'gender'=> $this->profile->gender,
            'country'=> $this->profile->country,
            'age'=> $this->profile->age,
            'bio'=>$this->profile->bio,
            'photo'=>base64_encode(file_get_contents(public_path('images\profiles/'.$this->profile->photo)))
            //'photo'=>$this->profile->photo
    ];
    }
}
