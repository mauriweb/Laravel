@extends('layouts.base')

@section('content')

<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/tabbable.js') }}"></script>
    <script>
    jQuery(document).ready(function($){
        $(document).keypress(function(event){
            var key=event.key || event.which || event.keyCode;
            //var key=event.which;console.log('numero: '+key);
            
            if(key=='PageDown'){
                event.preventDefault(); 
                event.stopPropagation(); 
                $.tabNext();
                return false;
            }
        });
    });
    </script>

<style>
    
    .enlucido-fields{
        display:none;
    }
    
    
</style>
        
			        
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Baixens <small>aplicación formulación</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
                    	<li class="btn-group">
                            <a  href="{{URL::to('formulas')}}" class="btn blue">
                            	<span> Ver formulas </span>
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
                            	Añadir formulas
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
							<h4>Nueva formula</h4>
                            <form class="form-horizontal" method="post" role="form" action="{{ URL::to('add-formula') }}">
                                <input type="hidden" value="{{ $filasDeMas }}" id="filasDeMas" name="filasDeMas">
                                {{ isset( $formula->id) ? '<input type="hidden" name="id"  value="'.$formula->id.'"/>': ''  }}
                                {{ Form::token() }}
                                @if($pendiente)
                                <input type="hidden" name="pendiente" value="1">
                                @endif
                                <div class="form-group">
                                    <label class="control-label col-md-2">Sección</label>
                                    <div class="col-md-4">
               
                                        {{ Form::select('secciones', $secciones, $formula->idSeccionFormula,  array('class'=>'select2_category form-control', 'id'=>'secciones', 'tabindex'=>'1') ) }}
                                    </div>
                                </div>
								<div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">NºFormula</label>
									<div class="col-md-10">
										<p class="form-control-static">
												Correlativo automático
										</p>
									</div>
								</div>
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
                                                                            <input tabindex="2" type="text" class="form-control" name="nombre"  {{ (Input::old('nombre')) ? 'value="'.Input::old('nombre').'"' : '' }}{{ isset($formula->nombre)? 'value="'.$formula->nombre.'"': ''  }} placeholder="Insertar nombre de formula">
									</div>
								</div>
                                
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Codigo formula</label>
									<div class="col-md-10">
                                                                            <input tabindex="1" id="codigo" type="text" class="form-control"  name="codigo" {{ (Input::old('codigo')) ? 'value="'.Input::old('codigo').'"' : '' }}{{ isset($formula->codigo)? 'value="'.$formula->codigo.'"': ''  }} placeholder="Insertar codigo de formula">
									</div>
								</div>
                                
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Descripción</label>
									<div class="col-md-10">
                                                                            <textarea tabindex="3" class="form-control" name="descripcion" rows="3">{{ isset($formula->descripcion)? $formula->descripcion : ''  }} </textarea>
									</div>
								</div>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Equivalencia formula</label>
									<div class="col-md-4">
                                                                            <input tabindex="4" type="text" class="form-control" name="equivalencia-1" {{ (Input::old('equivalencia-1')) ? 'value="'.Input::old('equivalencia-1').'"' : '' }}{{ isset($equivalencias['equivalencia1'])? 'value="'.$equivalencias['equivalencia1'].'"': ''  }}  placeholder="Equivalencia">
									</div>
                                    <div class="col-md-4">
                                        <input type="text" tabindex="5" class="form-control" name="codigo-1"  {{ (Input::old('codigo-1')) ? 'value="'.Input::old('codigo-1').'"' : '' }}{{ isset($equivalencias['codigo1'])? 'value="'.$equivalencias['codigo1'].'"': ''  }}  placeholder="Código">
									</div>
                                    <div class="col-md-2">
									</div>
								</div>
                                <div class="form-group">
                                	<div class="col-md-2">
									</div>
									<div class="col-md-4">
                                                                            <input tabindex="6" type="text" class="form-control" name="equivalencia-2"  {{ (Input::old('equivalencia-2')) ? 'value="'.Input::old('equivalencia-2').'"' : '' }}{{ isset($equivalencias['equivalencia2'])? 'value="'.$equivalencias['equivalencia2'].'"': ''  }}  placeholder="Equivalencia">
									</div>
                                    <div class="col-md-4">
                                        <input tabindex="7" type="text" class="form-control" name="codigo-2"  {{ (Input::old('codigo-2')) ? 'value="'.Input::old('codigo-2').'"' : '' }}{{ isset($equivalencias['codigo2'])? 'value="'.$equivalencias['codigo2'].'"': ''  }}  placeholder="Código">
									</div>
                                    <div class="col-md-2">
									</div>
								</div>
                                <div class="form-group">
                                	<div class="col-md-2">
									</div>
									<div class="col-md-4">
                                                                            <input tabindex="8" type="text" class="form-control" name="equivalencia-3"  {{ (Input::old('equivalencia-3')) ? 'value="'.Input::old('equivalencia-3').'"' : '' }}{{ isset($equivalencias['equivalencia3']) ? 'value="'.$equivalencias['equivalencia3'].'"': ''  }}  placeholder="Equivalencia">
									</div>
                                    <div class="col-md-4">
                                        <input tabindex="9" type="text" class="form-control" name="codigo-3"  {{ (Input::old('codigo-3')) ? 'value="'.Input::old('codigo-3').'"' : '' }}{{ isset($equivalencias['codigo3'])? 'value="'.$equivalencias['codigo3'].'"': ''  }}  placeholder="Código">
									</div>
                                    <div class="col-md-2">
									</div>
								</div>
                                <div class="form-group">
                                	<div class="col-md-2">
									</div>
									<div class="col-md-4">
                                                                            <input tabindex="10" type="text" class="form-control" name="equivalencia-4"  {{ (Input::old('equivalencia-4')) ? 'value="'.Input::old('equivalencia-4').'"' : '' }}{{ isset($equivalencias['equivalencia4'])? 'value="'.$equivalencias['equivalencia4'].'"': ''  }}  placeholder="Equivalencia">
									</div>
                                    <div class="col-md-4">
                                        <input tabindex="11" type="text" class="form-control" name="codigo-4"  {{ (Input::old('codigo-4')) ? 'value="'.Input::old('codigo-4').'"' : '' }}{{ isset($equivalencias['codigo4'])? 'value="'.$equivalencias['codigo4'].'"': ''  }}  placeholder="Código">
									</div>
                                    <div class="col-md-2">
									</div>
								</div>
                                <div class="form-group">
                                	<div class="col-md-2">
									</div>
									<div class="col-md-4">
                                                                            <input tabindex="12" type="text" class="form-control" name="equivalencia-5"  {{ (Input::old('equivalencia-5')) ? 'value="'.Input::old('equivalencia-5').'"' : '' }}{{ isset($equivalencias['equivalencia5'])? 'value="'.$equivalencias['equivalencia5'].'"': ''  }}  placeholder="Equivalencia">
									</div>
                                    <div class="col-md-4">
                                        <input tabindex="13" type="text" class="form-control" name="codigo-5"  {{ (Input::old('codigo-5')) ? 'value="'.Input::old('codigo-5').'"' : '' }}{{ isset($equivalencias['codigo5'])? 'value="'.$equivalencias['codigo5'].'"': ''  }}  placeholder="Código">
									</div>
                                    <div class="col-md-2">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Densidad (g/l)</label>
									<div class="col-md-10">
                                                                            <input tabindex="14" type="text" name="densidad"  {{ (Input::old('densidad')) ? 'value="'.Input::old('densidad').'"' : '' }}{{ isset($formula->densidad)? 'value="'.$formula->densidad.'"': ''  }} class="form-control"  placeholder="Insertar densidad (g/l)">
									</div>
								</div>
                                <div class="form-group enlucido-fields enlucido-fields-act">
									<label style="color:#F00;"  class="col-md-2 control-label">Código (BASE) Máquina Grande</label>
									<div class="col-md-10">
										<input tabindex="15" type="text" class="form-control" name="codigoBaseMg"  {{ (Input::old('codigoBaseMg')) ? 'value="'.Input::old('codigoBaseMg').'"' : '' }}{{ isset($formula->codigoBaseMg)? 'value="'.$formula->codigoBaseMg.'"': ''  }}  placeholder="Código (BASE) Máquina Grande">
									</div>
								</div>
                                <div class="form-group enlucido-fields enlucido-fields-act">
									<label style="color:#F00;"  class="col-md-2 control-label">Código (BASE) Máquina Pequeña</label>
									<div class="col-md-10">
										<input tabindex="15" type="text" class="form-control" name="codigoBaseMp"  {{ (Input::old('codigoBaseMp')) ? 'value="'.Input::old('codigoBaseMp').'"' : '' }}{{ isset($formula->codigoBaseMp)? 'value="'.$formula->codigoBaseMp.'"': ''  }}  placeholder="Código (BASE) Máquina Pequeña">
									</div>
								</div>
                                
                                
                                <div class="form-group enlucido-fields enlucido-fields-act">
									<label style="color:#F00;" for="inputEmail1" class="col-md-2 control-label">Código (MA)</label>
									<div class="col-md-10">
                                                                            <input tabindex="16" type="text" class="form-control" name="codigoMa"  {{ (Input::old('codigoMa')) ? 'value="'.Input::old('codigoMa').'"' : '' }}{{ isset($formula->codigoMa)? 'value="'.$formula->codigoMa.'"': ''  }}  placeholder="Código (MA)">
									</div>
								</div>
                                <hr>
                                <p>Nota Fran: todo lo rojo es si es enlucido<br>
                                el nombre equivalencia, el código puede estar o no<br>
                                cuando seleccionas código nombre de producto sale automaticamente pero tambien tiene que tener posibilidad de seleccionar producto y el codigo aparece automaticamente</p>
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
									
									
                                                                        <th style="color:#F00;" class="enlucido-fields enlucido-fields-act">
										 Enlucido
									</th>
                                    
									<th>
										 Coste
									</th>
									<th>
										 Importe
									</th>
                                    <th>
										 Proveedor
									</th>
                                    <th>
										 VOC 
									</th>
                                    <th>
										 DENSIDAD
									</th>
                                    <th>
										 VOC indivi.
									</th>
                                                                        <th>
                                                                        </th>
                                    
								</tr>
								</thead>
								<tbody id="append">
                                                                    
                                                                    <tr id="aClonar">
									<td>
										
                                                                                {{ Form::select('det-codigo-1', $productoCode, $firstRow['producto'], array('class'=>'select2_category form-control codigo', 'tabindex'=>'17') ) }}
									</td>
                                    <td>
										 <input tabindex="18" name="det-cantidad-1" {{ (Input::old('det-cantidad-1')) ? 'value="'.Input::old('det-cantidad-1').'"' : '' }}{{ isset($firstRow['cantidad']) ? 'value="'.$firstRow['cantidad'].'"': ''  }}  type="text" class="form-control cantidad"  placeholder="Cantidad">
									</td>
                                    <td>
					
                                        {{ Form::select('det-producto-1', $productoName, $firstRow['producto'], array('class'=>'select2_category form-control producto', 'tabindex'=>'19') ) }}
									</td>
                                    
									
                                                                        <td class="enlucido-fields enlucido-fields-act">
                                        {{ Form::select('det-enlucido-1', array('MA'=>'ma', 'base'=>'Base'), $firstRow['enlucido'], array('class'=>' form-control enlucido', 'tabindex'=>'20')) }}
									</td>
									<td>
                                                                            <input tabindex="-1" name="det-coste-1" id="coste-1" {{ (Input::old('det-coste-1')) ? 'value="'.Input::old('det-coste-1').'"' : '' }}{{ isset($firstRow['coste']) ? 'value="'.$firstRow['coste'].'"': ''  }} class="form-control coste" type="text" readonly="" placeholder="Sale de base">
									</td>
                                    <td>
										<input tabindex="-1" name="det-importe-1" id="importe-1" {{ (Input::old('det-importe-1')) ? 'value="'.Input::old('det-importe-1').'"' : '' }}{{ isset($firstRow['importe']) ? 'value="'.$firstRow['importe'].'"': ''  }} class="form-control importe" type="text" readonly="" placeholder="Sale de calculo">
									</td>
                                    <td>
										
                                                                               
                                                                                <input tabindex="-1" name="det-proveedorNom-1" id="proveedorNom-1" {{ (Input::old('det-proveedorNom-1')) ? 'value="'.Input::old('det-proveedorNom-1').'"' : '' }} {{ isset($firstRow['proveedorNom']) ? 'value="'.$firstRow['proveedorNom'].'"': ''  }} class="form-control proveedorNom" type="text" readonly="" placeholder="Sale de calculo">
                                                                                       <input tabindex="-1" name="det-proveedor-1" id="proveedor-1" class="proveedor" {{ ($firstRow['proveedor']) ? 'value="'.$firstRow['proveedor'].'"' : '' }}  type="hidden" >
									</td>
                                    <td>
										<input tabindex="-1" name="det-voc-1" id="voc-1" {{ (Input::old('det-voc-1')) ? 'value="'.Input::old('det-voc-1').'"' : '' }}{{ isset($firstRow['voc']) ? 'value="'.$firstRow['voc'].'"': ''  }} class="form-control voc" type="text" readonly="" placeholder="Sale de base">
									</td>
                                    <td>
										<input tabindex="-1" name="det-densidad-1" id="densidad-1" {{ (Input::old('det-densidad-1')) ? 'value="'.Input::old('det-densidad-1').'"' : '' }}{{ isset($firstRow['densidad']) ? 'value="'.$firstRow['densidad'].'"': ''  }} class="form-control densidad" type="text" readonly="" placeholder="Sale de base">
									</td>
                                    <td>
										<input tabindex="-1" name="det-vocIndividual-1" id="vocIndividual-1" {{ (Input::old('det-vocIndividual-1')) ? 'value="'.Input::old('det-vocIndividual-1').'"' : '' }}{{ isset($firstRow['vocIndividual']) ? 'value="'.$firstRow['vocIndividual'].'"': ''  }} class="form-control vocIndividual" type="text" readonly="" placeholder="Sale de formula">
									</td>
                                                                   <td class="boton text-right" colspan="10"><button type="button" id="uno-mas" class="btn green">+</button></td>
                                    
								</tr>
                                
                                
                                
								
								</tbody>
								</table>
							</div>
						</div>
                                
                                <hr>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-10">
										<button type="submit" class="btn btn-default">Aceptar</button>
									</div>
								</div>
							</form>
                             <span id="token-ajax">{{ Form::token() }}</span>
							
							
						</div>
					</div>
					<!-- END SAMPLE FORM PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->

@stop


@section('scripts')




<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ url('assets/plugins/respond.min.js') }}"></script>
<script src="{{ url('assets/plugins/excanvas.min.js') }}"></script> 
<![endif]-->




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


<script type="text/javascript">
    var getCosteProducto="{{ URL::to('get-coste-producto') }}";
var cant=Array();
                            {{ isset($cant)? $cant : ''  }}
                            
                            {{ isset($enlucido)? $enlucido : ''  }}
                            {{ isset($producto)? $producto : ''  }}
                          
                            

          
</script>
<script src="{{ url('assets/js/aplicationShare.js') }}"></script>
<script src="{{ url('assets/js/add-formulas.js') }}"></script>
@stop