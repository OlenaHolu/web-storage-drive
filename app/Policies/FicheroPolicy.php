<?php

namespace App\Policies;

use App\Models\Fichero;
use App\Models\User;

class FicheroPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function upload(User $user):bool{
        return true;
    }

    public function download(User $user, Fichero $fichero): bool
    {
        return $fichero->user->id === $user->id;
    }

    public function seeFile(User $user, Fichero $fichero)
{
    // Verifica si el usuario es el propietario del fichero
    if ($user->id === $fichero->user_id) {
        return true;
    }

    // Verifica si el fichero ha sido compartido con el usuario
    if ($fichero->users()->where('user_id', $user->id)->exists()) {
        return true;
    }

    // Si no es el propietario ni está compartido con él, retorna false
    return false;
}

}
