<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";

//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtConsultaAnx'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla		
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(800,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."490"." class="."TableShowT"."> Nombre</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Origen</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Sector</td>"; 
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."></td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;          
		while($row=mysql_fetch_array($rs)){
			$id=$row['Id'];
			$nrodoc=str_pad($row['Id'], 5, "0", STR_PAD_LEFT);	
			$estilo=" style='cursor:pointer;' ";
			$link=" onclick="."location='ISOAnexos/Modificar.php?Flag1=True&id=".$row['Id']."'";
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .="<td class="."TableShowD ".$link."> ".$nrodoc."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Nombre'],0,60)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Origen'],0,12)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Sector'],0,12)."</td>";  			
			$tablaclientes .="<td  class="."TableShowD"." style='text-align:right;'>"; 		
			if( !(empty($row['Ruta']))){//si tiene adjunto visible
			$tablaclientes .=GLO_rowbutton("CmdVerFile",$row['Id'],"Ver",'blank','lupa','iconlgray','',1,0,0);   
			}	
			//solo agregan perfil coord y admin
			if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
			$tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0).'&nbsp;'; 
			} 
			$tablaclientes .="</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	//Cierra consulta
	mysql_free_result($rs);
	
}
}


?>

<? GLO_InitHTML($_SESSION["NivelArbol"],'TxtBusqueda','BannerConMenuHV','ISOAnexos/zISO_Anexos',0,0,0,0); ?>
<? GLO_tituloypath(950,700,'Inicio.php','DOCUMENTOS EXTERNOS','linksalir'); ?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="150"></td><td width="50"></td><td width="100"></td><td width="90"></td><td width="190"></td><td width="40"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Nombre:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:100px" maxlength="30" onKeyDown="enterxtab(event)"></td><td height="18" align="right">Id:</td><td   colspan="1">&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="10"  value="<? echo $_SESSION['TxtNro']; ?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:70px" onKeyDown="enterxtab(event)"></td><td align="right">Sector:</td><td>&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:120px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td><td align="right" ><? GLO_Search('CmdBuscar',0);?></td></tr>
</table>



<?
//solo agregan perfil coord y admin
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
GLO_linkbutton(700,'Agregar','ISOAnexos/Alta.php','','','','');
}

GLO_Hidden('TxtId',0);GLO_Hidden('TxtConsultaAnx',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>