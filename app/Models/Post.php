<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description', 
        'blog_image',
        'status'
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_post', 'post_id', 'category_id');
    }
}
