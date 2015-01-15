@extends('layouts.base')

@section('content')
		

        
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Baixens <small>aplicación formulación</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li class="btn-group">
                            <a  href="{{URL::to('add-producto')}}" class="btn blue">
                            	<span> Añadir productos </span>
                            </a>
                        </li>
						<li>
							<a href="inicio.html">
								Inicio
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							
								Productos
                                
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Ver productos
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								PRODUCTOS
							</div>
						</div>
						<div class="portlet-body">
                       		@if(Session::has('mensaje'))
                                    <div class="col-md-12">{{Session::get('mensaje')}}</div>
                            @endif
                            <hr>
                            <form class="form-horizontal col-md-12" method="post" action="{{URL::to('productos')}}" role="form" style="padding:0px; margin-bottom:20px;">
                            	{{Form::token()}}
                                    <div class="col-md-4" style="padding:0px;">
                                        {{ Form::select('producto', $productosSel, $productoSel,  array('class'=>'select2_category form-control', 'data-placeholder'=>'Producto', 'tabindex'=>'1' )) }}
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn red btn-block">Filtrar</button><br>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    
                            </form>
                               
							<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
							<thead>
							<tr>
								<th>
									 Proveedor
								</th>
								<th>
									 Código
								</th>
								<th>
									 Nombre producto
								</th>
                                <th>
									 Nombre clave
								</th>
                                <th>
									 Coste
								</th>
                                <th class="hidden-xs">
									 Ver
								</th>
								<th class="hidden-xs">
									 Editar
								</th>
								<th class="hidden-xs">
									 Borrar
								</th>
							</tr>
							</thead>
							<tbody>
                                                            @foreach($productos as $producto)
							<tr>
								<td>
									 {{ $producto->proveedor()->first()->nombre }}
								</td>
								<td>
									 {{ $producto->codigo }}
								</td>
								<td>
									 {{ $producto->nombreProducto }}
								</td>
                                <td>
									 {{ $producto->nombreClave }}
								</td>
                                <td>
									 {{ $producto->coste }}
								</td>
                                <td>
									 <a class="btn btn-success btn-xs fullButton" href="ver-producto/{{ $producto->id }}">Ver</a>
								</td>
								<td>
									 <a href="edit-producto/{{ $producto->id }}" class="btn btn-info btn-xs fullButton">Editar</a>
								</td>
                                <td>
                                    <a  onclick="return confirm('deseas borar este registro?')" href="del-producto/{{ $producto->id }}" class="btn btn-danger btn-xs fullButton">Borrar</a>
								</td>
							</tr>
                                                        @endforeach
							
							</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->

@stop

@section('scripts')
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ url('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ url('assets/plugins/select2/select2.min.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ url('assets/scripts/core/app.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-form-tools.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-pickers.js') }}"></script>
<script src="{{ url('assets/scripts/custom/form-samples.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   // initiate layout and plugins
   App.init();
   FormSamples.init();
});
</script>
@stop