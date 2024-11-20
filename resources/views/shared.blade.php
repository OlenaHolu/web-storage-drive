@extends('partials.base')

@section('title', 'Compartido Conmigo')

@section('content')
    <h1>Archivos Compartidos Conmigo</h1>
    @if ($ficheros->isEmpty())
        <p>No hay archivos compartidos contigo en este momento.</p>
    @else
    <table>
        <tr>
            <th></th>
            <th></th>
            <th>Name</th>
            <th>Size</th>
            <th>Compartido por</th>
            <th>Fecha en que se compartio</th>
        </tr>
        @foreach ($ficheros as $fichero)
            @can('seeFile', $fichero)
            <tr>
                <td><input type="checkbox" name="ficheros_ids[{{ $fichero->id }}]" /></td>
                <td>
                    <a href="/unshare/{{ $fichero->id }}" title="Dejar de compartir este archivo">❌</a>
                </td>
                <td>
                    <a href="/download/{{ $fichero->id }}" title="Descargar archivo">{{ $fichero->name }}</a>
                </td>
                <td>{{ $fichero->size() }}</td>
                <td>{{ $fichero->user->name }}</td>
                <td>{{ $fichero->updated_at->format('d/m/Y') }}</td>
            </tr>
            
            @endcan
        @endforeach
    </table>
    @endif
@endsection
