<?php

use App\Models\Fichero;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TagController;

Route::get('/', function () {
    // mostrar solo ficheros que no están en papelera
    $ficheros = Fichero::where('is_trashed', false)->get();
    return view('welcome')->with('ficheros', $ficheros);
});

Route::get('/trash', function () {
    // papelera
    $ficheros = Fichero::where('is_trashed', true)->get();
    return view('trash')->with('ficheros', $ficheros);
});

Route::post('/upload', function (Request $request) {
    $request->validate(['uploaded_files.*' => 'file']);
    foreach ($request->file('uploaded_files') as $file) {
        $fichero = new Fichero();
        $fichero->path = $file->store();
        $fichero->name = $file->getClientOriginalName();
        $fichero->user_id = Auth::user()->id;
        $fichero->save();
    }
    return redirect('/');
})->can('upload', Fichero::class);

Route::get('/download/{fichero}', function (Fichero $fichero) {
    return Storage::download($fichero->path);
})->can('download', 'fichero');

Route::get('/delete_or_share', [FileController::class, 'delete_or_share']);
Route::get('/delete', [FileController::class, 'delete']);
Route::get('/share', [FileController::class, 'share']);

// Ruta para procesar la acción de compartir archivos
Route::post('/share/process', [FileController::class, 'processShare']);
Route::get('/shared', [FileController::class, 'sharedWithMe']);
Route::get('/unshare/{fichero}', [FileController::class, 'unshare']);


Route::get('/deletetrash/{file}', function (Fichero $file) {
    Storage::delete($file->path);
    Fichero::destroy($file->id);

    return redirect('/trash');
})->can('seeFile', 'file');


Route::get('/restore/{file}', function (Fichero $file) {
    // Mover el archivo de vuelta a su directorio original
    $originalPath = 'uploads/' . $file->name;
    Storage::move($file->path, $originalPath);

    // Actualizar la ruta y marcar como no eliminado
    $file->path = $originalPath;
    $file->is_trashed = false;
    $file->save();

    return redirect('/trash');
});


Route::get('/search', function (Request $request) {
    $query = $request->input('query');

    // Buscar ficheros que coincidan con la consulta
    $ficheros = Fichero::where('name', 'like', '%' . $query . '%')
        ->get();

    return view('search-results')->with('ficheros', $ficheros);
});

Route::post('/tags/add', [TagController::class, 'addTag']);
Route::post('/tags/add-to-file/{file}', [TagController::class, 'addTagToFile']);




//login logout

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});

Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
});


/* Route::get('/delete/{file}', function(Fichero $file) {
    // Mover archivo a papelera
    $newPath = 'trash/' . $file->name;
    Storage::move($file->path, $newPath);
    
    // Actualizar ruta y marcar como eliminado
    $file->path = $newPath;
    $file->is_trashed = true;
    $file->save();

    return redirect('/');
})->can('delete', 'file');
*/
/*Route::get('/share/{file}', function(Fichero $file){
   return view('share')
      ->with('file', $file)
      ->with('users', User::all());
});*/

/*Route::get('/delete_or_share', function (Request $request) {
    $request->validate(['ficheros_ids' => 'required']);
    

    if ($request->action === 'delete') {
        $ficheros = Fichero::find(array_keys($request->ficheros_ids));

        foreach ($ficheros as $file) {
            // Mover  archivo a papelera
            $newPath = 'trash/' . $file->name;
            Storage::move($file->path, $newPath);

            // Actualizar ruta y marcar como eliminado
            $file->path = $newPath;
            $file->is_trashed = true;
            $file->save();
        }
        return redirect('/');
    } else {
        return view('share')
            ->with('ficheros', Fichero::find(array_keys($request->ficheros_ids)))
            ->with('users', User::all());
    }
});


Route::get('/share', function (Request $request) {
    $request->validate(['ficheros_ids' => 'required']);

    return view('share')
        ->with('ficheros', Fichero::find(array_keys($request->ficheros_ids)))
        ->with('users', User::all());
});

Route::get('/delete', function (Request $request) {
    $request->validate(['ficheros_ids' => 'required']);

    $ficheros = Fichero::find(array_keys($request->ficheros_ids));

    foreach ($ficheros as $file) {
        // Mover  archivo a papelera
        $newPath = 'trash/' . $file->name;
        Storage::move($file->path, $newPath);

        // Actualizar ruta y marcar como eliminado
        $file->path = $newPath;
        $file->is_trashed = true;
        $file->save();
    }
    return redirect('/');
});
*/