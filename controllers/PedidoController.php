<?php

class PedidoController extends BaseController
{
    
    var $viejos=array('proveedor'=>'0', 'fechaDe'=>'', 'fechaA'=>'', 'estadoPedidos'=>'0');
    
    public function get_index(){       
        $pedidos=Pedido::orderBy('id', 'desc')->get();
        //dame($pedidos);
        

        return View::make('pedidos/pedidos-list', array('pedidos'=> $pedidos, 'proveedores'=> Proveedor::dropDown() , 'viejos'=>$this->viejos, 'pedidoActive'=>'start active'));
    }
    
    public function post_index()
    {
        
        if (Input::has('proveedores')){
            $pedidos = new Pedido();
            $filtra=false;
            if(Input::get('proveedores')!='0'){
                $pedidos=$pedidos->where('idProveedor', Input::get('proveedores') );
                $filtra=true;
                $this->viejos['proveedor']=Input::get('proveedores');
            }
            
            if(Input::get('estadoPedidos')!='0'){//echo Input::get('estadoPedidos');exit;
                $pedidos=$pedidos->where('estadoPedido', Input::get('estadoPedidos') );
                $filtra=true;
                $this->viejos['estadoPedidos']=Input::get('estadoPedidos');
            }
            if(date_validate(Input::get('fechaDe')) && date_validate(Input::get('fechaA'))){//exit;
                $pedidos=$pedidos->whereBetween('fecha', array( 
                    strtotime(swip_date_us_eu(Input::get('fechaDe'))), 
                    strtotime(swip_date_us_eu(Input::get('fechaA')))));
                
                $filtra=true;
                $this->viejos['fechaDe']=Input::get('fechaDe');
                $this->viejos['fechaA']=Input::get('fechaA');
            }
            if($filtra){
                $pedidos=$pedidos->get();
            }else{
                $pedidos = Pedido::all();
            }
            
        }else{
            $pedidos = Pedido::all();
        }
        //dame($pedidos);
        //dame(DB::getQueryLog(),1 );dame(Input::get('fechaA') );//exit;
        return View::make('pedidos/pedidos-list', array('pedidos'=> $pedidos, 'proveedores'=> Proveedor::dropDown(), 'viejos'=>$this->viejos, 'pedidoActive'=>'start active'));
        
    }
    
    public function get_view($id)
    { 
        $pedido        = Pedido::where('id', '=', $id)->first();
                
        //dame($pedido->relationsToArray(), 1);
        $pedido->envio = ($pedido->envio == 'e') ? 'envio' : 'recojen';
        $pedidoDetalle = $pedido->PedidosDetalle; //$this->dame($pedido->envio, 1);
        
        return View::make('pedidos/pedido-view', array(
            'pedido' => $pedido,
            'pedidoDetalle' => $pedidoDetalle,
            'pedidoActive'=>'start active'
        ));
        
        
        
    }
    
