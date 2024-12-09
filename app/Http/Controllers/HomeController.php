<?php
namespace App\Http\Controllers;

use App\Models\Fichero;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $ficheros = Fichero::where('is_trashed', false)->get();
        $filesToShow = [];
        $user = Auth::user();

        if ($user) {
            foreach ($ficheros as $file) {
                if ($file->user_id == $user->id) {
                    $filesToShow[] = $file;
                }
            }
            return view('welcome')->with('ficheros', $filesToShow);
        } else {
            return redirect('/login');
        }
    }

    public function trash()
    {
        $ficheros = Fichero::where('is_trashed', true)->get();
        return view('trash')->with('ficheros', $ficheros);
    }

    public function storage()
    {
        $storageLimitInGB = 10; // Limite máximo de almacenamiento: 10GB
        $user = Auth::user();
        
        // Recuperar todos los ficheros del usuario autenticado
        $ficheros = Fichero::where('user_id', $user->id)->get();
        
        $totalStorageUsed = 0;
    
        // Calcular el tamaño de todos los archivos del usuario
        foreach ($ficheros as $fichero) {
            if (Storage::exists($fichero->path)) {
                $totalStorageUsed += Storage::size($fichero->path);
            }
        }
        
        // Convertir bytes a gigabytes
        $totalStorageUsedInGB = $totalStorageUsed / (1024 * 1024 * 1024);
        
        // Calcular el porcentaje de almacenamiento utilizado
        $storagePercentageUsed = ($totalStorageUsedInGB / $storageLimitInGB) * 100;
    
        // Redondear a dos decimales
        $totalStorageUsedInGB = round($totalStorageUsedInGB, 2);
        $storagePercentageUsed = round($storagePercentageUsed, 2);
    
        return view('storage')
            ->with('totalStorageUsedInGB', $totalStorageUsedInGB)
            ->with('storageLimitInGB', $storageLimitInGB)
            ->with('storagePercentageUsed', $storagePercentageUsed);
    }
    
}
