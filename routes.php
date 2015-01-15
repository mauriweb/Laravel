<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(array('before' => 'guest'), function(){
    Route::get('/', 'UserController@get_login');
    Route::post('/', 'UserController@post_login');

    Route::get('/login', 'UserController@get_login');
    Route::post('/login', 'UserController@post_login');
});


Route::get('/print-pedido/{id}', 'PedidoController@print_pedido');
Route::get('/print-formula-ajustada/{id}/{cant}', 'FormulaController@print_formula_ajustada');
Route::get('/print-formula-valorada/{id}/{cant}', 'FormulaController@print_formula_valorada');
Route::get('/print-formula-sin-valorar/{id}/{cant}', 'FormulaController@print_formula_sin_valorar');
Route::get('/print-formula-ajustada-base/{id}/{cant}/{size}', 'FormulaController@print_formula_ajustada_base');
Route::get('/print-formula-ajustada-ma/{id}/{cant}/{size}', 'FormulaController@print_formula_ajustada_ma');


Route::group(array('before' => 'auth'), function(){

                Route::get('/logout', 'UserController@salir_aplicacion');
                
//                Route::get('logout', array('as' => 'logout', function () {
//                    Auth::logout();
//                    return Redirect::route('login');
//                }));
                
                //GENERALES          
		Route::get('/generales', 'GeneralController@get_index');

                //PROVEEDORES          
		Route::get('/proveedores', 'ProveedorController@listProveedores');
		Route::get('/del-proveedor/{id}', 'ProveedorController@delProveedor');
                Route::get('/edit-proveedor/{id}', 'ProveedorController@editProveedorGet');
		Route::get('/ver-proveedor/{id}', 'ProveedorController@verProveedor');
                Route::get('/add-proveedor', 'ProveedorController@addProveedorGet');
                
                //PRODUCTOS
                Route::get('/productos', 'ProductoController@listProductos');
		Route::get('/del-producto/{id}', 'ProductoController@delProducto');
                Route::get('/edit-producto/{id}', 'ProductoController@editProductoGet');
		Route::get('/ver-producto/{id}', 'ProductoController@verProducto');
                Route::get('/add-producto', 'ProductoController@addProductoGet');
                
                
                
                //PEDIDOS
                Route::get('/pedidos', 'PedidoController@get_index');
		Route::get('/del-pedido/{id}', 'PedidoController@get_delete');
                Route::get('/edit-pedido/{id}', 'PedidoController@get_edit');
		Route::get('/ver-pedido/{id}', 'PedidoController@get_view');
                Route::get('/add-pedido', 'PedidoController@get_new');
                
                
                
                Route::get('/pdf-pedido/{id}', 'PedidoController@pdf_pedido');
                Route::get('/email-pedido/{id}', 'PedidoController@email_pedido');
                
                
                //FORMULAS
                Route::group(array('before' => 'admin'), function(){
                    Route::get('/formulas', 'FormulaController@get_index');
                    Route::get('/borrar-formula/{id}', 'FormulaController@get_delete');
                    Route::get('/edit-formula/{id}/{accion}', 'FormulaController@get_edit');
                    Route::get('/ver-formula/{id}', 'FormulaController@get_view');
                    Route::get('/add-formula', 'FormulaController@get_new');
                    Route::get('/catalogar-formula/{est}/{id}', 'FormulaController@get_catalogar');
                    Route::get('/print-formulas', 'FormulaController@print_formulas');
                    Route::get('/excel-formulas', 'FormulaController@excel_formulas');


                    Route::get('/pdf-formula-ajustada/{id}/{cant}', 'FormulaController@pdf_formula_ajustada');
                    Route::get('/pdf-formula-valorada/{id}/{cant}', 'FormulaController@pdf_formula_valorada');
                    Route::get('/pdf-formula-sin-valorar/{id}/{cant}', 'FormulaController@pdf_formula_sin_valorar');
                });
                
                
                //FORMULASVALORACION
                Route::get('/formulas-valoracion', 'FormulaValoracionController@get_index');
		Route::get('/borrar-formula-valoracion/{id}', 'FormulaValoracionController@get_delete');
                Route::get('/edit-formula-valoracion/{id}/{acction}', 'FormulaValoracionController@get_edit');
		Route::get('/ver-formula-valoracion/{id}/{acction}', 'FormulaValoracionController@get_edit');
                Route::get('/add-formula-valoracion', 'FormulaValoracionController@get_new');
                Route::get('/informes-formulas-valoracion', 'FormulaValoracionController@informes_valoracion');
                Route::get('/print-formula-valoracion/{id}', 'FormulaValoracionController@print_formula_valoracion');
                Route::get('/ver-print-formula-valoracion/{id}', 'FormulaValoracionController@ver_print_formula_valoracion');
                
                //SECCIONESFORMULAS
		Route::get('/borrar-seccion-formula/{id}', 'SeccionesFormulaController@get_delete');
                Route::get('/edit-seccion-formula/{id}', 'SeccionesFormulaController@get_edit');
                
                //FORMATOSPEDIDO
		Route::get('/borrar-formato-pedido/{id}', 'FormatosPedidoController@get_delete');
                Route::get('/edit-formato-pedido/{id}', 'FormatosPedidoController@get_edit');
                
                //USUARIOS
		Route::get('/borrar-usuario/{id}', 'UserController@get_delete');
                Route::get('/edit-usuario/{id}', 'UserController@get_edit');
                
               
                

		
                
                
               // Route::group(array('before'=>'csrf'), function(){

                    //GENERALES          
                    Route::post('/generales', 'GeneralController@post_edit');
                    
                    //PROVEEDORES  
                    Route::post('/add-proveedores', 'ProveedorController@addProveedorPost');

                    //PRODUCTOS
                    Route::post('/add-productos', 'ProductoController@addProductoPost');
                    Route::Post('/productos', 'ProductoController@post_index');
                    //AJAX
                    Route::post('/get-coste-producto', 'ProductoController@getCostePostAjax');
                    
                   
                    //PEDIDOS
                    Route::post('/add-pedido', 'PedidoController@post_create');
                    Route::Post('/pedidos', 'PedidoController@post_index');
                    //AJAX
                    Route::post('/set-estado-pedido', 'PedidoController@ajax_set_estado_pedido');
                    
                    //FORMULAS
                    Route::post('/add-formula', 'FormulaController@post_create');
                    Route::Post('/formulas', 'FormulaController@post_index');
                    //AJAX
                    Route::post('/equivalencia-display', 'FormulaController@ajax_set_equivalencia_display');
                    
                    //FORMULAS VALORACION
                    Route::post('/add-formula-valoracion', 'FormulaValoracionController@post_create');
                    Route::Post('/formulas-valoracion', 'FormulaValoracionController@post_index');
                    Route::Post('/informes-formulas-valoracion', 'FormulaValoracionController@informes_valoracion_post');
                    
                    //SECCIONES FORMULA  
                    Route::post('/add-seccion-formula', 'SeccionesFormulaController@post_create');
                    
                    //FORMATOS PEDIDO
                    Route::post('/add-formato-pedido', 'FormatosPedidoController@post_create');
                    
                    //USUARIOS
                    Route::post('/add-usuario', 'UserController@post_create');
                    

                //});
});


//        View::composer('generales', function($view)
//        {
//            $view->with('count', '11');
//        });