    public function get_edit($id)
    {
        $pedido        = Pedido::where('id', '=', $id)->first();
        
        $filasDeMas=$pedido->PedidosDetalle->count()-1;
        
        
        //$this->dame($validator->messages(), 1);
            $coma = $cant = $productoCode = $productoNameR = $formato = $precio = '';
            $n  = 0;
            //DVULEVE VALORES
            $firstRow=array(
                        'cantidad'=>'', 
                        'productoName'=>'', 
                        'formatos'=>'', 
                        'precio'=>'', );
            foreach ($pedido->PedidosDetalle as $pedDetalle) {//$this->dame($pedDetalle->cantidad, 1);
                $n++;
                
                if($n==1){
                    $firstRow=array(
                        'cantidad'=>$pedDetalle->cantidad, 
                        'productoName'=>$pedDetalle->idProducto, 
                        'formatos'=>$pedDetalle->idFormatoPedido, 
                        'precio'=>$pedDetalle->Producto->coste);
                    
                }else{
                    
                    $cant .= $coma . "'" . $pedDetalle->cantidad . "'";
                    $productoNameR .= $coma . "'" . $pedDetalle->idProducto . "'";
                    $formato .= $coma . "'" . $pedDetalle->idFormatoPedido . "'";
                    $precio .= $coma . "'" . $pedDetalle->Producto->coste . "'";
                    $coma = ', ';
                }
            }
            //$this->dame($cant, 1);
            $cant         = 'cant=Array(' . $cant . ');';
            $productoNameR = 'var productoName=Array(' . $productoNameR . ');';
            $formato      = 'var formato=Array(' . $formato . ');';
            $precio       = 'var precio=Array(' . $precio . ');';
            
           
        //$this->dame(FormatosPedido::dropDown(), 1);
        return View::make('pedidos/pedidos-edit', array(
            
            'pedido'=>$pedido,
            
            'proveedores' => Proveedor::dropDown(),
            'formatos' => FormatosPedido::dropDown(),
            'productoName' => Producto::dropDown(),
            'productoCode' => Producto::dropDown('codigo'),
            
            'cant' => $cant,
            'formato' => $formato,
            'productoNameR' => $productoNameR,
            'precio' => $precio,
            
            'filasDeMas' => $filasDeMas,
            'firstRow'=>$firstRow,
            'pedidoActive'=>'start active'
                
        ));
    }
    
    
    
    
    
