@extends('layouts.inst_conv_mov')
@section('title', 'Movilidades Internacionales Entrantes')

@section('content')
<form action="" class="border border-2 rounded-3 shadow-lg mt-5 mb-5" style="width: 95%;">
    @csrf
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center ">Movilidades Internacionales Entrantes</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <div class="card">
                <div class="card-body ">
                    <table id="queryTable"> 
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Fecha de Creación</th>
                                <th scope="col">Tipo de Persona</th>
                                <th scope="col">Institución o Entidad</th>
                                <th scope="col">Colectivo o Individual</th>
                                <th scope="col">Nombre Completo (Si es Individual)</th>
                                <th scope="col">Cantidad de Movilidades (Si es Colectivo)</th>
                                <th scope="col">Titulos Obtenidos <br>(Si es docente)</th>
                                <th scope="col">Acciones</th>
                                <th scope="col">Activo en la Institución/Entidad</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Vigencia</th>
                                <th scope="col">Sede o Regional</th>
                                <th scope="col">Objeto</th>
                                <th scope="col">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($moventr as $item)
                                <tr><td class="text-center"> {{ $item->id }} </td>
                                    <td> {{ date_format(date_create($item->created_at), 'd-m-Y') }} </td>
                                    <td> {{ $item->tipoPersona }}</td>
                                    <td> {{ $item->nombre }} </td>
                                    <td> {{ $item->colInd}} </td>
                                    <td> {{ $item->fullname }} </td>
                                    <td> {{ $item->cantidad }} </td>
                                    <td> {{ $item->titulosOb }} </td>
                                    
                                    @if (auth()->user()->rol_id == 3 || auth()->user()->rol_id == 6 || $item->user_id == auth()->user()->id)
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <a class="btn btn-primary  w-100" href="{{ route('movilidadIntEnt.edit', $item->id) }}">Editar</a>
                                            </div>
                                        </div>
                                        <form action="{{route('movilidadIntEnt.destroy', $item->id)}}" method="POST" class="form-delete">
                                            @csrf
                                            <div class="row mt-1">
                                                    
                                                <div class="col">
                                                    <button type="submit" class="btn btn-outline-danger w-100">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    @else
                                    <td> No cuenta con los permisos necesarios </td>
                                    @endif
                                    <td> {{ $item->activo }} </td>
                                    <td> {{ $item->fecha }} </td>
                                    <td> {{ $item->vigencia }} </td>
                                    <td> {{ $item->sedeReg }} </td>
                                    <td> {{ $item->objeto }} </td>
                                    <td> {{ $item->resultado }} </td>
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
            <a href="{{ route('login.activites') }}" class="btn btn-outline-success text-decoration-none">Regresar</a>
        </div>
        <div class="offset-5 col-3">
            <button type="button" class="btn btn-outline-dark w-100" data-toggle="modal" data-target="#exampleModalCenter">Generar Reportes  <i class="bi bi-file-earmark-spreadsheet-fill"></i></button>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Reportes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('movIntEnt.export') }}">
                            <div class="form-group mb-2">
                                <label for="desde">Desde:</label>
                                <input type="date" class="form-control" name="mie_initialDate" id="mie_initialDate">
                            </div>
                            <div class="form-group mb-2">
                                <label for="desde">Hasta:</label>
                                <input type="date" class="form-control" name="mie_finalDate" id="mie_initialDate" >
                            </div>
                            <span><b>Nota*:</b>Puede seleccionar 1 (Desde), ambas o ninguna fecha.</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-outline-success">Descargar</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection