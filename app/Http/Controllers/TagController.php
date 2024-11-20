<?php

namespace App\Http\Controllers;

use App\Models\Fichero;
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

    $ficheroId = $request->input('fichero_id');
    $tagId = $request->input('tag_id');

    $fichero = Fichero::findOrFail($ficheroId);

    if (!$fichero->tags->contains($tagId)) {
        $fichero->tags()->attach($tagId);
    }

    return redirect()->back()->with('success', 'Etiqueta añadida correctamente.');
}


}