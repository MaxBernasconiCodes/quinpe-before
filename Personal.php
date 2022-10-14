<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
include("Personal/Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(10);


//solo agrega y ve legajo admin sistema(2) y rrhh(3)


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function MostrarTabla($conn){
$query=$_SESSION['TxtQPERS'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(910,1,0,0);
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Legajo</td>";   
		$tablaclientes .="<td "."width="."140"." class="."TableShowT"."> Apellido</td>";   
		$tablaclientes .="<td "."width="."140"." class="."TableShowT"."> Nombre</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Documento</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> CUIT/CUIL</td>"; 
		$tablaclientes .="<td "."width="."140"." class="."TableShowT"."> Razon Social</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Funcion </td>";   
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Localidad</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Baja</td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;' ";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='Personal/Modificar.php?Flag1=True&id=".$row['Id']."'";
			$fbaja= GLO_FormatoFecha($row['FechaBaja']);
			if ($fbaja=='' or (strtotime(date("d-m-Y"))-strtotime($fbaja))<0){$clase="TableShowD";}else{$clase="TableShowD TGray";}	
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';  
			$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Apellido'],0,12)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Nombre'],0,12)."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Documento'],0,14)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Identificacion'],0,14)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['RazonSocial'],0,18)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Funcion'],0,12)."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['NombreLocalidad'],0,12)."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$fbaja."</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}



GLOF_Init('TxtBusqueda','BannerConMenuHV','Personal/zPersonal',0,'Personal/MenuH',0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','PERSONAL','linksalir'); 
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="80" ></td><td width="110"></td><td width="80"></td><td width="110"></td><td width="80"></td><td width="120"></td><td width="100"></td><td width="30"></td></tr>
<tr><td  align="right" >Personal:</td><td >&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:80px" maxlength="20" onKeyDown="enterxtab(event)"> </td><td  align="right" >Sector:</td><td>&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:80px" onkeydown="enterxtab(event)">
<option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td><td  align="right" >Funci&oacute;n:</td><td>&nbsp;<select name="CbFuncion" class="campos" id="CbFuncion"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("funcion","CbFuncion","Nombre","","",$conn); ?></select> </td><td><input name="ChkActivo"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Inactivos</td><td  align="right"><? GLO_Search('CmdBuscar',0);?></td></tr>
</table>


<? 
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){
	GLO_linkbutton(700,'Agregar','Personal/Alta.php','','','','');
}  

GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPERS',0);GLO_Hidden('TxtQPEREX',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>