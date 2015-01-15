<?php

class SeccionesFormula extends Eloquent {

	protected $table = 'secciones_formulas';
        public $timestamps=false;


	public function formula(){
		return $this->hasMany('Formula', 'idSeccionFormula');
	}
        
        public static function dropDown(){
            $default      = array('0' => 'Secciones Formula');
            $res  = SeccionesFormula::lists('seccion', 'id');
            return $res  = $default + $res;
        }

	

}