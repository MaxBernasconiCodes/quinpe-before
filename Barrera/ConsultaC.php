<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFDBARC'])){
	$_SESSION['TxtFDBARC']=date("d-m-Y");
}


function MostrarTabla($conn){
$query=$_SESSION['TxtQPROCBARC'];
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(650,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Ingreso</td>";  
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> </td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Egreso</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> </td>"; 
		$tablaclientes .="<td "."width="."290"." class="."TableShowT".">Conductor/Persona</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">DNI</td>"; 
		$tablaclientes .='</tr>'; 
		$recuento=0;  $link='';$estilo='';$ingresos=0;  $egresos=0; 
		while($row=mysql_fetch_array($rs)){ 
			if($row['Tipo']==1){//propio
				$doc=$row['Documento'];$cho=$row['ACH'].' '.$row['NCH'];$wchofer=' and a2.IdChofer='.$row['IdChofer'];
			}else{//terceros
				$doc=$row['DNI'];$cho=$row['Chofer'];$wchofer=' and a2.DNI='.$row['DNI'];
			}
			//busca egreso
			$horaegreso='';$medioegreso='';$clasee=' TFRed';
			
			//busca egreso de esa fecha y dni
			$wbuscar='';			
			$wbuscar=$wbuscar.$wchofer;//chofer de la fila
			$wbuscar=$wbuscar." and a2.Id<>".$row['Id'];//que no sea el registro de ingreso de esta fila
			$wbuscar=$wbuscar." and DATEDIFF(a2.Fecha,'".GLO_FechaMySql($_SESSION['TxtFDBARC'])."')=0";//fecha seleccionada
			//$wbuscar=$wbuscar." and TIMEDIFF(a2.Hora,'".$row['Hora']."')>=0";//hora mayor o igual a la de la fila
			$wbuscar=$wbuscar." and TIME_TO_SEC(a2.Hora)>=TIME_TO_SEC('".$row['Hora']."')";//hora mayor o igual a la de la fila
			$wbuscar=$wbuscar." and a2.Hora<>'00:00:00'";//hora distinto de vacio
			//trae el primer movimiento de barrera de esa persona inmediato al ingreso	de esta fila
			$querypersonas="SELECT a2.Hora,a2.Etapa,'PERSONA' as TipoB From procesosop_e2 a2 Where a2.Id<>0  $wbuscar";
			$querycamiones="SELECT a2.Hora,a2.Etapa,'VEH&Iacute;CULO' as TipoB  From procesosop_e1 a2 Where a2.Id<>0 $wbuscar";
			$query="SELECT x.* From ($querypersonas UNION ALL $querycamiones)x Order by x.Hora LIMIT 2";
			$rs2=mysql_query($query,$conn);//echo $query;
			while($row2=mysql_fetch_array($rs2)){ 							
				if($row2['Etapa']==1){//si es egreso (muestro rojo si el egreso falta)
					$horaegreso=GLO_FormatoHora($row2['Hora']);$medioegreso=$row2['TipoB'];$clasee='';$egresos++;
				}
			}mysql_free_result($rs2);
			//valido check sin egreso 
			if(intval($_SESSION['Chk3'])==0 or (intval($_SESSION['Chk3'])==1 and $horaegreso=='') ){
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
				$tablaclientes .='<td class="TableShowD TBold TBlue"'.$link."> ".GLO_FormatoHora($row['Hora'])."</td>"; 
				$tablaclientes .='<td class="TableShowD TBlue"'.$link."> ".$row['TipoB']."</td>";
				$tablaclientes .='<td class="TableShowD TBold TGreen'.$clasee.'"'.$link."> ".$horaegreso."</td>"; 
				$tablaclientes .='<td class="TableShowD TGreen"'.$link."> ".$medioegreso."</td>";
				$tablaclientes .="<td class="."TableShowD".$link."> ".substr($cho,0,35)."</td>"; 
				$tablaclientes .="<td class="."TableShowD".$link."> ".$doc."</td>"; 
				$tablaclientes .='</tr>'; 
				$recuento++;$ingresos++;
			}
		}	
		//GLO_fintabla
		$tablaclientes .='</table></td></tr>';
		$tablaclientes .='<tr><td class="comentario ';
		if($ingresos>$egresos){$tablaclientes .='TRed';}//si hay gente adentro
		$tablaclientes .='" style="vertical-align:top;text-align:right;">'.$ingresos.' ingresos | '.$egresos.' egresos </td></tr>';
		$tablaclientes .='<tr><td  height=5 ></td></tr></table>';
		//
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


//html
GLOF_Init('','BannerConMenuHV','zConsultaC',0,'MenuH',0,0,0); 
GLO_tituloypath(0,650,'Consulta.php','CONTROL PERSONAS','linksalir');
?>

<table width="650" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="60"></td><td width="100"></td><td width="70"></td><td width="110"></td><td width="60"></td><td width="110"></td><td width="110"></td><td width="30"></td></tr>

<tr> <td height="18" align="right">Fecha:</td><td align="center">&nbsp;<?php  GLO_calendario("TxtFDBARC","../Codigo/","actual",2); ?></td><td align="right">Personal:</td><td>&nbsp;<select name="CbPersonal" style="width:80px" class="campos"  id="CbPersonal" ><option value=""></option><? echo ComboPersonalRFX("CbPersonal",$conn);?></select></td><td  align="right">DNI:</td><td>&nbsp;<input name="TxtDoc" type="text"  class="TextBox"  maxlength="14"  value="<? echo $_SESSION['TxtDoc']; ?>"  style="width:90px" onChange="this.value=validarEntero(this.value);"></td><td><input name="Chk3"  type="checkbox" class="check"  value="1" <? if ($_SESSION['Chk3'] =='1') echo 'checked'; ?>>Sin Egreso</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?></td></tr>


</table>




<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPROCBARC',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Muestra la situacion de las <font class="comentario2">Personas(DNI)</font> que Ingresaron<br>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>