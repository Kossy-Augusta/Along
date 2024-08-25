<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date = Carbon::parse($this->updated_at);
        return [
            'User_name' => $this->user->name,
            'comment' => $this->description,
            'date' => $this->formatDate($date)

        ];
    }

    protected function formatDate(Carbon $date)
{
    $now = Carbon::now();
    if ($date->isFuture()) {
        return 'In the future';
    }
    $diffInSecs = $date->diffInSeconds($now);
    $diffInMinutes = $date->diffInMinutes($now);
    $diffInHours = $date->diffInHours($now);
    $diffInDays = $date->diffInDays($now);
    $diffInWeeks = $date->diffInWeeks($now);
    $diffInMonths = $date->diffInMonths($now);
    $diffInYears = $date->diffInYears($now);

    if ($diffInSecs < 60) {
        return floor($diffInSecs) . ' sec(s) ago';
    } elseif ($diffInMinutes < 60) {
        return floor($diffInMinutes) . ' minute(s) ago';
    } elseif ($diffInHours < 24) {
        return floor($diffInHours) . ' hour(s) ago';
    } elseif ($diffInDays < 7) {
        return floor($diffInDays) . ' day(s) ago';
    } elseif ($diffInWeeks < 5) {
        return floor($diffInWeeks) . ' week(s) ago';
    } elseif ($diffInMonths < 12) {
        return floor($diffInMonths) . ' month(s) ago';
    } else {
        return floor($diffInYears) . ' year(s) ago';
    }
}
}