    public function get_new()
    {
        
        
        return View::make('pedidos/pedidos-add', array(
            'proveedores' => Proveedor::dropDown(),
            'formatos' => FormatosPedido::dropDown(),
            'productoName' => Producto::dropDown(),
            'productoCode' => Producto::dropDown('codigo'),
            'filasDeMas' => 0,
            'pedidoActive'=>'start active'
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
                
        $filasDeMas = Input::get('filasDeMas');
        //dd(strtotime(Input::get('fecha')), swip_date_us_eu(Input::get('plazoEntrega')));
        $rules      = array(
            'proveedores' => 'required',
            //'observaciones' => 'required',
            'recibidoPor' => 'required',
            'envio' => 'required',
            'det-cantidad-1' => 'required',
            'det-precio-1' => 'required',
            'det-productoCode-1' => 'required',
            'det-productoName-1' => 'required',
            'det-formatos-1' => 'required'
        );
        for ($i = 1; $i <= $filasDeMas; $i++) {
            $n = $i + 1;
            $rules += array(
                'det-cantidad-' . $n => 'required',
                'det-precio-' . $n => 'required',
                'det-productoCode-' . $n => 'required',
                'det-productoName-' . $n => 'required',
                'det-formatos-' . $n => 'required'
            );
        }
        
        
        if (Input::has('id')) {
            $updating=true;
        } else {
            $updating=false;
        }
        $validatorExtra = (date_validate(Input::get('fecha')) && date_validate(Input::get('plazoEntrega')));
        
        $validator = Validator::make($input, $rules);
//        var_dump(Input::get('fecha'));
//        var_dump($validatorExtra);exit;
        
        if ($validator->fails() || !$validatorExtra) {
            if($updating)return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
            //$this->dame($validator->messages(), 1);
            $coma = $cant = $productoCode = $productoName = $formato = $precio = '';
            $pos  = 0;
            //DVULEVE VALORES
            for ($i = 1; $i <= $filasDeMas; $i++) {
                $n = $i + 1;
                $cant .= $coma . "'" . Input::get('det-cantidad-' . $n) . "'";
                $productoCode .= $coma . "'" . Input::get('det-productoCode-' . $n) . "'";
                $productoName .= $coma . "'" . Input::get('det-productoName-' . $n) . "'";
                $formato .= $coma . "'" . Input::get('det-formatos-' . $n) . "'";
                $precio .= $coma . "'" . Input::get('det-precio-' . $n) . "'";
                $coma = ', ';
            }
            
            $cant         = 'cant=Array(' . $cant . ');';
            $productoCode = 'var productoCode=Array(' . $productoCode . ');';
            $productoName = 'var productoName=Array(' . $productoName . ');';
            $formato      = 'var formato=Array(' . $formato . ');';
            $precio       = 'var precio=Array(' . $precio . ');';
            
            
            
            //dd($cant);
            
            return Redirect::to('add-pedido')->withInput()->with(array(
                'mensaje' => '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ',
                'cant' => $cant,
                'productoName' => $productoName,
                'productoCode' => $productoCode,
                'formato' => $formato,
                'precio' => $precio,
                'filasDeMas' => $filasDeMas,
                'pedidoActive'=>'start active'
            ));
        } else {
            
            if ($updating) {
                $pedido = Pedido::find(Input::get('id'));
                //$idPedido=Input::has('id');
            } else {
                $pedido                  = new Pedido();
                $pedido->idSolicitadoPor = Auth::id();
                $lastPedido = DB::table('pedidos')->select('numero')->orderBy('id', 'desc')->first();
                if(!isset($lastPedido->numero)){
                    $lastPedido=1;
                }else{
                    $lastPedido=$lastPedido->numero;
                }
                $pedido->numero          = $lastPedido++;
            }//var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $pedido->fecha         = strtotime(swip_date_us_eu(Input::get('fecha')));
            $pedido->envio         = Input::get('envio');
            $pedido->recibidoPor   = Input::get('recibidoPor');
            $pedido->plazoEntrega  = strtotime(Input::get('plazoEntrega'));
            $pedido->observaciones = Input::get('observaciones');
            $pedido->idProveedor   = Input::get('proveedores');
            if ($pedido->save()) {
                if($updating){
                    $pedido->pedidosDetalle()->delete();
                }
                for ($i = 0; $i <= $filasDeMas; $i++) {
                    $n                              = $i + 1;
                    $pedidoDetalle                  = new PedidosDetalle();
                    $pedidoDetalle->cantidad        = Input::get('det-cantidad-' . $n);
                    $pedidoDetalle->idProducto      = Input::get('det-productoCode-' . $n);
                    $pedidoDetalle->idFormatoPedido = Input::get('det-formatos-' . $n);
                    $pedidoDetalle->idPedido        = $pedido->id;
                    $pedidoDetalle->save();
                }
            }
            return Redirect::to('pedidos')->with(array('pedidoActive'=>'start active'));
        }
    }
    
    
    
    public function get_delete($id)
    {
        
        Pedido::destroy($id);
        return Redirect::to('pedidos')->with(array('pedidoActive'=>'start active'));
    }
    
    public function print_pedido($id){
        
        $pedido=Pedido::find($id);
        //dame($pedido->pedidoDetalle,1);
        $data=array(
            'pedido'=>$pedido,
            'horarioDescarga'=>Option::where('meta_key','=','nuevoHorario')->first(),
            'pedidoActive'=>'start active'
        );
        return View::make('pedidos/pedido-print', $data);
    }
    
    public function pdf_pedido($id){ 
        include(public_path()."/packages/MPDF57/mpdf.php");
		$mpdf=new mPDF('utf-8', array(210,297));
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
                $url=  str_replace('pdf', 'print', Request::url()); 
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                $content = curl_exec($ch);
                curl_close($ch);
		$mpdf->WriteHTML($content);
		$mpdf->Output();
		exit;
    }
    
    public function ajax_set_estado_pedido(){
        if(Input::has('idPedido')){
            $estado=Input::get('recibido')=='r'?'rec':'pend';
            $pedido=Pedido::find(Input::get('idPedido'));
            
            $res      = DB::table('pedidos')->where('id', Input::get('idPedido'))->update(array(
            'estadoPedido' => $estado
            ));
            $response = array(
                'status' => $res
            );
            return Response::json($response);
        }
    }
    
    
    
}
