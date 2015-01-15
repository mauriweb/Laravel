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
                            <a  href="{{URL::to('formulas-valoracion')}}" class="btn blue">
                            	<span> Ver valoraciones de formulas </span>
                            </a>
                            
                            <a id="convierteFormulaSubmit" href="#" class="btn green">
                            	<span> Convertir a Formula </span>
                            </a>
                        </li>
                       
						<li>
							<a href="index.html">
								Inicio
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Formulas
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Añadir formula
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			
			<div class="row ">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE FORM PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
                            	Valorar formula
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
                        	@if(Session::has('mensaje'))
                                    <div class="col-md-12" >{{Session::get('mensaje')}}</div>
                            @endif
                            <hr>
							<h4>Nuevo formula</h4>
                            <form action="{{URL::to('add-formula-valoracion')}}" class="form-horizontal" method="post" role="form">
                                
                                
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Fecha de creación</label>
									<div class="col-md-10">
										<p class="form-control-static">
												 Automático
										</p>
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Nombre formula</label>
									<div class="col-md-10">
                                                                            <input type="text" class="form-control" disabled=""  name="nombre" id="nombre" {{ (Input::old('nombre')) ? 'value="'.Input::old('nombre').'"' : '' }}{{ isset($formula->nombre)? 'value="'.$formula->nombre.'"': ''  }} placeholder="Insertar nombre de formula">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Obsersvaciones</label>
									<div class="col-md-10">
                                                                            <textarea class="form-control" rows="3" disabled="" name="observaciones" id="descripcion">{{ ($formula->observaciones) ? $formula->observaciones : '' }}</textarea>
									</div>
								</div>
                               
                                <hr>
                                
                                <div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
								<thead>
								<tr>
									
                                    
									<th>
										 Codigo
									</th>
									<th>
										 Cantidad
									</th>
                                    <th>
										 Producto
									</th>
									<th>
										 Coste
									</th>
									<th>
										 Importe
									</th>
                                    <th>
										 Porcentaje
									</th>
                                                                        <th></th>
                                    
								</tr>
								</thead>
                                                                <tbody id="append">
                                                                    <tr id="aClonar">
									
                                    <td>
                                                        {{ Form::select('det-codigo-1', $productoCode, $firstRow['codigo'], array('class'=>'select2_category form-control codigo', 'disabled'=>'1', 'id'=>'first-codigo') ) }}
									</td>
                                    
									<td>
										 <input disabled="" name="det-cantidad-1" {{ (Input::old('det-cantidad-1')) ? 'value="'.Input::old('det-cantidad-1').'"' : '' }}{{ isset($firstRow['cantidad']) ? 'value="'.$firstRow['cantidad'].'"': ''  }} id="first-cantidad" type="text" class="form-control cantidad" placeholder="Cantidad">
									</td>
                                    
                                    <td>
										<input disabled="" name="det-productoName-1" {{ (Input::old('det-productoName-1')) ? 'value="'.Input::old('det-productoName-1').'"' : '' }}{{ isset($firstRow['producto']) ? 'value="'.$firstRow['producto'].'"': ''  }} class="form-control productoName" type="text" readonly="" placeholder="Sale de base">
									</td>
                                    <td>
                                        <input name="det-coste-1" {{ (Input::old('det-coste-1')) ? 'value="'.Input::old('det-coste-1').'"' : '' }}{{ isset($firstRow['coste']) ? 'value="'.$firstRow['coste'].'"': ''  }} class="form-control coste" type="text" readonly="" placeholder="Sale de base">
									</td>
                                    <td>
										<input disabled="" name="det-importe-1" {{ (Input::old('det-importe-1')) ? 'value="'.Input::old('det-importe-1').'"' : '' }}{{ isset($firstRow['importe']) ? 'value="'.$firstRow['importe'].'"': ''  }} class="form-control importe" type="text" readonly="" placeholder="Sale de formula">
									</td>
                                    <td>
										<input disabled="" name="det-porcentaje-1" {{ (Input::old('det-porcentaje-1')) ? 'value="'.Input::old('det-porcentaje-1').'"' : '' }} class="form-control porcentaje" type="text" readonly="" placeholder="Sale de formula">
									</td>
                                                                        <td style="display: none;" class="boton text-right" colspan="10"><button type="button" id="uno-mas" class="btn green">+</button></td>
								</tr>
                                
                                  
								</tbody>
								</table>
							</div>
						</div>
                                
                                
                                <hr>
                                
                                
                        
                        <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Importe formula</label>
									<div class="col-md-10">
										<input disabled="" name="importeTotal" {{ (Input::old('importeTotal')) ? 'value="'.Input::old('importeTotal').'"' : '' }}  class="form-control importeTotal" type="text" readonly="" placeholder="Sale de formula">
									</div>
						</div>
                          <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Peso formula</label>
									<div class="col-md-10">
										<input name="pesoTotal" {{ (Input::old('pesoTotal')) ? 'value="'.Input::old('pesoTotal').'"' : '' }}  class="form-control pesoTotal" type="text" readonly="" placeholder="Sale de formula">
									</div>
						</div>
                          <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Precio por kg. €</label>
									<div class="col-md-10">
										<input name="precioXkg" {{ (Input::old('precioXkg')) ? 'value="'.Input::old('precioXkg').'"' : '' }}  class="form-control precioXkg" type="text" readonly="" placeholder="Sale de formula">
									</div>
						</div>
                        
                        
                        
                        <div class="form-group">
									
						</div>
                       
                       <div class="col-md-12"  style="padding:0px;">
                             <a type="submit" target="_blank" href="{{URL::to('print-formula-valoracion')}}/{{$formula->id}}" class="btn red btn-block">Imprimir</a>
                             <span id="calcular"></span>
                        </div>
                        
                        
                        
                        <div style="clear:both"></div>
                </form>
                            <span id="token-ajax">{{ Form::token() }}</span>
							
							
						</div>
					</div>
					<!-- END SAMPLE FORM PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
                        <form id="convierteFormula"  method="post" action="{{ URL::to('add-formula') }}">
                            <input type="hidden" value="{{ $filasDeMas }}" id="filasDeMas" name="filasDeMas">
                            <input type="hidden" value="1" id="filasDeMas" name="convierteFormula">
                        </form>

