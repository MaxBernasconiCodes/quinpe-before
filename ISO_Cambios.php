<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');include("ISOCambios/Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(14);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaDCP'])){
	$fecha=date('Y-m-j');$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
	$_SESSION['TxtFechaDCP']=date("d-m-Y", $nuevafecha );$_SESSION['TxtFechaHCP']=date("d-m-Y");//hoy
}




function CAM_MostrarTabla($conn){
	$query=$_SESSION['TxtQISOCAM'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Marco de la tabla	
			$tablaclientes='';	
			$tablaclientes .=GLO_inittabla(870,1,0,0);
			$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";   
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>"; 
			$tablaclientes .="<td "."width="."590"." class="."TableShowT".">Obra/Serv/Sector</td>";  
			$tablaclientes .="<td "."width="."60"." class="."TableShowT".">Prioridad</td>";   
			$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Estado</td>";   
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
			$tablaclientes .='</tr>';    
			$recuento=0;     
			while($row=mysql_fetch_array($rs)){
				GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
				$tablaclientes .="<td class="."TableShowD ".$link." style='text-align:right;'> ".str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>";  
				$tablaclientes .="<td class="."TableShowD ".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>";  
				$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Nombre'],0,70)."</td>";  		
				$tablaclientes .="<td class="."TableShowD ".$link."> ".CAM_BuscaPrioridad($row['Prio'])."</td>";  
				$tablaclientes .="<td class="."TableShowD ".$link."> ".CAM_BuscaEstado($row['Estado'])."</td>";  			
				$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  						
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  					
				$tablaclientes .="</td>";  
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}mysql_free_result($rs);		
			$tablaclientes .=GLO_fintabla(1,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
		
	}
}

	

GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaDCP','BannerConMenuHV','ISOCambios/zConsulta',0,0,0,0); 
GLO_tituloypath(0,710,'','GESTION DE CAMBIOS','salir');
?>


<table width="710" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="120"></td><td width="80"></td><td width="100"></td><td width="80"></td><td width="100"></td><td width="50"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Fecha:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaDCP","Codigo/","actual",1); ?></td><td  > al&nbsp;
<?php  GLO_calendario("TxtFechaHCP","Codigo/","actual",1); ?></td><td align="right">Prioridad:</td><td>&nbsp;<select name="CbPrio" class="campos" id="CbPrio"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? CAM_ComboPrioridad('CbPrio'); ?></select></td><td align="right">Estado:</td><td>&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:80px" onKeyDown="enterxtab(event)"  ><option value=""></option><? CAM_ComboEstado('CbEstado'); ?></select></td><td   align="right" ><? GLO_Search('CmdBuscar',0);?></td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQISOCAM',0);
GLO_linkbutton(710,'Agregar','ISOCambios/Alta.php','','','','');
GLO_mensajeerror(); 
CAM_MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
?>

<? include ("Codigo/FooterConUsuario.php");?>