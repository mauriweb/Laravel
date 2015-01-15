<?php

class FormulaValoracionController extends BaseController
{
    var $viejos=array('formula'=>'0', 'fechaDe'=>'', 'fechaA'=>'');
    public function get_index(){
        $formulas=FormulasValoracion::all();
        //$viejos=array('formula'=>'0', 'fechaDe'=>'', 'fechaA'=>'');
        return View::make('formulasValoracion/formulasValoracion-list', array(

            'formulas'=>$formulas,
            
            'formulasSel'=> FormulasValoracion::dropDown(),
            'viejos'=>$this->viejos)
                );
    }
    
    public function post_index()
    {
        //dame(Input::all());
        if (Input::has('formula')){
            $formulas = new FormulasValoracion();
            $filtra=false;
            
            //$viejos=array('proveedor'=>'0', 'fechaDe'=>'', 'fechaA'=>'');
            if(Input::get('formula')!=0){
                $formulas=$formulas->where('id', Input::get('formula') );
                $filtra=true;
                $this->viejos['formula']=Input::get('formula');
            }
            if(date_validate(Input::get('fechaDe')) && date_validate(Input::get('fechaA'))){//exit;
                $formulas=$formulas->whereBetween('fecha', array( 
                    strtotime(swip_date_us_eu(Input::get('fechaDe'))), 
                    strtotime(swip_date_us_eu(Input::get('fechaA')))));
                $filtra=true;
                $this->viejos['fechaDe']=Input::get('fechaDe');
                $this->viejos['fechaA']=Input::get('fechaA');
            }
            if($filtra){
                $formulas=$formulas->get();
            }else{
                $formulas::all();
            }
            
        }else{
            $formulas = FormulasValoracion::all();
        }
        //dame(DB::getQueryLog(),1 );dame(Input::get('fechaA') );exit;
        return View::make('formulasValoracion/formulasValoracion-list', array('formulas'=> $formulas, 'formulasSel'=> FormulasValoracion::dropDown(), 'viejos'=>$this->viejos));
        
    }
    
    public function get_view($id)
    {
        $formula        = FormulasValoracion::where('id', '=', $id)->first();
        //dame($formula->SeccionesFormula->seccion, 1);
        //$formula->envio = ($pedido->envio == 'e') ? 'envio' : 'recojen';
        $formsDetalle = $formula->FormulasDetalle; //$this->dame($pedido->envio, 1);
        $formsEq=$formula->FormulasEquivalencia;
        
        return View::make('formulasValoracion/formulasValoracion-view', array(
            'formula' => $formula,
            'formsDetalle' => $formsDetalle,
            'formsEq' => $formsEq
        ));
        
        
        
    }
    
    public function get_edit($id, $action)
    {
        $formula        = FormulasValoracion::where('id', '=', $id)->first();
        $firstRow=array(
                        'cantidad'=>'', 
                        'producto'=>'',
                        'codigo'=>'',
               
                        'porcentaje'=>'',
                        'coste'=>'',

                        'importe'=>'');
        $filasDeMas=$formula->FormulasValoracionDetalle->count()-1;
        
        
        //$this->dame($validator->messages(), 1);
            $coma = $cant = $codigo = $coste =  $producto = $importe = $porcentaje = '';
            $n  = 0;
            //DVULEVE VALORES
            
            foreach ($formula->FormulasValoracionDetalle as $forDetalle) {//dame($forDetalle->Producto->idProveedor, 1);
                $n++;
                if($n==1){
                    $firstRow=array(
                        'cantidad'=>$forDetalle->cantidad, 
                        'producto'=>$forDetalle->Producto->nombreProducto,
                        'codigo'=>$forDetalle->idProducto,
                        
                        'coste'=>$forDetalle->Producto->coste, 
                        
                        'importe'=>$forDetalle->Producto->coste * $forDetalle->cantidad
                            );
    
                    
                }else{
                    $codigo .= $coma . "'" . $forDetalle->idProducto . "'";
                    $cant .= $coma . "'" . $forDetalle->cantidad . "'";
                    $coste .= $coma . "'" . $forDetalle->Producto->coste . "'";
                    
                    $producto .= $coma . "'" . $forDetalle->Producto->nombreProducto . "'";
                    $importe .= $coma . "'" . $forDetalle->Producto->coste*$forDetalle->cantidad . "'";
                    
                    
                    $coma = ', ';
                }
            }

            
  

        
            $cant         = 'cant=Array(' . $cant . ');';
            $codigo         = 'var codigo=Array(' . $codigo . ');';
            $coste = 'var coste=Array(' . $coste . ');';
            $producto      = 'var producto=Array(' . $producto . ');';
            $importe       = 'var importe=Array(' . $importe . ');';
            //$porcentaje = 'var porcentaje=Array(' . $porcentaje . ');';
           
            
            if($action=='edit'){
                $view='formulasValoracion-edit';
            }else{
                $view='formulasValoracion-view';
            }
            
            
            return View::make('formulasValoracion/'.$view)->with(array(
                
                'cant' => $cant,
                'codigo' => $codigo,
                'coste' => $coste,
                'producto' => $producto,
                'importe' => $importe,
                'porcentaje' => 'var porcentaje=false;',
                'getPorcentaje'=>"$('#calcular').click();",
                'productoCode'=> Producto::dropdown('codigo'),
                'filasDeMas' => $filasDeMas,
                'firstRow'=>$firstRow,
                'formula'=>$formula
            ));
            
            
    }
    
    
    
    
    
