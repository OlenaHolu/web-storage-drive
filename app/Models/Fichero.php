<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;


class Fichero extends Model
{
    public function size()
    {
        if (Storage::exists($this->path)) {
            return Storage::size($this->path);
        }

        return 0; // Retornar 0 si el archivo no existe
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tags()
{
    return $this->belongsToMany(Tag::class, 'fichero_tags', 'fichero_id', 'tag_id');
}

}
