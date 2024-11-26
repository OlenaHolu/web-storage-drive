<?php
namespace App\Http\Controllers;

use App\Models\Fichero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $user = Auth::user();

        $ficheros = Fichero::where('name', 'like', '%' . $query . '%')->get();
        $filesToShow = [];

        foreach ($ficheros as $file) {
            if ($file->user_id == $user->id) {
                $filesToShow[] = $file;
            }
        }

        $shared = $user->sharedFiles;

        return view('search-results')
            ->with('ficheros', $filesToShow)
            ->with('shared', $shared);
    }
}
