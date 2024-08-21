<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $image_url = asset('storage/' . $this->blog_image);
        return [
            'image_url' => $image_url,
            'post_date' => $this->created_at,
            'category' => $this->category,
            'title' => $this->title

        ];
    }
}
