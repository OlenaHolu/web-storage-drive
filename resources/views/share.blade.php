@extends('partials.base')

@section('title', 'Compartir Archivos')

@section('content')
    <h1>Compartir Archivos</h1>

    <!-- Archivos Seleccionados -->
    <h2>Archivos Seleccionados:</h2>
    <ul>
        @foreach ($ficheros as $fichero)
            <li>{{ $fichero->name }}</li>
        @endforeach
    </ul>

    <!-- Formulario para Compartir Archivos -->
    <form method="POST" action="/share/process">
        @csrf

        <h2>Selecciona Usuarios para Compartir:</h2>
        <div class="user-selection">
            @foreach ($users as $user)
                <div>
                    <input type="checkbox" name="users_ids[]" value="{{ $user->id }}" id="user-{{ $user->id }}">
                    <label for="user-{{ $user->id }}">{{ $user->name }}</label>
                </div>
            @endforeach
        </div>

        <!-- Archivos IDs como inputs ocultos -->
        @foreach ($ficheros as $fichero)
            <input type="hidden" name="ficheros_ids[{{ $fichero->id }}]" value="1">
        @endforeach

        <br>

        <button type="submit">Compartir</button>
        <button type="button" onclick="window.location.href='/'">Cancelar</button>

    </form>
@endsection
