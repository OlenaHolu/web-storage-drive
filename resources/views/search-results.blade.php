@extends('partials.base')
@section('content')

<h1>Resultados de Búsqueda</h1>

{{-- Sección Mi Unidad --}}
<h2>Mi Unidad</h2>
<table>
    <tr>
        <th>Nombre</th>
        <th>Tamaño</th>
        <th>Propietario</th>
        <th>Creado el</th>
        <th>Actualizado el</th>
    </tr>
    @forelse ($ficheros as $fichero)
        <tr>
            <td><a href="/download/{{ $fichero->id }}">{{ $fichero->name }}</a></td>
            <td>{{ $fichero->size() }}</td>
            <td>{{ $fichero->user->name }}</td>
            <td>{{ $fichero->created_at->toDateString() }}</td>
            <td>{{ $fichero->updated_at->toDateString() }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No se encontraron ficheros en "Mi Unidad" que coincidan con la búsqueda.</td>
        </tr>
    @endforelse
</table>

{{-- Sección Compartido Conmigo --}}
<h2>Compartido Conmigo</h2>
<table>
    <tr>
        <th>Nombre</th>
        <th>Tamaño</th>
        <th>Propietario</th>
        <th>Creado el</th>
        <th>Actualizado el</th>
    </tr>
    @forelse ($shared as $file)
        <tr>
            <td><a href="/download/{{ $file->id }}">{{ $file->name }}</a></td>
            <td>{{ $file->size() }}</td>
            <td>{{ $file->user->name }}</td>
            <td>{{ $file->created_at->toDateString() }}</td>
            <td>{{ $file->updated_at->toDateString() }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No se encontraron ficheros compartidos contigo que coincidan con la búsqueda.</td>
        </tr>
    @endforelse
</table>

@endsection
