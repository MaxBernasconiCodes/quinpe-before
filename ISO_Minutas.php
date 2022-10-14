<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');include("ISOMinutas/Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaDCP'])){
	$fecha=date('Y-m-j');$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
	$_SESSION['TxtFechaDCP']=date("d-m-Y", $nuevafecha );$_SESSION['TxtFechaHCP']=date("d-m-Y");//hoy
}


function MIN_MostrarTabla($conn){
	$query=$_SESSION['TxtQISOMIN'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Marco de la tabla	
			$tablaclientes='';	
			$tablaclientes .=GLO_inittabla(800,1,0,0);
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>"; 
			$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Hora</td>"; 
			$tablaclientes .="<td "."width="."660"." class="."TableShowT".">Tema</td>";   
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
			$tablaclientes .='</tr>';    
			$recuento=0;     
			while($row=mysql_fetch_array($rs)){
				GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
				$tablaclientes .="<td class="."TableShowD ".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>";  
				$tablaclientes .="<td class="."TableShowD ".$link."> ".GLO_FormatoHora($row['Hora'])."</td>";  
				$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Nombre'],0,80)."</td>";  			
				$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  						
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
				$tablaclientes .="</td>";  
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}mysql_free_result($rs);		
			$tablaclientes .=GLO_fintabla(1,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
		//Cierra consulta
		
	}
	}
	

GLOF_Init('','BannerConMenuHV','ISOMinutas/zConsulta',0,'',0,0,0); 
GLO_tituloypath(0,500,'Inicio.php','MINUTAS DE REUNION','linksalir');
?>

<table width="500" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="150"></td><td width="100"></td><td width="140"></td><td width="110"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Fecha:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaDCP","Codigo/","actual",1); ?></td><td  > al&nbsp;
<?php  GLO_calendario("TxtFechaHCP","Codigo/","actual",1); ?></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<? 
GLO_linkbutton(500,'Agregar','ISOMinutas/Alta.php','Tareas','ISOMinutas/Tareas.php','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQISOMIN',0);
GLO_mensajeerror(); 
MIN_MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>