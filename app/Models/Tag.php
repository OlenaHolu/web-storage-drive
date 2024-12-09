<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function ficheros()
{
    return $this->belongsToMany(Fichero::class, 'fichero_tags', 'tag_id', 'fichero_id');
}


}
