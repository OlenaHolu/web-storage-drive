<?php

namespace App\Http\Controllers;

use App\Models\Fichero;
use App\Models\Fichero_tag;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function addTag(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|string|max:255',
        ]);
        Tag::create(['name' => $request->tag_name]);
        return redirect()->back()->with('success', 'Etiqueta añadida exitosamente');
    }

    public function addTagToFile(Request $request)
    {
        $request->validate([
            'fichero_id' => 'required|exists:ficheroes,id',
            'tag_id' => 'required|exists:tags,id',
        ]);

        // Verificar si la relación ya existe antes de crearla
        $ficheroTagExists = Fichero_tag::where('fichero_id', $request->fichero_id)
            ->where('tag_id', $request->tag_id)
            ->exists();

        if (!$ficheroTagExists) {
            Fichero_tag::create([
                'fichero_id' => $request->fichero_id,
                'tag_id' => $request->tag_id
            ]);
        }

        return redirect()->back()->with('success', 'Etiqueta añadida correctamente.');
    }
}