    public function get_new()
    {
        
        return View::make('formulasValoracion/formulasValoracion-add', array(
           
            'productoCode'=> Producto::dropdown('codigo'),
            'filasDeMas' => 0
        ));
    }
    
    
    
    
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function post_create()
    {
        
        
        $input      = Input::all();
        //dame($input,1);
        $filasDeMas = Input::get('filasDeMas');
        //dd(strtotime(Input::get('fecha')), swip_date_us_eu(Input::get('plazoEntrega')));
       

        $rules      = array(
            'observaciones' => 'required',
            'nombre' => 'required',
            'importeTotal' => 'required',
            'pesoTotal' => 'required',
            'precioXkg'=>'required',
            

            'det-codigo-1' => 'required', 
            'det-cantidad-1' => 'required',
            'det-coste-1' => 'required',
            'det-productoName-1' => 'required',
            'det-importe-1' => 'required',
            'det-porcentaje-1' => 'required'
           
        );

        for ($i = 1; $i <= $filasDeMas; $i++) {
            $n = $i + 1;
            if (trim(Input::get('det-cantidad-' . $n)) == '' || Input::get('det-codigo-' . $n)=='0') continue;
            $rules += array(
                'det-codigo-' . $n => 'required',
                'det-coste-' . $n => 'required',
                'det-productoName-' . $n => 'required',
                'det-importe-' . $n => 'required',
                'det-porcentaje-' . $n => 'required',
                'det-cantidad-' . $n => 'required'
                
            );
            
        }
        
        
        
        if (Input::has('id')) {
            $updating=true;
        } else {
            $updating=false;
        }
        
        
        $validator = Validator::make($input, $rules);
//        var_dump(Input::get('fecha'));
//        var_dump($validatorExtra);exit;
        
        if ($validator->fails()) {
            if($updating)return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
           // $this->dame($validator->messages(), 1);
            $coma = $cant = $codigo = $coste =  $producto = $importe = $porcentaje = '';
            //DVULEVE VALORES
            for ($i = 1; $i <= $filasDeMas; $i++) {
                $n = $i + 1;
                $codigo .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $cant .= $coma . "'" . Input::get('det-cantidad-' . $n) . "'";
                $coste .= $coma . "'" . Input::get('det-coste-' . $n) . "'";
                $producto .= $coma . "'" . Input::get('det-productoName-' . $n) . "'";
                $importe .= $coma . "'" . Input::get('det-importe-' . $n) . "'";
                $porcentaje .= $coma . "'" . Input::get('det-porcentaje-' . $n) . "'";
                
                $coma = ', ';
            }
            
            $cant         = 'cant=Array(' . $cant . ');';
            $codigo         = 'var codigo=Array(' . $codigo . ');';
            $coste = 'var coste=Array(' . $coste . ');';
            $producto      = 'var producto=Array(' . $producto . ');';
            $importe       = 'var importe=Array(' . $importe . ');';
            $porcentaje = 'var porcentaje=Array(' . $porcentaje . ');';
           
            
            
            
            //dd($cant);
            
            return Redirect::to('add-formula-valoracion')->withInput()->with(array(
                'mensaje' => '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ',
                'cant' => $cant,
                'codigo' => $codigo,
                'coste' => $coste,
                'producto' => $producto,
                'importe' => $importe,
                'porcentaje' => $porcentaje,

                
                'productoCode'=> Producto::dropdown('codigo'),
                'filasDeMas' => $filasDeMas
            ));
        } else {
            
            if (Input::has('id')) {
                $formula = FormulasValoracion::find(Input::get('id'));
                //$idPedido=Input::has('id');
            } else {
                $formula= new FormulasValoracion();
                $formula->fecha = time();

            }//var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $formula->nombre         = Input::get('nombre');
            $formula->observaciones   = Input::get('observaciones');
            if ($formula->save()) {
                
                if(Input::has('id')){
                    $formula->formulasValoracionDetalle()->delete();
                }

                for ($i = 0; $i <= $filasDeMas; $i++) {
                    $n                              = $i + 1;
                    if (trim(Input::get('det-cantidad-' . $n)) == '' || Input::get('det-codigo-' . $n)=='0') continue;
                    $formulasDetalle                  = new FormulasValoracionDetalle();
                    $formulasDetalle->cantidad        = Input::get('det-cantidad-' . $n);
                    $formulasDetalle->idProducto      = Input::get('det-codigo-' . $n);
                    $formulasDetalle->idFormulasValoracion      = $formula->id;
                    
                    $formulasDetalle->save();
                }
            }
            if(Input::has('printing')){
                return Redirect::to('ver-print-formula-valoracion/'.$formula->id);
                
            }
            return Redirect::to('formulas-valoracion');
        }
    }
    
    
    
