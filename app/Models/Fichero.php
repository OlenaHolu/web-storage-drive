<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;


class Fichero extends Model
{
    public function size(){
        return Storage::size($this->path);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tags()
{
    return $this->belongsToMany(Tag::class);
}
}
