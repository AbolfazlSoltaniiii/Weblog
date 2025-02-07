<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'post_id'
    ];

    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')
            ->select(['id', 'username', 'email']);
    }
}
