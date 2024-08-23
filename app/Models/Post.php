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
        'status',
        'category'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_post', 'post_id', 'category_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
}
