@extends('layouts.guest')
@section('title', 'Actividades')

@section('act_content')
<div class="border border-2 rounded-3 shadow-lg mt-5 mb-5" style="width: 70%;background-color: white;">
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center ">Convenios Nacionales</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <div class="card">
                <div class="card-body ">
                    <table id="queryTable"> 
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Fecha de Creación</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">Institución o Entidad</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Fecha de Inicio</th>
                                <th scope="col">Vigencia</th> 
                                <th scope="col">Tipo</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Breve Objeto: </th>
                                <th scope="col">Resultados Concretos: </th>
                                <th scope="col">N° de usuarios/No Aplica: </th>
                                <th scope="col">Documentación Soporte: </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($convNacs as $item)
                                <tr>
                                    <td>{{ $item->codigo }}</td>
                                    <td>{{ date_format(date_create($item->created_at), 'd-m-Y') }}</td>
                                    <td>{{ ucwords(strtolower($item->supervisor)) }}</td>
                                    <td>{{ strtoupper($item->nombre) }}</td>
                                    <td>{{ ucwords(strtolower($item->ciudad)) }}</td>
                                    <td>{{ $item->fechaInicio }}</td>
                                    <td>{{ $item->vigencia }}</td>
                                    <td>{{ $item->tipo }}</td>
                                    <td>{{ $item->activo }}</td>
                                    <td>{{ ucfirst(strtolower($item->breve_objeto)) }}</td>
                                    <td>{{ ucfirst(strtolower($item->resultados_concretos)) }}</td>
                                    @if ($item->n_usuarios == 0)
                                        <td>No Aplica</td>   
                                    @else 
                                        <td>{{ $item->n_usuarios }}</td>
                                    @endif                            
                                    <td> 
                                        @foreach (explode(",", $item->docSoportes) as $file)
                                            <br> - <a href="{{ url('/download_conv_nac', $file) }}">{{$file}}</a>
                                        @endforeach 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="offset-1 col-2">
            <a href="{{ route('activites.guest') }}" class="btn btn-outline-success text-decoration-none">Regresar</a>
        </div>
    </div>
</div>
@endsection