<?php
class FormulaController extends BaseController
{
    private $viejos = array('codigo' => '0', 'seccion' => '0', 'nombre' => '0', 'eq' => '0', 'activa' => '-1');
    public function get_index()
    {
        $formulas = Formula::all();
        return View::make('formulas/formulas-list', array(
            //'codigos'=> $formulas,
            'formulas' => $formulas,
            'secciones' => SeccionesFormula::dropDown(),
            'nombres' => Formula::dropDown(),
            'codigos' => Producto::dropDown('codigo'),
            'eqs' => FormulasEquivalencia::dropDown(),
            'viejos' => $this->viejos
        ));
    }
    public function get_catalogar($est, $id)
    {
        if ($est == 0 or $est == 1) {
            $formula         = Formula::find($id);
            $formula->activa = $est;
            $formula->save();
        }
        $formulas = Formula::all();
        return View::make('formulas/formulas-list', array(
            //'codigos'=> $formulas,
            'formulas' => $formulas,
            'secciones' => SeccionesFormula::dropDown(),
            'nombres' => Formula::dropDown(),
            'eqs' => FormulasEquivalencia::dropDown(),
            'codigos' => Producto::dropDown('codigo'),
            'viejos' => $this->viejos
        ));
    }
    public function post_index()
    {
        if (Input::has('nombre')) {
            $formulas = new Formula();
            $filtra   = $porId= $formVacia=false;
            if (Input::get('codigo') != 0) {
                $filtra                 = true;
                $this->viejos['codigo'] = Input::get('codigo');
                //                $formulasDet = new FormulasDetalle();
                //                $formulasDet=$formulasDet->where('idProducto', Input::get('codigo') )->groupBy('idFormula')->get()->lists('id');
                //                $formulas=$formulas->where('id', Input::get('nombre') );
                $formulas               = $formulas->join('formulas_detalle', 'formulas.id', '= ', 'formulas_detalle.idFormula')->where('formulas_detalle.idProducto', Input::get('codigo'));
            }
            if (Input::get('nombre') != 0) {
                $formulas               = $formulas->where('formulas.id', Input::get('nombre'));
                $filtra=$porId                 = true;
                $this->viejos['nombre'] = Input::get('nombre');
            }
            if (Input::get('seccion') != 0) {
                $formulas                = $formulas->where('idSeccionFormula', Input::get('seccion'));
                $filtra                  = true;
                $this->viejos['seccion'] = Input::get('seccion');
            }
            if (Input::get('eq') != 0) {
                
                $formulasEquivalencias = FormulasEquivalencia::find(Input::get('eq'));
                if(!$porId){
                    $formulas              = $formulas->where('formulas.id', $formulasEquivalencias->idFormula);
                }else{
                    if(Input::get('nombre') != $formulasEquivalencias->idFormula)$formVacia=true;
                }
                $filtra                = true;
                $this->viejos['eq']    = Input::get('eq');
            }
            if (Input::get('activa') != '-1') {
                $formulas               = $formulas->where('activa', Input::get('activa'));
                $filtra                 = true;
                $this->viejos['activa'] = Input::get('activa');
            }
            if ($filtra) {
                $formulas = $formulas->groupBy('formulas.id')->get();
            } else {
                $formulas=Formula::all();
            }
        } else {
            $formulas=Formula::all();
        }
        if($formVacia)$formulas=new stdClass();
        //dame(URL::to('/'),1);
        //dame(DB::getQueryLog(),1 );//dame(Input::get('fechaA') );exit;
        //dame(Input::get(),1);
        if(Input::has('excel')){
            include(public_path() . "/packages/phpExcel/Classes/PHPExcel.php");
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('a1', 'Numero Formula');
            $objPHPExcel->getActiveSheet()->getColumnDimension('a')->setAutoSize(true);
            
            $objPHPExcel->getActiveSheet()->SetCellValue('b1', 'Nombre Formula');
            $objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
            
            $objPHPExcel->getActiveSheet()->SetCellValue('c1', 'Estado');
            $objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
            $n=1;
            foreach($formulas as $formula){
                $n++;
                $objPHPExcel->getActiveSheet()->SetCellValue('a'.$n, $formula->numero);
                $objPHPExcel->getActiveSheet()->SetCellValue('b'.$n, $formula->nombre);
                $estado=$formula->activa=='1'?'En Vigor':'Descatalogada';
                $objPHPExcel->getActiveSheet()->SetCellValue('c'.$n, $estado);
            }
            
            
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(public_path() .'/files/excel.xlsx');
            header('location: '.URL::to('/').'/files/excel.xlsx');
            exit();
            
        }else{
            return View::make('formulas/formulas-list', array(
                'formulas' => $formulas,
                'secciones' => SeccionesFormula::dropDown(),
                'nombres' => Formula::dropDown(),
                'eqs' => FormulasEquivalencia::dropDown(),
                'codigos' => Producto::dropDown('codigo'),
                'viejos' => $this->viejos
            ));
        }
    }
    

    
    public function get_view($id)
    {
        $formula = Formula::where('id', '=', $id)->first();
        return View::make('formulas/formula-view', array(
            'formula' => $formula
        ));
    }
    public function get_edit($id, $accion)
    {
        $formula    = Formula::where('id', '=', $id)->first();
        $firstRow   = array(
            'cantidad' => '',
            'producto' => '',
            'codigo' => '',
            'enlucido' => 'MA',
            'vocIndividual' => '',
            'proveedor' => '',
            'proveedorNom' => '',
            'coste' => '',
            'voc' => '',
            'importe' => '',
            'densidad' => ''
        );
        $filasDeMas = $formula->FormulasDetalle->count() - 1;
        $coma       = $cant = $codigo = $coste = $enlucido = $producto = $importe = $proveedor = $proveedorNom = $voc = $densidad = $vocIndividual = '';
        $n          = 0;
        //DVULEVE VALORES
        foreach ($formula->FormulasDetalle as $forDetalle) { //dame($forDetalle->Producto->idProveedor, 1);
            $n++;
            if ($n == 1) {
                $firstRow = array(
                    'cantidad' => $forDetalle->cantidad,
                    'producto' => $forDetalle->idProducto,
                    'codigo' => $forDetalle->idProducto,
                    'enlucido' => $forDetalle->enlucido,
                    'vocIndividual' => $this->calculo_voc_individual($forDetalle->Producto->VOC, $forDetalle->cantidad, $forDetalle->Producto->densidad),
                    'proveedorNom' => $forDetalle->Producto->Proveedor->nombre,
                    'proveedor' => $forDetalle->Producto->idProveedor,
                    'coste' => $forDetalle->Producto->coste,
                    'voc' => $forDetalle->Producto->VOC,
                    'importe' => $forDetalle->Producto->coste * $forDetalle->cantidad,
                    'densidad' => $forDetalle->Producto->densidad
                );
            } else {
                $codigo .= $coma . "'" . $forDetalle->idProducto . "'";
                $cant .= $coma . "'" . $forDetalle->cantidad . "'";
                $enlucido .= $coma . "'" . $forDetalle->enlucido . "'";
                $producto .= $coma . "'" . $forDetalle->idProducto . "'";
                $coma = ', ';
            }
        }
        //$this->dame($cant, 1);
        $cant          = 'cant=Array(' . $cant . ');';
        $codigo        = 'var codigo=Array(' . $codigo . ');';
        $enlucido      = 'var enlucido=Array(' . $enlucido . ');';
        $producto      = 'var producto=Array(' . $producto . ');';
        $n             = 0;
        $equivalencias = array();
        foreach ($formula->FormulasEquivalencia as $forEq) {
            $n++;
            $equivalencias['equivalencia' . $n] = $forEq->equivalencia;
            $equivalencias['codigo' . $n]       = $forEq->codigo;
        }
        $pendiente = 0;
        if ($accion == 'pendiente')
            $pendiente = 1;
        return View::make('formulas/formulas-edit', array(
            'formula' => $formula,
            'proveedores' => Proveedor::dropDown(),
            'secciones' => SeccionesFormula::dropDown(),
            'productoName' => Producto::dropDown(),
            'productoCode' => Producto::dropDown('codigo'),
            'cant' => $cant,
            'codigo' => $codigo,
            'enlucido' => $enlucido,
            'producto' => $producto,
            'filasDeMas' => $filasDeMas,
            'firstRow' => $firstRow,
            'equivalencias' => $equivalencias,
            'pendiente' => $pendiente
        ));
    }
    public function get_new()
    {
        return View::make('formulas/formulas-add', array(
            'secciones' => SeccionesFormula::dropDown(),
            'productoCode' => Producto::dropDown('codigo'),
            'productoName' => Producto::dropDown(),
            //'proveedores' => Proveedor::dropDown(),
            'pendiente' => '0',
            'filasDeMas' => 10
        ));
    }
    protected function post_create()
    {
        if (Input::has('id')) {
            $updating=true;
        } else {
            $updating=false;
        }
        $input      = Input::all();
        //dame($input,1);
        $filasDeMas = Input::get('filasDeMas');
        $enlucido   = false;
        if (Input::get('secciones') == '1') {
            $enlucido = true;
        }
        $pendiente = 0;
        if (Input::has('pendiente')) {
            $pendiente = 1;
        }
        $rules = array(
            'secciones' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'densidad' => 'required',
            'codigo' => 'required',
            'det-codigo-1' => 'required',
            'det-cantidad-1' => 'required',
            'det-coste-1' => 'required',
            'det-producto-1' => 'required',
            'det-importe-1' => 'required',
            
            'det-voc-1' => 'required',
            'det-densidad-1' => 'required',
            'det-vocIndividual-1' => 'required'
        );
        if ($enlucido) {
            $rules += array(
                'codigoMa' => 'required',
                'det-enlucido-1' => 'required'
            );
            if (trim(Input::get('codigoBaseMg')) != ''){
                $rules += array(
                    'codigoBaseMg' => 'required',
                );
                $mBase='Mg';
            }else{
                $rules += array(
                    'codigoBaseMp' => 'required',
                );
                $mBase='Mp';
            }
            
        }
        for ($i = 1; $i <= $filasDeMas; $i++) {
            $n = $i + 1;
            if (trim(Input::get('det-cantidad-' . $n)) == '' || Input::get('det-codigo-' . $n)=='0') continue;
            $rules += array(
                'det-cantidad-' . $n => 'required',
                'det-codigo-' . $n => 'required',
                'det-coste-' . $n => 'required',
                'det-producto-' . $n => 'required',
                'det-importe-' . $n => 'required',
                'det-proveedor-' . $n => 'required',
                'det-voc-' . $n => 'required',
                'det-densidad-' . $n => 'required',
                'det-vocIndividual-' . $n => 'required'
            );
            if ($enlucido) {
                $rules += array(
                    'det-enlucido-' . $n => 'required'
                );
            }
        }
        $validator = Validator::make($input, $rules);
        //        var_dump(Input::get('fecha'));
        //        var_dump($validatorExtra);exit;
        if ($validator->fails()) {
            if($updating)return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
            //$this->dame($validator->messages(), 1);
            $coma = $cant = $codigo = $coste = $enlucido = $producto = $importe = $proveedor = $proveedorNom = $voc = $densidad = $vocIndividual = '';
            //DVULEVE VALORES
            for ($i = 1; $i <= $filasDeMas; $i++) {
                $n = $i + 1;
                $codigo .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $cant .= $coma . "'" . Input::get('det-cantidad-' . $n) . "'";
                $enlucido .= $coma . "'" . Input::get('det-enlucido-' . $n) . "'";
                $producto .= $coma . "'" . Input::get('det-producto-' . $n) . "'";
                $coma = ', ';
            }
            $cant     = 'cant=Array(' . $cant . ');';
            $codigo   = 'var codigo=Array(' . $codigo . ');';
            $enlucido = 'var enlucido=Array(' . $enlucido . ');';
            $producto = 'var producto=Array(' . $producto . ');';
            //dd($cant);
            if(Input::has('convierteFormula')){
                $mensaje='<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Estas Completando una Formula Valorada.
                                    	</div> ';
                $convierteFormula=true;
            }else{
                $mensaje='<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ';
                $convierteFormula=false;
            }
            return Redirect::to('add-formula')->withInput()->with(array(
                'mensaje' => $mensaje,
                'cant' => $cant,
                'codigo' => $codigo,
                'enlucido' => $enlucido,
                'producto' => $producto,
                'pendiente' => $pendiente,
                'convierteFormula' => $convierteFormula,
                'filasDeMas' => $filasDeMas
            ));
        } else {
            if (Input::has('id')) {
                $formula = Formula::find(Input::get('id'));
                //$idPedido=Input::has('id');
            } else {
                $formula        = new Formula();
                $formula->fecha = time();
                $lastFor        = DB::table('formulas')->select('numero')->orderBy('id', 'desc')->first();
                if (!isset($lastFor->numero)) {
                    $lastFor = 1;
                } else {
                    $lastFor = $lastFor->numero + 1;
                }
                $formula->numero = $lastFor;
                //dame($lastFor,1);
            } //var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $formula->idSeccionFormula = Input::get('secciones');
            $formula->nombre           = Input::get('nombre');
            $formula->descripcion      = Input::get('descripcion');
            $formula->densidad         = Input::get('densidad');
            $formula->codigo         = Input::get('codigo');
            $formula->pendienteEdicion = '0';
            if ($enlucido) {
                if($mBase=='Mg'){
                    $formula->codigoBaseMg =  Input::get('codigoBaseMg');
                    $formula->codigoBaseMp =  '';
                }else{
                    $formula->codigoBaseMp =  Input::get('codigoBaseMp');
                    $formula->codigoBaseMg =  '';
                }
                $formula->codigoMa   = Input::get('codigoMa');
            }
            if ($formula->save()) {
                if (Input::has('id')) {
                    $formula->formulasDetalle()->delete();
                    $formula->formulasEquivalencia()->delete();
                }
                for ($i = 1; $i < 6; $i++) {
                    if (trim(Input::get('equivalencia-' . $i)) != '' && trim(Input::get('codigo-' . $i)) != '') {
                        $equivalencia               = new FormulasEquivalencia();
                        $equivalencia->codigo       = trim(Input::get('codigo-' . $i));
                        $equivalencia->equivalencia = trim(Input::get('equivalencia-' . $i));
                        $equivalencia->idFormula    = $formula->id;
                        $equivalencia->save();
                    }
                }
                for ($i = 0; $i <= $filasDeMas; $i++) {
                    $n                           = $i + 1;
                    if (trim(Input::get('det-cantidad-' . $n)) == '' || Input::get('det-producto-' . $n)=='0') continue;
                    $formulasDetalle             = new FormulasDetalle();
                    $formulasDetalle->cantidad   = Input::get('det-cantidad-' . $n);
                    $formulasDetalle->idProducto = Input::get('det-producto-' . $n);
                    $formulasDetalle->idFormula  = $formula->id;
                    if ($enlucido) {
                        $formulasDetalle->enlucido = Input::get('det-enlucido-' . $n);
                    }
                    $formulasDetalle->save();
                }
            }
            if ($pendiente) {
                return Redirect::to('informes-formulas-valoracion')->with('procesarPendientes', true);
            } else {
                return Redirect::to('formulas');
            }
        }
    }
    public function get_delete($id)
    {
        Formula::destroy($id);
        return Redirect::to('formulas');
    }
    
    
    private function set_cantidad($formula, $cantProduccion){
            $formulasDet=array();
            $cantidad=0;
            foreach($formula->FormulasDetalle as $laFormula){
                $cantidad+=$laFormula->cantidad;
            }
            $valorPromedio=$cantProduccion/$cantidad;
            $i=0;
            foreach($formula->FormulasDetalle as $laFormula){
                $laFormula->cantidad=$laFormula->cantidad*$valorPromedio;
            }
            return $formula;
    }
    private function print_pdf(){
        include(public_path() . "/packages/MPDF57/mpdf.php");
        $mpdf = new mPDF('utf-8', array(
            297,
            210
        ));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
        $url                           = str_replace('pdf', 'print', Request::url());
        $ch                            = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        $mpdf->WriteHTML($content);
        $mpdf->Output();
        exit;
    }
    
    
    public function print_formulas()
    {
        $formulas = new Formula();
        $formulas = $formulas->where('id', '>', '0')->orderBy('idSeccionFormula', 'desc')->get();
        //dame($formulas,1);

        $data     = array(
            'formulas' => $formulas,
            'idSeccion' => '-1'
        );
        return View::make('formulas/impresiones/print-formulas', $data);
    }
    public function print_formula_valorada($id, $cantProduccion)
    {
        
        $formula = Formula::find($id);
        if($cantProduccion!=0){
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data    = array(
            'formula' => $formula
        );
        return View::make('formulas/impresiones/print-formula-valorada', $data);
    }
    public function pdf_formula_valorada($id, $cantProduccion)
    {
        $this->print_pdf();
    }
    
    public function print_formula_sin_valorar($id, $cantProduccion)
    {
        $formula = Formula::find($id);
        if($cantProduccion!=0){
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data    = array(
            'formula' => $formula
        );
        return View::make('formulas/impresiones/print-formula-no-valorada', $data);
    }
    public function pdf_formula_sin_valorar($id, $cantProduccion)
    {
        $this->print_pdf();
    }
    
    
    public function print_formula_ajustada($id, $cantProduccion)
    {
        $formula = Formula::find($id);//dame($formula->FormulasDetalle);
        if($cantProduccion!=0){
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data    = array(
            'formula' => $formula
        );
        return View::make('formulas/impresiones/print-formula-ajustada', $data);
    }
    public function pdf_formula_ajustada($id, $cantProduccion)
    {
        $this->print_pdf();
    }
    
    public function ajax_set_equivalencia_display()
    {
        $res      = DB::table('formulas_equivalencias')->where('id', Input::get('id'))->update(array(
            'display' => Input::get('val')
        ));
        $response = array(
            'status' => $res
        );
        return Response::json($response);
    }
    function filter_enlucidos($formula, $tipo){
        foreach($formula->FormulasDetalle as $key=>$val){
                if($formula->FormulasDetalle[$key]->enlucido!=$tipo)unset($formula->FormulasDetalle[$key]);
        }
        return $formula;
    }
    public function print_formula_ajustada_ma($id, $cantProduccion, $size)
    {
        $formula = Formula::find($id);
        if($cantProduccion!=0){
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $formula = $this->filter_enlucidos($formula, 'MA');
        $size=($size=='g')?'Grande':'Pequeña';
        $data    = array(
            'formula' => $formula,
            'enlucido'=>'Materia activa',
            'size'=>$size
        );
        return View::make('formulas/impresiones/print-formula-ajustada', $data);
    }
    public function print_formula_ajustada_base($id, $cantProduccion, $size)
    {
        $formula = Formula::find($id);
        if($cantProduccion!=0){
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $formula = $this->filter_enlucidos($formula, 'base');
        $size=($size=='g')?'Grande':'Pequeña';
        $data    = array(
            'formula' => $formula,
            'enlucido'=>'Base',
            'size'=>$size
        );
        return View::make('formulas/impresiones/print-formula-ajustada', $data);
    }
    
    
}
