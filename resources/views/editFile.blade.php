@extends('partials.base')
@section('content')
    <h1>Editar Metadatos del Archivo</h1>
    <form method="POST" action="{{ route('ficheros.update', $fichero) }}">
        @csrf
        @method('PUT')

        <!-- Nombre del archivo -->
        <label for="name">Nombre del archivo:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $fichero->name) }}" required><br><br>

        <!-- Descripción -->
        <label for="description">Descripción:</label>
        <textarea name="description" id="description" rows="5">{{ old('description', $fichero->description) }}</textarea><br><br>

        <!-- Etiquetas -->
        <label>Etiquetas:</label><br>
        @foreach ($tags as $tag)
            <label>
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                {{ $fichero->tags->contains($tag->id) ? 'checked' : '' }}> {{ $tag->name }}
            </label><br>
        @endforeach

        <!-- Guardar -->
        <button type="submit">Guardar Metadatos</button>
    </form>
@endsection
