<?php

class BaseController extends Controller {
    
        public function __construct(){
            //parent::__construct();
                $generalData=array();
                $generalData['lenguaje']='lenguage';
                $generalData['FACEBOOK_ID']='187454854';
                $generalData['ANALITYCS']='ga-18965';
                $generalData['GMAPS_KEY']='bdjsgfjsgdfsgdfgsjdfgdsfsdufvhxchfuisdyhfusduxfvkxcj';
                $generalData['EMAIL']='info@jnacher.com';
                $generalData['WEB']='jnacher.com';
                $generalData['DIRECCION']='C/ Mossen Eusebio Gimeno nª20';
                $generalData['POBLACION']='Albal';
                $generalData['CIUDAD']='Valencia';
                $generalData['CP']='46470';
                $generalData['PAIS']='ESPAÑA';
                $generalData['TELEFONO']='XXXXXXXXX';
                $generalData['LOPD']='XXXXXXXXXXXX';
                $generalData['CIF']='XXXXXXXXXXXX';
                $generalData['nombreCOMERCIAL']='JNACHER estudio, diseño gráfico & web';
                $generalData['current_user']=Auth::user();
                View::share('generalData', $generalData);

        }
        
        protected function dame($data, $ex=0){
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            if($ex)exit;
        }
  

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
        
        /**
        * Creates a view
        *
        * @param String $path path to the view file
        * @param Array $data all the data
        * @return void
        */
        protected function view($path, array $data = [])
        {
        $this->layout->content = View::make($path, $data);
        }

        /**
        * Redirect back with input and with provided data
        *
        * @param Array $data all the data
        * @return void
        */
        protected function redirectBack($data = [])
        {
        return Redirect::back()->withInput()->with($data);
        }

        /**
        * Redirect to the previous url
        *
        * @return void
        */
        public function redirectReferer()
        {
        $referer = Request::server('HTTP_REFERER');
        return Redirect::to($referer);
        }

        /**
        * Redirect to a given route, with optional data
        *
        * @param String $route route name
        * @param Array $data optional data
        * @return void
        */
        protected function redirectRoute($route, $data = [])
        {
        return Redirect::route($route, $data);
        }
        
        protected function get_variables_generales(){
            $nuevoHorario = Option::where('meta_key','=','nuevoHorario')->first();
            //dame($nuevoHorario, 1);
            $seccionesFormula=  SeccionesFormula::all();
            $formatosPedido=  FormatosPedido::all();
            $users=  User::all();
            
            //$usuarios=User
            return array(
                        'nuevoHorario'=>$nuevoHorario->meta_value,
                        'secciones'=>$seccionesFormula,
                        'formatos'=>$formatosPedido,
                        'users'=>$users
            );
        }
        
        protected function calculo_voc_individual($vocPord, $cantidad, $densidad){
            return $vocPord*(1000*$cantidad/$densidad);
        }
        
        protected function calcularPorcentaje($cantidad, $totCant){
            $porcentaje=$cantidad / $totCant * 100;
            return number_format($porcentaje, 2);
        }
 



}