@stop


@section('scripts')




<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ url('assets/plugins/respond.min.js') }}"></script>
<script src="{{ url('assets/plugins/excanvas.min.js') }}"></script> 
<![endif]-->



<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ url('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->


<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="{{ url('assets/plugins/fuelux/js/spinner.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery.input-ip-address-control-1.0.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/typeahead/handlebars.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/typeahead/typeahead.min.js') }}"></script>


<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/clockface/js/clockface.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ url('assets/scripts/core/app.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-form-tools.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-pickers.js') }}"></script>
<script src="{{ url('assets/scripts/custom/form-samples.js') }}"></script>


<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {       
           // initiate layout and plugins
           App.init();
           ComponentsFormTools.init();
		   ComponentsPickers.init();
		   FormSamples.init();
        });   
    </script>
<!-- BEGIN GOOGLE RECAPTCHA -->
<script type="text/javascript">
        var RecaptchaOptions = {
           theme : 'custom',
           custom_theme_widget: 'recaptcha_widget'
        };
</script>
<!-- END JAVASCRIPTS -->


<script src="{{ url('assets/js/aplicationShare.js') }}"></script>
<script >
 var cant=Array();
                            {{ isset($cant)? $cant : ''  }}
                            {{ isset($coste)? $coste : ''  }}
                            {{ isset($codigo)? $codigo : ''  }}
                            {{ isset($producto)? $producto : ''  }}
                            {{ isset($importe)? $importe : ''  }}
                            {{ isset($porcentaje)? $porcentaje : ''  }}
                             @if(Session::has('filasDeMas'))
                                jQuery('#filasDeMas').val( {{Session::get('filasDeMas')}} );
                            @endif
                             var getCosteProducto="{{ URL::to('get-coste-producto') }}";
          
</script>
<script src="{{ url('assets/js/formulas-valoracion.js') }}"></script>

<script >
    
    $(document).ready(function(){
    {{ isset($getPorcentaje)? $getPorcentaje : ''  }}
    $('#convierteFormulaSubmit').click(function(e){
       
        var n=0;
        var $codigo=$( document.createElement('input') ).attr({name: 'det-codigo-1', type:'hidden'}).val($('#first-codigo').val());
        var $cant=$( document.createElement('input') ).attr({name: 'det-cantidad-1', type:'hidden'}).val($('#first-cantidad').val());
        var $prod=$( document.createElement('input') ).attr({name: 'det-producto-1', type:'hidden'}).val($('#first-codigo').val());
        var $descripcion=$( document.createElement('input') ).attr({name: 'descripcion', type:'hidden'}).val($('#descripcion').val());
        var $nombre=$( document.createElement('input') ).attr({name: 'nombre', type:'hidden'}).val($('#nombre').val());
        $('#convierteFormula').append($codigo).append($cant).append($prod).append($descripcion).append($nombre);
                            for(var i in cant){
                                $codigo=$( document.createElement('input') ).attr({name: 'det-codigo-'+(n+2), type:'hidden'}).val(codigo[i]);
                                $cant=$( document.createElement('input') ).attr({name: 'det-cantidad-'+(n+2), type:'hidden'}).val(cant[i]);
                                $prod=$( document.createElement('input') ).attr({name: 'det-producto-'+(n+2), type:'hidden'}).val(codigo[i]);
                                $('#convierteFormula').append($codigo).append($cant).append($prod);
				n++;
                            }                  
        e.preventDefault();
        if(confirm('Deseas Convertir esta formula?')){
            $('#convierteFormula').submit();
        }
        return false;
    });

               

//        var e = $( document.createElement('div') );  // ~300ms 500
//        var e = $('<div>');                          // ~3100ms 1130
//        var e = $('<div></div>');                    // ~3200ms 1175
//        var e = $('<div/>');                         // ~3500ms 1100
                           
                           
});
</script>
@stop