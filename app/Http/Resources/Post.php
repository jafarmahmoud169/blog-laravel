<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
                'id'=> $this->id,
                'user'=> $this->user,
                'title'=> $this->title,
                'slug'=> $this->slug,
                'deleted_at'=> $this->deleted_at,
                'content'=>$this->content,
                'tags'=>$this->tags,
                'created_at'=> $this->created_at->format('d/m/Y'),
                'updated_at'=> $this->updated_at->format('d/m/Y'),
                'comments'=>$this->comments,
                'photo'=>base64_encode(file_get_contents(public_path('images/'.$this->photo)))
        ];
    }
}
