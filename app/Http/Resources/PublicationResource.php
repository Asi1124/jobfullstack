<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $fields = explode(',', $request->fields);

        $data =  [
            'id' => $this->id,
            'title' => $this->title,
            'photos' => $this->photos[0],
            'price' => $this->price,
        ];
        if (in_array('description', $fields)) {
            $data['description'] = $this->description;
        }

        if (in_array('photos', $fields)) {
            $data['photos'] = $this->photos;
        }

        return $data;
    }
}
