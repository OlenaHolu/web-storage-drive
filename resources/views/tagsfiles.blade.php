@extends('partials.base')
@section('content')
    <h1>Ficheros con la Etiqueta: {{ $tag->name }}</h1>

    @if ($ficheros->isEmpty())
        <p>No hay ficheros con la etiqueta "{{ $tag->name }}" en este momento.</p>
    @else
        <table>
            <tr>
                <th>Name</th>
                <th>Size</th>
                <th>Owner</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>
            @foreach ($ficheros as $fichero)
                <tr>
                    <td><a href="/download/{{ $fichero->id }}">{{ $fichero->name }}</a></td>
                    <td>{{ number_format($fichero->size() / (1024 * 1024), 2) }} MB</td> <!-- Tamaño en MB -->
                    <td>{{ $fichero->user->name }}</td>
                    <td>{{ $fichero->created_at->toDateString() }}</td>
                    <td>{{ $fichero->updated_at->toDateString() }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <a href="{{ url('/') }}" style="display: block; margin-top: 20px;">Volver a la Página Principal</a>
@endsection
