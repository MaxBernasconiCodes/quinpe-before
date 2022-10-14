<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";

//perfiles 

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



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

	</tr>';

}

function DF_FilaTitulo($v1,$v2,$v3,$v4,$v5,$v6){

	echo 

	'<tr height="20">

	<td width="10" class="DPCT DPBG1"></td><td width="200" class="DPCT DPBG1">'.$v1.'</td><td width="10" class="DPCT DPBR DPBG1"></td>

	<td width="10" class="DPCT DPBG2"></td><td width="200" class="DPCT DPBG2">'.$v2.'</td><td width="10" class="DPCT DPBR DPBG2"></td>

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

	</tr>';

}







GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','',0,0,0,0); 

GLO_tituloypath(0,1100,'Solicitudes.php','CIRCUITO REPARACIONES','linksalir');





//abre tabla

echo '<table width="1100" border="0"   cellspacing="0" class="DPB">';

//titulos

DF_FilaTitulo('Usuario','Taller','','','','');

DF_FilaDiv('','','','','','');

//filas



DF_FilaDato('Emite Solicitud de ingreso de Unidad a Taller con sus Requerimientos (<strong>Solicitada</strong>)','','','','','');

DF_FilaDiv('R','','','','','');



DF_FilaDato('','Alta de Orden asociada a Solicitud<br>(<strong>Solicitud Aceptada</strong>, <strong>Orden Emitida</strong>)','','','','');

DF_FilaDiv('','D','','','','');



DF_FilaDato('','Completa Planilla de Control<br>(<strong>Solicitud Aceptada</strong>, <strong>Orden Controlada</strong>)','','','','');

DF_FilaDiv('','D','','','','');



DF_FilaDato('','Registra Acciones con sus Tareas e Insumos<br>(<strong>Solicitud Aceptada</strong>, <strong>Orden Controlada y En Ejecucion</strong>)','','','','');

DF_FilaDiv('','D','','','','');



DF_FilaDato('','Finaliza las Acciones<br>(<strong>Solicitud A Retirar</strong>, <strong>Orden Cerrada y A Retirar</strong>)','','','','');

DF_FilaDiv('','D','','','','');



DF_FilaDato('','Entrega la Unidad<br>(<strong>Solicitud Retirada</strong>, <strong>Orden Cerrada</strong>)','','','','');

DF_FilaDiv('','D','','','','');



//cierra tabla

DF_FilaDiv('','','','','','');

echo '</table>';



GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>