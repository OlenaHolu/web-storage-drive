<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fichero;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function downloadFile(Fichero $fichero)
    {
        return Storage::download($fichero->path);
        
    }

    public function upload(Request $request)
    {
        $request->validate(['uploaded_files.*' => 'file']);
        foreach ($request->file('uploaded_files') as $file) {
            $fichero = new Fichero();
            $fichero->path = $file->store();
            $fichero->name = $file->getClientOriginalName();
            $fichero->user_id = Auth::user()->id;
            $fichero->save();
        }
        return redirect('/');
    }

    public function delete_or_share(Request $request)
    {
        if ($request->action == 'delete') {
            //dd($request);
            return $this->delete($request);
        } else {
            return $this->share($request);
        }
    }

    public function delete(Request $request)
    {
        $request->validate(['ficheros_ids' => 'required']);

        $fichs = $request->ficheros_ids;
        //dd($request->query('ficheros_ids'));
        if ($request->query('ficheros_ids') != NULL) {
            $fichs = $request->query('ficheros_ids');
        }

        $ficheros = Fichero::find(array_keys($fichs));
        $user = Auth::user();

        foreach ($ficheros as $file) {
            // Verificar si el usuario es el propietario del archivo
            if ($file->user_id == $user->id) {
                // El propietario puede mover el archivo a la papelera
                $newPath = 'trash/' . $file->name;
                Storage::move($file->path, $newPath);

                // Actualizar la ruta y marcar como eliminado
                $file->path = $newPath;
                $file->is_trashed = true;
                $file->save();
            } else {
                // Si el usuario no es el propietario, solo eliminar la relación de compartición
                $file->users()->detach($user->id);
            }
        }
        return redirect('/');
    }

    public function share(Request $request)
    {
        $request->validate(['ficheros_ids' => 'required']);
        // Obtener todos los usuarios excluyendo al usuario autenticado
        $authUserId = Auth::id(); // Obtener el ID del usuario autenticado
        $users = User::where('id', '!=', $authUserId)->get();
        return view('share')
            ->with('ficheros', Fichero::find(array_keys($request->ficheros_ids)))
            ->with('users', $users);
    }

    public function processShare(Request $request)
    {
        $request->validate([
            'ficheros_ids' => 'required',
            'users_ids' => 'required',
        ]);

        $ficheros = Fichero::find(array_keys($request->ficheros_ids));

        // Obtener los usuarios seleccionados excluyendo al usuario autenticado
        $authUserId = Auth::id();
        $users = User::whereIn('id', $request->users_ids)
            ->where('id', '!=', $authUserId) // Excluir al usuario actual
            ->get();

        foreach ($ficheros as $fichero) {
            foreach ($users as $user) {
                // Añadir la relación en la tabla fichero_user
                if (!$fichero->users->contains($user->id)) {
                    $fichero->users()->attach($user->id);
                }
            }
        }

        return redirect('/')->with('success', 'Archivos compartidos exitosamente');
    }

    public function sharedWithMe()
    {
        $user = Auth::user();

        $ficheros = $user->sharedFiles;

        return view('shared')->with('ficheros', $ficheros);
    }

    public function unshare(Request $request, Fichero $fichero)
    {
        $user = Auth::user();
        $fichero->users()->detach($user->id);

        return redirect('/')->with('success', 'Has dejado de compartir el archivo exitosamente.');
    }

    public function deleteFromTrash(Fichero $file)
    {
        Storage::delete($file->path);
        $file->delete();
        return redirect('/trash');
    }

    public function restore(Fichero $file)
    {
        $originalPath = 'uploads/' . $file->name;
        Storage::move($file->path, $originalPath);
        $file->path = $originalPath;
        $file->is_trashed = false;
        $file->save();
        return redirect('/trash');
    }
    
    public function preview(Fichero $fichero)
{
    if (!Storage::exists($fichero->path)) {
        return redirect()->back()->with('error', 'El archivo no existe.');
    }

    $isTextFile = in_array(pathinfo($fichero->name, PATHINFO_EXTENSION), ['txt', 'md', 'log']); // Define extensiones de texto

    if($isTextFile){
        $content = Storage::get($fichero->path);
        return view('preview', compact('fichero', 'content', 'isTextFile'));
    }
    else {
        return response()->file(Storage::path($fichero->path));
    }
    
}

public function updateTextFile(Request $request, Fichero $fichero)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    if (!Storage::exists($fichero->path)) {
        return redirect()->back()->with('error', 'El archivo no existe.');
    }

    Storage::put($fichero->path, $request->content);

    return redirect()->route('ficheros.preview', $fichero->id);
}

    public function edit(Fichero $fichero)
    {
        return view('editFile', compact('fichero'));
    }

    public function update(Request $request, Fichero $fichero)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Actualizar nombre y descripción
        $fichero->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Actualizar tags
        if ($request->has('tags')) {
            $fichero->tags()->sync($request->tags);
        }

        return redirect('/');
    }
}
