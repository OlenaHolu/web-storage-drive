@extends('partials.base')
@section('content')
    <h1>Papelera</h1>
    <table>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>Name</th>
            <th>Size</th>
            <th>Owner</th>
            <th>Deleted at</th>
        </tr>
        @foreach ($ficheros as $fichero)
            @can('seeFile', $fichero)
            <tr>
                <td><input type="checkbox" name="ficheros_ids[{{ $fichero->id }}]" /></td>
                <td>
                    <a href="/restore/{{ $fichero->id }}" class="button" title="Restaurar archivo">↪️</a>
                </td>
                <td>
                    <a href="/deletetrash/{{ $fichero->id }}" class="button" title="Eliminar definitivamente">❌</a>
                </td>
                <td>
                    <a href="/download/{{ $fichero->id }}" title="Descargar archivo">{{ $fichero->name }}</a>
                </td>
                <td>{{ $fichero->size() }}</td>
                <td>{{ $fichero->user->name }}</td>
                <td>{{ $fichero->updated_at }}</td>
            </tr>
            
            @endcan
        @endforeach
    </table>
@endsection
