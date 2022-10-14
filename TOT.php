<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}



function TOT_MostrarTabla($conn){
	$query=$_SESSION['TxtQTOT'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos de la tabla
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(800,1,0,0);
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
			$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Equipo</td>"; 
			$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Sector</td>";   
			$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Cliente</td>"; 
			$tablaclientes .="<td "."width="."180"." class="."TableShowT"."> Resp.Deteccion</td>"; 
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Estado</td>"; 
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>";   
			$tablaclientes .='</tr>';    
			$recuento=0;          
			$clase="TableShowD";
			while($row=mysql_fetch_array($rs)){ 			
				GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
				if($row['Estado']==0){$estado='ABIERTO';}else{$estado='CERRADO';}
				//muestro
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
				$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Centro'],0,18)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,18)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cliente'],0,18)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['A1'].' '.$row['N1'],0,20)."</td>";  
				$tablaclientes .="<td class=".$clase.$link."> ".$estado."</td>"; 
				$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  						
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  					
				$tablaclientes .='</td></tr>'; 
				$recuento=$recuento+1;
			}	
			$tablaclientes .=GLO_fintabla(1,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
		mysql_free_result($rs);
	}
	}
	




GLOF_Init('TxtFechaD','BannerConMenuHV','TOT/zConsulta',0,'',0,0,0); 
GLO_tituloypath(0,730,'Inicio.php','TARJETAS DE OBSERVACION','linksalir');
?>

<table width="730" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="70"></td><td width="100"></td><td width="130"></td><td width="60"></td><td width="100"></td><td width="70"></td><td width="100"></td><td width="100"></td></tr>
<tr> <td height="18" align="right">&nbsp;Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaD","Codigo/","actual",2); ?></td><td> al&nbsp;<?php  GLO_calendario("TxtFechaH","Codigo/","actual",2); ?></td><td height="18" align="right">Equipo:</td><td>&nbsp;<select name="CbCentro" class="campos" id="CbCentro"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboEquipos("CbCentro","epparticulos",$conn); ?></select></td><td height="18" align="right">Cliente:</td><td  width="150">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQTOT',0);
GLO_linkbutton(730,'Agregar','TOT/Alta.php','Categorias','TOTCategoria.php','','');
GLO_mensajeerror();
TOT_MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

include ("Codigo/FooterConUsuario.php");
?>