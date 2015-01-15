<?php

class Formula extends Eloquent {

	protected $table = 'formulas';
        public $timestamps = false;

//	public static function onProveedores($id)
//	{
//		$proveedores = Producto::find($id)->proveedores()->lists('id');
//		return $proveedores;
//	}

	
        
        public function seccionesFormula(){
            return $this->belongsTo('SeccionesFormula', 'idSeccionFormula');
            
        }
        
        public function formulasDetalle(){
            return $this->hasMany('FormulasDetalle', 'idFormula');
            
        }
        
         public function formulasEquivalencia(){
            return $this->hasMany('FormulasEquivalencia', 'idFormula');
            
        }
        
        public static function dropDown(){
            $default      = array('0' => 'Formulas');
            $res  = Formula::lists('nombre', 'id');
            return $res  = $default + $res;
        }
        
        public static function importe(){
            echo '542';
        }
        
        public static function tienePendientes(){
            $formulas=Formula::where('pendienteEdicion','>','0')->first();
            if(count($formulas))return $formulas->pendienteEdicion;
            return false;
        }
        


	

}