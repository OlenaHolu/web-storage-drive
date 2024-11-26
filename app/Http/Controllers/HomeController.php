<?php
namespace App\Http\Controllers;

use App\Models\Fichero;
use Illuminate\Support\Facades\Auth;

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
}