    public function get_delete($id)
    {
        FormulasValoracion::destroy($id);
        return Redirect::to('formulas-valoracion');
    }
    
    public function informes_valoracion(){        
        $formulas=new stdClass();
        
        return View::make('formulas/formulas-informes', array(
            'formulasDet'=>$formulas,
            'codigo'=>'',
            'puedeEditar'=>false,
            'tienePendientes'=>Formula::tienePendientes(),
            'productoCode'=>Producto::dropDown('codigo')));
    }
    
    public function informes_valoracion_post(){
        //dame(Input::all(),1);
        $puedeEditar=false;
        if (Input::has('editar')){
            if (Input::has('codigo')){
                if(Input::get('codigo')!=0){
                    $formulasDet = new FormulasDetalle();
                    $formulasDet=$formulasDet->where('idProducto', Input::get('codigo') )->groupBy('idFormula')->get();
                                        //dame($formulasDet,1);
                    foreach($formulasDet as $formulaDet){
                        $formula=Formula::find($formulaDet->idFormula);
                        $formula->pendienteEdicion=Input::get('codigo');
                        $formula->save();
                        
                    }
                    
                }
            }
        }elseif (Input::has('anular')){
            DB::table('formulas')
            ->where('id','>', 0)
            ->update(array('pendienteEdicion' => 0));
        }

        $codigo=$input='';
        if(Input::has('procesar')){
            $input=Input::get('procesar');
        }elseif(Input::has('codigo')){
            $input=Input::get('codigo');
        }
        

            if($input){
                $formulasDet = new FormulasDetalle();
                $formulasDet=$formulasDet->where('idProducto', $input )->groupBy('idFormula');
                $codigo=$input;
                $formulasDet=$formulasDet->get();
                if($formulasDet){$puedeEditar=1;}
            }else{
                $formulasDet = new stdClass();
            }   

        $formsId=array();
        foreach ($formulasDet as $formDet){
            $formsId[]=$formDet;
        }
        Session::forget('formulas');
        if($formsId){
            Session::put('formulas', $formsId);
        }
        //if($puedeEditar)exit;
        //dame($formulasDet, 1);
        //dame(DB::getQueryLog(),1 );dame(Input::get('fechaA') );exit;
        //dame($formulaDet[0]->Producto->nombreProducto,1);
        $formDetArr=(array)$formulasDet;
        if(Input::has('printing') && count($formDetArr)>0 && $input){
            $producto=  Producto::find($input);
            $producto=$producto->nombreProducto;
            return View::make('formulas/impresiones/print-formula-informes', array('formulasDet'=>$formulasDet, 'nombreProducto'=> $producto));
        }else{
        
            return View::make('formulas/formulas-informes', array(
                'formulasDet'=>$formulasDet,
                'codigo'=>$codigo,
                'puedeEditar'=>$puedeEditar,
                'tienePendientes'=>Formula::tienePendientes(),
                'productoCode'=>Producto::dropDown('codigo')));

            }
        }
        
        
    public function print_formula_valoracion($id){
        $formula=  FormulasValoracion::find($id);
        $data=array(
            'formula'=>$formula
        );
        return View::make('formulasValoracion/print-formulasValoracion', $data);
    }
    
    public function ver_print_formula_valoracion($id){
        $formula=  FormulasValoracion::find($id);
        $data=array(
            'formula'=>$formula
        );
        FormulasValoracion::destroy($id);
        return View::make('formulasValoracion/print-formulasValoracion', $data);
    }
    
    
}
