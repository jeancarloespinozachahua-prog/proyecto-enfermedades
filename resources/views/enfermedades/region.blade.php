@extends('layouts.app')

@section('title', 'Enfermedades en ' . $region)

@section('content')
  <h2>📍 Enfermedades frecuentes en {{ $region }}</h2>

  @if($enfermedades->isEmpty())
    <p>No se encontraron enfermedades registradas en esta región.</p>
  @else
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Gravedad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($enfermedades as $enfermedad)
          <tr>
            <td>{{ $enfermedad->nombre }}</td>
            <td>{{ $enfermedad->descripcion }}</td>
            <td>{{ $enfermedad->gravedad ?? 'No especificada' }}</td>
            <td>
              <a href="{{ route('enfermedades.edit', $enfermedad->id) }}">📝 Editar</a>
              <form action="{{ route('enfermedades.destroy', $enfermedad->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">🗑️ Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <a href="{{ route('enfermedades.index') }}">🔙 Volver al listado</a>
@endsection
