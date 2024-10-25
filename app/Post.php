<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'post_status_id',
        'title',
        'content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function postStatus(): BelongsTo
    {
        return $this->belongsTo(PostStatus::class);
    }
}
