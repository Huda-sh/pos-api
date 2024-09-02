<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'full_name' => $this->first_name.' '.$this->last_name,
            'email' => $this->email,
            'is_admin' => (bool) $this->is_admin,
            'image' => URL::to('/').'/imgs/'.$this->image,
        ];
    }
}
