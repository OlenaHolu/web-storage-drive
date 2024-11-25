@extends('partials.base')
@section('content')
<div class="head-container">
    <h1>Mi unidad</h1>
    @can('upload', App\Models\Fichero::class)
        <form class="upload-form" method="POST" action="/upload" enctype="multipart/form-data">
            @csrf
            <input type="file" name="uploaded_files[]" multiple />
            <input type="submit" value="Upload" />
        </form>
    @endcan
</div>
<form action="/delete_or_share" method="get">
    <table>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Name</th>
            <th>Size</th>
            <th>Owner</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Tags</th>
        </tr>
        @foreach ($ficheros as $fichero)
            @can('seeFile', $fichero)
                <tr>
                    <td><input type="checkbox" name="ficheros_ids[{{ $fichero->id }}]" /></td>
                    <td><a href="/share?ficheros_ids[{{ $fichero->id }}]=on" title="Compartir este archivo">👥</a></td>
                    <td><a href="/edit/{{ $fichero->id }}" title="Editar el archivo">✏️</a></td>
                    <td><a href="/delete?ficheros_ids[{{ $fichero->id }}]=on" title="Mover a papelera">🗑</a></td>
                    <td><a href="/download/{{ $fichero->id }}" title="Descargar archivo">{{ $fichero->name }}</a></td>
                    <td>{{ $fichero->size() }}</td>
                    <td>{{ $fichero->user->name }}</td>
                    <td>{{ $fichero->created_at }}</td>
                    <td>{{ $fichero->updated_at }}</td>
                    <td>
                        <form method="POST" action="/tags/add-to-file/{{ $fichero->id }}">
                            @csrf
                            <input type="hidden" name="fichero_id" value="{{ $fichero->id }}">
                            <select name="tag_id">
                                <option value="" selected disabled>Seleccionar etiqueta</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit">Añadir</button>
                        </form>
                    </td>
                </tr>
            @endcan
        @endforeach
    </table>
    <button type="submit" name="action" value="share" title="Compartir los archivos seleccionados">Compartir Seleccionados</button>
    <button type="submit" name="action" value="delete" title="Eliminar los archivos seleccionados">Eliminar Seleccionados</button>
</form>
@endsection
