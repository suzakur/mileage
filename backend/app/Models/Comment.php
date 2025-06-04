<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = ['post_id', 'user_id', 'content', 'parent_id'];

    // A comment can have many replies (child comments).
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // A comment can belong to a post.
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // A comment can belong to a user (the commenter).
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}