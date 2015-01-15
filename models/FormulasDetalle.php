<?php

class FormulasDetalle extends Eloquent {

	protected $table = 'formulas_detalle';
        public $timestamps = false;


	public function formula(){
            return $this->belongsTo('Formula', 'idFormula');
	}
        
        public function producto(){
            return $this->belongsTo('Producto', 'idProducto');
        }

	

}