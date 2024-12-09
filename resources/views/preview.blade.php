@extends('partials.base')

@section('content')
    <div class="head-container">
        <h1>Vista Previa de Archivo</h1>
    </div>

    <div>
        <p><strong>Nombre del Archivo:</strong> {{ $fichero->name }}</p>
        <p><strong>Tamaño:</strong> {{ round(Storage::size($fichero->path) / 1024, 2) }} KB</p>
    </div>

    @if ($isTextFile)
        <form action="{{ route('ficheros.updateTextFile', $fichero->id) }}" method="POST">
            @csrf
            <div>
                <label for="content">Contenido del Archivo:</label>
                <textarea id="content" name="content" rows="10" style="width: 100%;">{{ $content }}</textarea>
            </div>
            <button type="submit" style="background-color: green; color: white; padding: 10px; border: none; cursor: pointer; border-radius: 5px;">Guardar Cambios</button>
        </form>
    @else
        <div>
            <p><strong>Este archivo no es de tipo texto y no se puede editar.</strong></p>
        </div>
    @endif

    <a href="{{ route('ficheros.download', $fichero->id) }}" style="display: block; margin-top: 20px; text-decoration: underline;">Descargar Archivo</a>

@endsection
