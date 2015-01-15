<?php

class FormatosPedido extends Eloquent {

	protected $table = 'formatos_pedido';
        public $timestamps=false;



	public function pedidosDetalle(){
		return $this->hasMany('PedidosDetalle', 'idFormatoPedido');
	}
        
        public static function dropDown(){
            $default      = array('0' => 'Formatos Pedido');
            $res  = FormatosPedido::lists('formato', 'id');
            return $res  = $default + $res;
        }

	

}