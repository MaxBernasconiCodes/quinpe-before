<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);



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

	</tr>';

}

function DF_FilaTitulo($v1,$v2,$v3,$v4,$v5,$v6){

	echo 

	'<tr height="20">

	<td width="10" class="DPCT DPBG1"></td><td width="200" class="DPCT DPBG1">'.$v1.'</td><td width="10" class="DPCT DPBR DPBG1"></td>

	<td width="10" class="DPCT DPBG2"></td><td width="200" class="DPCT DPBG2">'.$v2.'</td><td width="10" class="DPCT DPBR DPBG2"></td>

	<td width="10" class="DPCT DPBG3"></td><td width="200" class="DPCT DPBG3">'.$v3.'</td><td width="10" class="DPCT DPBR DPBG3"></td>

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

	</tr>';

}







GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','',0,0,0,0); 


GLO_tituloypath(0,1100,'../ISO_Doc.php','CIRCUITO DOCUMENTOS','linksalir');





//abre tabla

echo '<table width="1100" border="0"   cellspacing="0" class="DPB">';

//titulos

DF_FilaTitulo('Usuario','Responsable Control','Responsable Aprobacion','','','');

//filas

DF_FilaDiv('','','','','','');

DF_FilaDato('Genera Documento (<strong>Elaborado</strong>)','','','','','');

DF_FilaDiv('D','','','','','');



DF_FilaDato('Agrega archivo del Documento y elige Abrir (<strong>Abierto</strong>)','','','','','');

DF_FilaDiv('R','','','','','');



DF_FilaDato('','Graba comentario y fecha, y hace click en Controlar(<strong>Controlado</strong>)','','','','');

DF_FilaDiv('','R','','','','');





DF_FilaDato('','','Graba comentario y fecha, y hace click en Aprobar(<strong>Aprobado</strong>)','','','');

DF_FilaDiv('','','L','','','');



DF_FilaDato('Genera nueva version haciendo click en Nuevo','','','','','');

DF_FilaDiv('D','','','','','');



DF_FilaDato('Cuando el nuevo Documento se aprueba, el original se marca <strong>Obsoleto</strong>','','','','','');

DF_FilaDiv('','','','','','');



//cierra tabla

echo '</table>';



GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>