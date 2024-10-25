<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'post_status';

    protected $fillable = [
        'code',
        'title'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
