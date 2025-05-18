<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;

class Post extends Model
{
    use Likeable;

    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'content'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }



}
