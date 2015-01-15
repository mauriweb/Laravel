<?php

class UserController extends BaseController {
    
        protected $scroll="document.getElementById('usuarios').scrollIntoView();";
        public function get_edit($id)
	{	
		$usuario = User::where('id', '=', $id)->first();
                //dame($usuarios,1);

                $data=array('user'=> $usuario)+$this->get_variables_generales()+array('scroll'=>$this->scroll);
          
		return View::make('generales', $data);      
	}
        
        
        
        
        
        
        
        public function get_delete($id){
            User::destroy($id);
            return Redirect::to('generales')->with('mensajeUsuarios', 'Registro Eliminado')->with('scroll', $this->scroll);
        }


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function post_create()
	{
		$input = Input::all();
                //$this->dame($input, 1);
                $updating=false;
                $rules =array();
                if (!Input::has('idUser')){//UPDATING
                    $rules = array(
                        'password' => 'required|unique:users,username'
                    );
                }else{
                    $updating=true;
                }

		$rules = $rules + array(
                    'username' => 'required',   
                    'nombre' => 'required'
		);
		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::back()->withInput()->with('mensajeUsuarios', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>')->with('scroll', $this->scroll);
		}
		else
		{
			//$this->dame(Input::all(), 1);
                        
                        if ($updating){//UPDATING
                            $user = User::find(Input::get('idUser'));  
                        }else{
                            $user = new User();
                        }
			$user->nombre = Input::get('nombre');
                        $user->username = Input::get('username');
                        if(trim(Input::get('password'))!='')
                            $user->password = Hash::make(Input::get('password'));
                        if(Input::hasFile('image')){
                            if(Input::file('image')->isValid()){
                                $destinationPath = '../public/img';
                                if ($updating && $user->img){
                                    @unlink($destinationPath.'/'.$user->img);
                                }
                                $file = Input::file('image');
                                $extension = $file->getClientOriginalExtension();
                                $filename = 'img_users_'.rand(111111111, 999999999).'.'.$extension;
                                Input::file('image')->move($destinationPath, $filename);
                                $user->img = $filename;
                            }
                        }

			if($user->save()){
                            return Redirect::to('generales')->with('mensajeUsuarios', '<div class="alert alert-success">
                                        	<strong>Inserción con éxito!! </strong>
                                    	</div>')->with('scroll', $this->scroll);
                        }else{
                            return Redirect::to('generales')->with('mensajeUsuarios', '<div class="alert alert-danger">
                                        	<strong>Error!! </strong> Inserción de datos incorrecta.
                                    	</div>')->with('scroll', $this->scroll);
                        }

			
		}
	}
        
        
        
        
        
        
        
        
        
        
        
        
    
    
    
    

	public function dashboard()
	{
		return View::make('users.dashboard');
	}

	public function get_login()
	{
		if(User::isLogged()){
                    //Session::flush();
                    return Redirect::to('/proveedores');
                }
		else{
                    return View::make('login');
                    
                }
	}

	public function post_login(){
		$input = Input::all();
                //$this->dame($input);
                
                

		$rules = array(
			'username' => 'required|exists:users,username',
			'password' => 'required',
		);

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::back()->with('incorrecto', 'Incorrecto, comprueba los datos');
		}
		else
		{
			$username = Input::get('username');
			$password = Input::get('password');

			if($user = User::where('username', '=', $username)->first())
			{
				if(Hash::check($password, $user->password))
				{
                                    Auth::login($user, true);
//					Session::put('user_id', $user->id);
//					Session::put('user_username', $user->username);
//					Session::put('user_type', $user->type);
					return Redirect::to('/proveedores');
				}
				else
				{
					return Redirect::to('/login')->with('incorrecto', 'Incorrecto, comprueba los datos');
				}
			}
			else
			{
				return Redirect::to('/login')->with('incorrecto', 'Incorrecto, comprueba los datos');
			}

		}
	}

	

	public function get_signup()
	{
		if(User::isLogged())
		{
			return Redirect::to('/dashboard');
		}
		else
		{
			return View::make('users.signup');
		}
	}

	public function post_signup()
	{
		$input = Input::all();

		$rules = array(
			'username' => 'required|unique:users,username',
			'email' => 'required|email|unique:users,email',
			'password' => 'required',
			'password2' => 'required|same:password',
		);

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}
		else
		{
			$user = new User;
				$user->username = Input::get('username');
				$user->password = Hash::make(Input::get('password'));
				$user->email = Input::get('email');
				$user->comments = 0;
				$user->type = 1;
			$user->save();

			return Redirect::to('/login')->with('registro', 'Registro completado. Accede a su cuenta');
		}
	}
        
        public function  salir_aplicacion(){            //dame(Auth::guest(),1);
            Auth::logout();
            return Redirect::to('/login');
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
}