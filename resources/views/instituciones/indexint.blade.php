@extends('layouts.inst_conv_mov')
@section('title', 'Instituciones Internacionales')

@section('content')
<div class="border border-2 rounded-3 shadow-lg bg-white" style="width: 75%;">
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center ">Instituciones Internacionales</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <div class="card">
                <div class="card-body">
                    <table id="queryTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Fecha de Creación</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">País</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">NIT o equivalente</th>
                                <th scope="col" class="text-center">Representante</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Email:</th>
                                <th scope="col">Acciones:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instInts as $item)
                                <tr>
                                    <td> {{ $item->id }} </td>
                                    <td> {{ date_format($item->created_at, "d-m-Y") }} </td>
                                    <td> {{ strtoupper($item->nombre) }} </td>
                                    <td> {{ ucwords(strtolower($item->pais)) }} </td>
                                    <td> {{ ucwords(strtolower($item->ciudad)) }} </td>
                                    <td> {{ $item->nit }} </td>
                                    <td> {{ ucwords(strtolower($item->representante)) }} </td>
                                    <td> {{ $item->telefono }} </td>
                                    <td> {{ strtolower($item->email) }} </td>
                                        <td>
                                            <div class="row">
                                                <div class="w-auto">
                                                    <a class="btn btn-primary w-100" href="{{ route('institucion_int.edit', $item->id) }}">Editar</a>
                                                </div>
                                                <div class="w-auto">
                                                    <form action="{{ route('institucion_int.destroy', $item->id) }}" method="POST" class="form-delete">
                                                        @csrf    
                                                        <button type="submit" class="btn btn-outline-danger w-100">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-4">
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
                                <form action="{{ route('instEntInt.export') }}" >
                                <div class="form-group mb-2">
                                    <label for="desde">Desde:</label>
                                    <input type="date" class="form-control" name="instInt_initialDate" id="instInt_initialDate">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="desde">Hasta:</label>
                                    <input type="date" class="form-control" name="instInt_finalDate" id="instInt_finalDate" >
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
</div>
@endsection

