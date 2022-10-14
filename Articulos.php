<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";include("Articulos/Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
function MostrarTabla($conn){
$query=$_SESSION['TxtQArt']; 
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1020,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."350"." class="."TableShowT"."> Descripci&oacute;n</td>"; 
		$tablaclientes .="<td "."width="."90"." class="."TableShowT"."> Tipo</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Rubro</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Marca</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Modelo</td>"; 
		$tablaclientes .="<td "."width="."140"." class="."TableShowT"."> NSE</td>"; 
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Modifica Stock</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Vto</td>";
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;$estilo=" style='cursor:pointer;'";
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='Articulos/Modificar.php?Flag1=True&id=".$row['Id']."'";	
			if($row['Stock']==1){$stock='Stock';}else{$stock='';}	
			$fbaja= GLO_FormatoFecha($row['FechaBaja']);
			$fvto=GLO_FormatoFecha($row['FechaV']);
			$clase="";$clasefv="";$clasest="";
			if ($fbaja=='' or (strtotime(date("d-m-Y"))-strtotime($fbaja))<0){
			    $clasest=" TBlue";
				if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0){$clasefv=" TRed";}//vencida				
			}else{$clase=" TGray";}//dado de baja
			
			
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';  
			$tablaclientes .='<td class="TableShowD TAR'.$clase.'"'.$link.'>'.str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link.'>'.substr($row['Nombre'],0,40)."</td>"; 
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link.'>'.ART_Tipo($row['EPP'])."</td>"; 
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link.'>'.substr($row['Rubro'],0,10)."</td>"; 
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link.'>'.substr($row['Marca'],0,10)."</td>";  
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link.'>'.substr($row['Modelo'],0,10)."</td>"; 
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link.'>'.substr($row['NSE'],0,20)."</td>";  
			$tablaclientes .='<td class="TableShowD'.$clase.$clasest.'"'.$link.'>'.$stock."</td>"; 
			$tablaclientes .='<td class="TableShowD'.$clase.$clasefv.'"'.$link.'>'.$fvto."</td>";  
			$tablaclientes .='<td class="TableShowD TAC'.$clase.'">'.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0). "</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}mysql_free_result($rs);	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}
GLOF_Init('','BannerConMenuHV','Articulos/zArticulos',0,'Articulos/MenuH',0,0,0);
GLO_tituloypath(0,700,'Inicio.php','ARTICULOS','linksalir'); 
?>
<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="3" width="80"></td><td width="130"></td><td width="70"></td><td width="130"></td><td width="150"></td><td width="100"></td><td width="30"></td></tr>
<tr><td  align="right" >Art&iacute;culo:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:100px" maxlength="30" onKeyDown="enterxtab(event)"> </td><td  align="right" >Tipo:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  tabindex="1"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ART_CbTipo('CbTipo'); ?></select></td><td><input name="ChkReq"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkReq'] =='1') echo 'checked'; ?>>Modifica Stock</td><td><input name="ChkActivo"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>>Activos</td><td></td></tr>
<tr><td  align="right" >Nro.Art&iacute;culo:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="width:100px"></td><td  align="right" >Rubro:</td><td>&nbsp;<select name="CbRubro" class="campos" id="CbRubro"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("rubros","CbRubro","Nombre","","",$conn); ?></select></td><td><input name="ChkF1" class="check"  type="checkbox"  value="1" <? if ($_SESSION['ChkF1'] =='1') echo 'checked'; ?>>No Modifica Stock</td><td><input name="ChkVE"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkVE'] =='1') echo 'checked'; ?>>Vencidos</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>	</tr>
</table>
<? 
GLO_linkbutton(700,'Agregar','Articulos/Alta.php','','','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQArt',0);GLO_Hidden('TxtQArtEX',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>