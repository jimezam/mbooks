@extends('layouts.app')

@section('content')

<div class="container">

@include('layouts.subview_breadcrumbs') 

<h1>Ver página</h1>
<p class="lead">
    Consultar la información completa de este libro.
</p>
<p>
    <a href="{!! route('mbooks.msections.msheets.create', [$mbook, $msection]) !!}" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</a>
    <a href="{{ route('mbooks.msections.msheets.index', [$mbook, $msection]) }}" class="btn btn-info" style="margin-right: 5px; float:left"><i class="fas fa-arrow-left"></i> Volver</a>
</p>

<div class="row">
    <div id="items-list" class="col-md-4" style="padding-top: 5px;">

    @forelse($msheets as $_msheet)

        <div class="card" style="margin-bottom: 5px;">
            <div class="card-body {{ ($msheet->id == $_msheet->id) ? 'aler alert-primary' : '' }}">
                <h5 class="card-title">{{ $_msheet->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted"></h6>
                <p class="card-text">
                    
                </p>
                <a href="{{ route('mbooks.msections.msheets.show', [$mbook, $msection, $_msheet]) }}" class="btn btn-info btn-sm" style="margin-right: 5px; float:left"><i class="fas fa-eye"></i> Ver</a>
                <a href="{{ route('mbooks.msections.msheets.moveDown', [$mbook, $msection, $_msheet]) }}" class="btn btn-secondary btn-sm" style="margin-right: 5px; float:left"><i class="fas fa-long-arrow-alt-up"></i> Subir</a>
                <a href="{{ route('mbooks.msections.msheets.moveUp', [$mbook, $msection, $_msheet]) }}" class="btn btn-secondary btn-sm" style="margin-right: 5px; float:left"><i class="fas fa-long-arrow-alt-down"></i> Bajar</a>
            </div>
        </div>

    @empty

        <div class="alert alert-info" role="alert">
            No hay registros que mostrar.
        </div>

    @endforelse

    </div>
    <div id="items-show" class="col-md-8">
        <div class="card">
            <div class="card-body">
                {!! nl2br($msheet->contents) !!}
            </div>
        </div>

        <div style="margin-top: 10px; margin-bottom: 50px;">
            <a href="{{ route('mbooks.msections.msheets.edit', [$mbook, $msection, $_msheet]) }}" class="btn btn-warning btn-sm" style="margin-right: 5px; float:left"><i class="fas fa-pencil-alt"></i> Editar</a>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['mbooks.msections.msheets.destroy', $mbook, $msection, $_msheet],
                'style' => 'float:left',
                'onsubmit' => 'return confirm("¿Está seguro de remover este elemento?")'
            ]) !!}
                <button type="submit" class="btn btn-danger btn-sm" style="margin-right: 5px; float:left"><i class='fas fa-trash-alt'></i> Remover</button>
            {!! Form::close() !!}
        </div>


        <table class="table table-striped">
            <tr>
                <th scope="row" style="width: 220px;">Background</th>
                <td style="	font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">
                    {{ $msheet->background }} 
                    <span style="background-color:{{ $msheet->background }}; border: 1px solid black;">&nbsp;&nbsp;</span>
                </td>
            </tr>
            <tr>
                <th scope="row">Foreground</th>
                <td style="	font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">
                    {{ $msheet->foreground }}
                    <span style="background-color:{{ $msheet->foreground }}; border: 1px solid black;">&nbsp;&nbsp</span>
                </td>
            </tr>
            <tr>
                <th scope="row">Fecha de Creación</th>
                <td>{{ $msheet->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th scope="row">Fecha de Actualización</th>
                <td>{{ $msheet->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>

{{ $msheets->links() }}

<br>

<p>
    <a href="{{ route('mbooks.msections.msheets.index', [$mbook, $msection]) }}" class="btn btn-info" style="margin-right: 5px; float:left">Volver</a>
</p>

</div>

<br>

@stop