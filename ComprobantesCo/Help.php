<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";

//perfiles 

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



function DF_FilaDiv($v1,$v2,$v3,$v4,$v5,$v6){// Top,Down,Left,Right

	if($v1!=''){$icon=$v1;}if($v2!=''){$icon=$v2;}if($v3!=''){$icon=$v3;}if($v4!=''){$icon=$v4;}if($v5!=''){$icon=$v5;}if($v6!=''){$icon=$v6;}

	//flecha

	switch ($icon) {

		case 'D':  $icon='<i class="fa fa-arrow-down iconlgray"></i>'; break;

		case 'R':  $icon='<i class="fa fa-arrow-right iconlgray"></i>'; break;

		case 'L':  $icon='<i class="fa fa-arrow-left iconlgray"></i>'; break;

	}	

	if($v1!=''){$v1=$icon;}if($v2!=''){$v2=$icon;}if($v3!=''){$v3=$icon;}

	if($v4!=''){$v4=$icon;}if($v5!=''){$v5=$icon;}if($v6!=''){$v6=$icon;}

	//muestro

	echo 

	'<tr>

	<td class="DPCD"></td><td class="DPCD ">'.$v1.'</td><td class="DPCD DPBR"></td>

	<td class="DPCD"></td><td class="DPCD">'.$v2.'</td><td class="DPCD DPBR"></td>

	<td class="DPCD"></td><td class="DPCD">'.$v3.'</td><td class="DPCD DPBR"></td>

	<td class="DPCD"></td><td class="DPCD">'.$v4.'</td><td class="DPCD DPBR"></td>

	<td class="DPCD"></td><td class="DPCD">'.$v5.'</td><td class="DPCD DPBR"></td>

	</tr>';

}

function DF_FilaTitulo($v1,$v2,$v3,$v4,$v5,$v6){

	echo 

	'<tr height="20">

	<td width="10" class="DPCT DPBG1"></td><td width="200" class="DPCT DPBG1">'.$v1.'</td><td width="10" class="DPCT DPBR DPBG1"></td>

	<td width="10" class="DPCT DPBG2"></td><td width="200" class="DPCT DPBG2">'.$v2.'</td><td width="10" class="DPCT DPBR DPBG2"></td>

	<td width="10" class="DPCT DPBG3"></td><td width="200" class="DPCT DPBG3">'.$v3.'</td><td width="10" class="DPCT DPBR DPBG3"></td>

	<td width="10" class="DPCT DPBG4"></td><td width="200" class="DPCT DPBG4">'.$v4.'</td><td width="10" class="DPCT DPBR DPBG4"></td>

	<td width="10" class="DPCT DPBG5"></td><td width="200" class="DPCT DPBG5">'.$v5.'</td><td width="10" class="DPCT DPBR DPBG5"></td>

	</tr>';

}

function DF_FilaDato($v1,$v2,$v3,$v4,$v5,$v6){

	//clase

	if($v1==''){$c1='';}else{$c1='DPBG1';}if($v2==''){$c2='';}else{$c2='DPBG2';}

	if($v3==''){$c3='';}else{$c3='DPBG3';}if($v4==''){$c4='';}else{$c4='DPBG4';}

	if($v5==''){$c5='';}else{$c5='DPBG5';}

	//muestro

	echo 

	'<tr>

	<td class="DPC"></td><td class="DPC '.$c1.'">'.$v1.'</td><td class="DPC DPBR"></td>

	<td class="DPC"></td><td class="DPC '.$c2.'">'.$v2.'</td><td class="DPC DPBR"></td>

	<td class="DPC"></td><td class="DPC '.$c3.'">'.$v3.'</td><td class="DPC DPBR"></td>

	<td class="DPC"></td><td class="DPC '.$c4.'">'.$v4.'</td><td class="DPC DPBR"></td>

	<td class="DPC"></td><td class="DPC '.$c5.'">'.$v5.'</td><td class="DPC DPBR"></td>

	</tr>';

}







GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUpMH','',0,0,0,0); 


GLO_tituloypath(0,1100,'NotasPedidoD.php','CIRCUITO COMPRAS','linksalir');





//abre tabla

echo '<table width="1100" border="0"   cellspacing="0" class="DPB">';

//titulos

DF_FilaTitulo('Usuario','PreAutorizante','Autorizante','Almacen','Compras','');

//filas

DF_FilaDiv('','','','','','');

DF_FilaDato('Emite Pedido (<strong>Abierto</strong>)','','','','','');

DF_FilaDiv('R','','','','','');



DF_FilaDato('','Registra Cantidad Autorizada y PreAutoriza (<strong>PreAutorizado</strong>)','','','','');

DF_FilaDiv('','R','','','','');



DF_FilaDato('','','Autoriza (<strong>Autorizado</strong>)','','','');

DF_FilaDiv('','','R','','','');



DF_FilaDato('','','','Si existe Stock Carga Remito Egreso (<strong>Resuelto</strong>)','','');

DF_FilaDiv('','','','D','','');

DF_FilaDato('','','','Si no existe deriva a Compras (<strong>Comprar</strong>)','','');

DF_FilaDiv('','','','R','','');



DF_FilaDato('','','','','Genera Cotizacion con los Pedidos <strong>Comprar</strong>','');

DF_FilaDiv('','','','','D','');

DF_FilaDato('','','','','Registra nro de Orden en los Pedidos <strong>Comprar</strong> (<strong>En Proceso</strong>)','');

DF_FilaDiv('','','','','L','');



DF_FilaDato('','','','Carga Remito Ingreso al recibir la compra (<strong>Comprado</strong>)','','');

DF_FilaDiv('','','','','','');

//cierra tabla

echo '</table>';



GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>