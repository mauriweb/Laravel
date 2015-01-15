<?php

class ProductoController extends BaseController {
	
	public function listProductos()
	{	
            
		$productos = Producto::all();
                //ddd($producto->proveedor()->first());exit;
		return View::make('productos/productos-list')->with(array('productos'=> $productos, 'productosSel' => Producto::dropDown(), 'productoSel'=>'' ));
                
	}
        public function post_index()
        {
            if (Input::has('producto')){
                $filtra=false;
                
                $productoSel='';
                if(Input::get('producto')!=0){
                    $productos = new Producto();
                    $productos=$productos->where('id', Input::get('producto') );
                    $productoSel=Input::get('producto');
                    $filtra=true;
                }
            }
            if($filtra){
                    $productos=$productos->get();
            }else{
                    $productos = Producto::all();
            }
            //dame(DB::getQueryLog() );
            return View::make('productos/productos-list')->with(array('productos'=> $productos, 'productosSel' => Producto::dropDown(), 'productoSel'=>$productoSel ));

        }
        
        public function verProducto($id)
	{	
		$producto = Producto::where('id', '=', $id)->first();
                $historicos=$producto->ProductosHistoricoCoste;//$this->dame($historicos, 1);
		return View::make('productos/producto-view', array('producto'=> $producto, 'historicos'=> $historicos));

                
	}
        
        public function editProductoGet($id)
	{	
		$producto = Producto::where('id', '=', $id)->first();
                $proveedores = Proveedor::lists('nombre', 'id');
		return View::make('productos/productos-edit', array('producto'=> $producto, 'proveedores'=> $proveedores));      
	}
        
        
        
        
        
        public function addProductoGet()
	{	
            $proveedores = Proveedor::lists('nombre', 'id');
            return View::make('productos/productos-add', array('proveedores'=> $proveedores )); 
	}
        
        public function delProducto($id){
            //I DONT WANNA DELETE ANY PRODUCT WHICH HAS DEPENDENCIES
            $pedidosDetalle=PedidosDetalle::where('idProducto','=',$id)->first();
            if($pedidosDetalle)return Redirect::to('productos');
            $formulasDetalle=FormulasDetalle::where('idProducto','=',$id)->first();
            if($formulasDetalle)return Redirect::to('productos');
            Producto::destroy($id);
            return Redirect::to('productos');
        }


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function addProductoPost()
	{
		$input = Input::all();
                //$this->dame($input, 1);
                $historic=true;

		$rules = array(
                    'proveedores' => 'required',
                    'nombreProducto' => 'required',
                    'nombreClave' => 'required',
                    'descripcion' => 'required',
                    'coste' => 'required',
                    
//                    'VOC' => 'required',
//                    'densidad' => 'required' 
		);
               
                if (Input::has('id')){
                      //$rules=  array_merge($rules, array('notaCambioPrecio' => 'required'));  
                      $updating=true;
                }else{
                    $updating=false;
                }
                

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
                    //$this->dame($producto, 1);
			return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
		}
		else
		{
			//$this->dame(Input::all(), 1);
                        
                        if ($updating){//UPDATING
                            $producto = Producto::find(Input::get('id'));
                            $lastPrice=$producto->coste;
                            if($lastPrice==Input::get('coste'))$historic=false;
                            
                        }else{
                            $producto = new Producto();
                            $producto->codigo = rand(11111, 99999);
                        }
			$producto->idProveedor = Input::get('proveedores');
			$producto->nombreProducto = Input::get('nombreProducto');
                        $producto->nombreClave = Input::get('nombreClave');
                        $producto->descripcion = Input::get('descripcion');
                        $producto->coste = Input::get('coste');
                        
                        $producto->VOC = Input::get('VOC');
                        $producto->densidad = Input::get('densidad');
			if($producto->save()){
                            if ($updating){
                                $idProd=Input::get('id');
                            }else{
                                $idProd=$producto->id;
                            }
                            if($historic){
                                $historico=  new ProductosHistoricoCoste();
                                $historico->idProducto=$idProd;
                                $historico->coste=Input::get('coste');
                                $historico->notas=Input::get('notaCambioPrecio');
                                $historico->save();
                            }
                            
                            return Redirect::to('productos')->with('mensaje', '<div class="alert alert-success">
                                        	<strong>Inserción con éxito!! </strong>
                                    	</div>');
                        }else{
                            return Redirect::to('productos')->with('mensaje', '<div class="alert alert-danger">
                                        	<strong>Error!! </strong> Inserción de datos incorrecta.
                                    	</div>');
                        }

			
		}
	}
        
        protected function getCostePostAjax(){
            $producto=Producto::find(Input::get( 'idProd' ));  
            $response = array(
                'status' => 'ok',
                'coste' => $producto->coste,
                'voc' => $producto->VOC,
                'densidad' => $producto->densidad,
                'proveedor'=>$producto->idProveedor,
                'proveedorNom'=>$producto->Proveedor->nombre,
                'productoName'=>$producto->nombreProducto,
                'productoCode'=>$producto->codigo
                
                
                
            );
            return Response::json( $response );
        }
	
	

}
