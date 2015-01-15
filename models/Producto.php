<?php

class Producto extends Eloquent {

	protected $table = 'productos';



	public function proveedor(){
		return $this->belongsTo('Proveedor', 'idProveedor');
	}
        
        public function pedidosDetalle(){
		return $this->hasMany('PedidosDetalle', 'idProducto');
	}
        
        public function formulasDetalle(){
		return $this->hasMany('FormulasDetalle', 'idProducto');
	}
        
        public function productosHistoricoCoste(){
		return $this->hasMany('ProductosHistoricoCoste', 'idProducto');
	}
        
        // this is a recommended way to declare event handlers
        protected static function boot() {
            parent::boot();

            static::deleting(function($producto) { // before delete() method call this
                 $producto->ProductosHistoricoCoste()->delete();
                 // do the rest of the cleanup...
            });
        }
        public static function dropDown($key='nombreProducto'){
            $default      = array('0' => 'Productos');
            $res  = Producto::lists($key, 'id');
            return $res  = $default + $res;
        }

	

}