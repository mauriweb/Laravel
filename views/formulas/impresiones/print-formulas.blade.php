<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento de compra</title>
<style type="text/css">

				body{
					font-family:Verdana, Geneva, sans-serif;
					font-size:11px;
					font-weight:bold;
				}
				.table{
					border-top: 1px solid #000;
					border-bottom: 1px solid #000;
					border-spacing:0;
					border-collapse: collapse;
					position:relative;
				}
				
				.text_left{
					text-align:left;	
				}
				
				.min{
					width:30%;	
				}
				
				
				.minimo_titulo{
					width:15%;	
					font-size:12px;
					font-weight:lighter;
					text-align:right;
				}
				.minimo_text{
					width:15%;	
					font-size:13px;
					font-weight:bold;
					padding-left:10px;
					
				}
				
				.left{
					float:left;
					position:relative;	
				}
				
				.right{
					float:right;
					position:relative;
				}
				h1{
					font-size:16px;	
				}
				.margin_top{
					margin-top:10px;
				}
				.padding_top{
					height:40px;
				}
				
				.table_gran tr td{
					border: thin solid #000;
					border-collapse: collapse;
					padding:5px;
				}
				.table_gran tr td.peq{
					width:2%;
					font-size:7px;
					padding: 0px;
				}
				table{
					border-collapse:collapse;
				}
				.black{
					font-weight:bold;
				}
				.light{
					font-weight:lighter;	
				}
				strong{
					font-size:14px;
					font-weight:600;
				}
				small{
					font-size:13px;
					font-weight:400;
				}
				</style>
</head>

<body>
           <div class="contenedor">
              
				<table width="80%" class="text_left" style="margin-left:auto; margin-right:auto; position:relative;">
                	<thead>
                        <tr class="min">
                            <td width="40%" class="minimo_titulo">{{ HTML::image('img/logo_color.png', 'Imagen usuario', array('width'=>'92', 'height'=>99)) }}</td> 
                            <td width="60%" style="text-align:center;">
                            										<h1 style="text-decoration:">Establecimiento Baixens</h1>
                                                                    Pol.Ind. Moncarra, S/N - 46230 Alginet (Valencia) España<br>
                                                                    Tel/Fax: 961 75 93 92<br>
                                                                    WWW.BAIXENS.COM
                                                                    
                            </td> 
                        </tr>
                    </thead>
                </table>
           </div>
           
           <div class="margin_top">
                <table width="80%" class="table_gran"  style="margin-left:auto; margin-right:auto; position:relative; margin-top:20px; text-align:center;">
                    @foreach($formulas as $formula)
                    <?php if($formula->idSeccionFormula!=$idSeccion){ 
                        $idSeccion=$formula->idSeccionFormula; 
                    ?>
                    <thead>
                        <tr class="min">
                            <td colspan="5" width="100%" class="minimo_titulo" style="text-align:center; background-color:#FAFAFA""><h1>{{$formula->SeccionesFormula->seccion}}</h1></td> 
                        </tr>
                    </thead>
                    <thead>
                        <tr class="black">
                            <td style="width:10%;"><strong>NF</strong>	</td>
                            <td style="width:10%;"><strong>Codigo</strong>	</td>
                            <td style="width:30%;"><strong>Nombre formula</strong>	</td>
                            <td style="width:40%;"><strong>Equivalencias</strong>	</td>
                            <td style="width:10%;"><strong>Importe €</strong>	</td>
                        </tr>
					</thead>
                    <?php } ?>
                    <tbody>
                        
                            <tr>
                                <td><small>{{$formula->numero}}</small></td>
                                <td><small>{{$formula->numero}}</small></td>
                                <td><small>{{$formula->nombre}}</small></td>
                                <td><small>
                                        @foreach($formula->FormulasEquivalencia as $eq)
                                			{{$eq->equivalencia}}<br>
                                  
                                        @endforeach
                                </small></td>
                                <td><small>{{Formula::importe()}}</small></td>
                            </tr>
                            
                    </tbody>
                    @endforeach
                    
                    
                    
                    
                </table>
                
                
                
                <div style="clear:both;"></div>
             </div> 
    <script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    window.print();
});
</script> 
                                       
                                     
</body>
</html>