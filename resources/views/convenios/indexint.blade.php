@extends('layouts.inst_conv_mov')
@section('title', 'Convenios Internacionales')

@section('content')
@if(auth()->user()->rol_id == '1' or auth()->user()->rol_id == "2" || auth()->user()->rol_id == "6")
<div class="border border-2 rounded-3 shadow-lg bg-white" style="width: 75%;">
@elseif(auth()->user()->rol_id == "3")
<div class="border border-2 rounded-3 shadow-lg bg-white" style="width: 75%;">
@endif
    @csrf
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center" style="text-shadow: 0px 0px 7px #000;">Convenios Internacionales</h4>
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
                                <th scope="col">Pais</th>
                                <th scope="col">Fecha de Inicio</th>
                                <th scope="col">Vigencia</th> 
                                <th scope="col">Tipo</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Breve Objeto: </th>
                                <th scope="col">Resultados Concretos: </th>
                                <th scope="col">N° de usuarios/No Aplica: </th>
                                <th scope="col">Documentación Soporte: </th>
                                @if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
                                    <th scope="col">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($convInts as $item)
                                <tr>
                                    <td> {{ $item->codigo }}</td>
                                    <td> {{ date_format(date_create($item->created_at), 'd-m-Y') }} </td>
                                    <td> {{ ucwords(strtolower($item->supervisor)) }} </td>
                                    <td> {{ strtoupper($item->nombre) }} </td>
                                    <td> {{ ucfirst(strtolower($item->pais)) }} </td>
                                    <td> {{ $item->fechaInicio }} </td>
                                    <td> {{ $item->vigencia }} </td>
                                    <td> {{ $item->tipo }} </td>
                                    <td> {{ $item->activo }} </td>
                                    <td> {{ ucfirst(strtolower($item->breve_objeto)) }} </td>
                                    <td> {{ ucfirst(strtolower($item->resultados_concretos)) }} </td>
                                    @if ($item->n_usuarios == 0)
                                        <td>No Aplica</td>   
                                    @else 
                                        <td> {{ $item->n_usuarios }} </td>
                                    @endif                            
                                    <td> 
                                        @foreach (explode(",", $item->docSoportes) as $file)
                                            <br> - <a href="{{ url('/download_conv_int', $file) }}">{{$file}}</a>
                                        @endforeach 
                                    </td>
                                    @if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == 2 ||  auth()->user()->rol_id == 6)
                                        <td>
                                            <div class="row">
                                                <div class="w-auto">
                                                    <a class="btn btn-primary  w-100" href="{{ route('convenios_int.edit', $item->id) }}">Editar</a>
                                                </div>
                                                <div class="w-auto">
                                                    <form action="{{ route('convenio_int.destroy', $item->id) }}" method="POST" class="form-delete">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger w-100">Eliminar</button>
                                                    </form>
                                                </div>     
                                            </div>
                                        </td>
                                    @endif
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
                            <form action="{{ route('convInt.export') }}">
                            <div class="form-group mb-2">
                                <label for="desde">Desde:</label>
                                <input type="date" class="form-control" name="convNac_initialDate" id="convNac_initialDate">
                            </div>
                            <div class="form-group mb-2">
                                <label for="desde">Hasta:</label>
                                <input type="date" class="form-control" name="convNac_finalDate" id="convNac_initialDate" >
                            </div>
                            <span><b>Nota*:</b>Puede seleccionar 1 (Desde), ambas o ninguna fecha.</span>
                            <div class="form-row justify-content-around mt-4">
                                <select class="col col-md-8 form-select" name="type_reporte" id="type_reporte" required>
                                    <option value="" selected>&nbsp;&nbsp; -- Tipo de convenio --</option>
                                    <option value="Todos">&nbsp;&nbsp;Todos los convenios</option>
                                    <option value="Practicas">&nbsp;&nbsp;Practicas</option>
                                    <option value="Marco">&nbsp;&nbsp;Marco</option>
                                    <option value="Especifico">&nbsp;&nbsp;Específico</option>
                                    <option value="Interadministrativo">&nbsp;&nbsp;Interadministrativo</option>
                                </select>
                            </div>
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