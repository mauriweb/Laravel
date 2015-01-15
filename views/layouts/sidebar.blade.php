<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				
				<li class="start ">
                                    @if($generalData['current_user']->type==1)
					<a href="{{ URL::to('/formulas') }}">
                                    @else
                                        <a href="{{ URL::to('/pedidos') }}">
                                    @endif
						<i class="fa fa-home"></i>
						<span class="title">
							Inicio
						</span>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<i class="fa fa-th"></i>
						<span class="title">
							Proveedores
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{ URL::to('/proveedores') }}">
								<i class="fa fa-eye"></i>
								Ver
							</a>
						</li>
						<li>
							<a href="{{ URL::to('/add-proveedor') }}">
								<i class="fa fa-pencil"></i>
								Insertar
							</a>
						</li>
						
					</ul>
				</li>
				
                <li>
					<a href="javascript:;">
						<i class="fa fa-th"></i>
						<span class="title">
							Productos
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{ URL::to('/productos') }}">
								<i class="fa fa-eye"></i>
								Ver
							</a>
						</li>
						<li>
							<a href="{{ URL::to('/add-producto') }}">
								<i class="fa fa-pencil"></i>
								Insertar
							</a>
						</li>
						
					</ul>
				</li>
                
                <li class="{{ isset($pedidoActive) ? $pedidoActive : '' ;}}">
					<a href="javascript:;">
						<i class="fa fa-th"></i>
						<span class="title">
							Pedidos
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{ URL::to('/pedidos') }}">
								<i class="fa fa-eye"></i>
								Ver
							</a>
						</li>
						<li>
							<a href="{{ URL::to('/add-pedido') }}">
								<i class="fa fa-pencil"></i>
								Insertar
							</a>
						</li>
						
					</ul>
				</li>
                                @if($generalData['current_user']->type==1)
				<li>
					<a href="javascript:;">
						<i class="fa fa-th"></i>
						<span class="title">
							Formulas
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{ URL::to('/formulas') }}">
								<i class="fa fa-eye"></i>
								Ver
							</a>
						</li>
						<li>
							<a href="{{ URL::to('/add-formula') }}">
								<i class="fa fa-pencil"></i>
								Insertar
							</a>
						</li>
                        <li>
							<a href="{{ URL::to('/add-formula-valoracion') }}">
								<i class="fa fa-pencil"></i>
								Valorar F.O.
							</a>
						</li>
                        <li>
							<a href="{{ URL::to('/formulas-valoracion') }}">
								<i class="fa fa-eye"></i>
								Ver valorar F.O.
							</a>
						</li>
                        <li>
							<a href="{{ URL::to('/informes-formulas-valoracion') }}">
								<i class="fa fa-pencil"></i>
								Informe pro. formula
							</a>
						</li></ul>
				</li>
                                @endif
                
				<li class="last ">
					<a href="{{ URL::to('/generales') }}">
						<i class="fa fa-th"></i>
						<span class="title">
							Acciones generales
						</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>