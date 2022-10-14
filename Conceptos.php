<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");include("Conceptos/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function MostrarTabla($conn){
$query=$_SESSION['TxtQIT'];$query=str_replace("\\", "", $query);
if ( $query!=""){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){			
	$tablaclientes='';
	$tablaclientes .=GLO_inittabla(730,1,0,0);
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> N&uacute;mero</td>";  
	$tablaclientes .="<td "."width="."470"." class="."TableShowT".">Nombre</td>";  
	$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Tipo</td>";   
	$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Unidad</td>";  
	$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
	$tablaclientes .='</tr>';             
	$recuento=0; $estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='Conceptos/Modificar.php?id=".$row['Id']."'";
		if ($row['Inactivo']==0){$clase="TableShowD";}else{$clase="TableShowD TGray";}
		//
		$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
		$tablaclientes .='<td class="'.$clase.' TAR'.$clase.'"'.$link.'>'.str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";
		$tablaclientes .='<td class="'.$clase.'"'.$link."> "." ".substr($row['Nombre'],0,50)."</td>"; 
		$tablaclientes .='<td class="'.$clase.'"'.$link."> "." ".IT_tipoitem($row['Tipo'])."</td>"; 
		$tablaclientes .='<td class="'.$clase.'"'.$link."> "." ".$row['Abr']."</td>"; 
		$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0). "</td>";  
		$tablaclientes .='</tr>';
		$recuento=$recuento+1;
	}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);		
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}




GLOF_Init('TxtNombre','BannerConMenuHV','Conceptos/zConceptos',0,'Servicios/MenuH',0,0,0); 
GLO_tituloypath(0,600,'Servicios.php','ITEMS','linksalir'); 
?>

<table width="600" border="0" cellspacing="0" class="Tabla" >
<tr><td  height=3 width="80" ></td><td width="120"></td><td width="180"></td><td  width="120"></td><td  width="100"></td></tr>
<tr><td  align="right" >Nombre:</td><td>&nbsp;<input name="TxtBusquedaN" type="text" class="TextBox" style="width:100px" maxlength="20" onKeyDown="enterxtab(event)"></td><td >Tipo:&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:80px" onKeyDown="enterxtab(event)"><option value="99"></option><?  Cb_TipoItem("CbTipo"); ?></select></td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Activos</td>    <td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>	</tr>
</table>


<?
GLO_linkbutton(600,'Agregar','Conceptos/Alta.php','','','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQIT',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 
include ("Codigo/FooterConUsuario.php");
?>