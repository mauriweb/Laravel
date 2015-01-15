<?php

class GeneralController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
    

    public function get_index(){
            //$variables_generales=get_variables_generales();
            return View::make('generales', $this->get_variables_generales()+array('scroll'=>""));
    }
    
    public function post_edit(){
            //$variables_generales=get_variables_generales();
        if(Input::has('nuevoHorario')){
            if(!$option=  Option::where('meta_key','=','nuevoHorario')->first()){
                $option=new Option();
            }
            $option->meta_value=Input::get('nuevoHorario');
            $option->save();

        }
        return View::make('generales', $this->get_variables_generales());
    }

}
