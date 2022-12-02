<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AvatarPhotosResource extends JsonResource
{

    public static $wrap = 'avatars';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $files = Storage::disk('public_site')->files('avatars');
        $avatarResponse = [];

        foreach ($files as $filePath){
            $filename = basename($filePath);
            $avatarResponse[] = [
              'name' => $filename,
              'url' => asset('avatars/' . $filename)
            ];
        }

        return $avatarResponse;
    }
}
