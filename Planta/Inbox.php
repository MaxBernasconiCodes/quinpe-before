<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";include("../Procesos/Includes/zFunciones.php") ;include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQPLAIB'];
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//contenedora
		$tablaclientes='';		
		$tablaclientes .='<table  width="1190" border="0" cellspacing="0" cellpadding="0" class="TMT5"><tr> <td  height="3" ></td></tr>';
		$tablaclientes .='<tr valign="top"> <td  align="center" valign="top" >';
		//Titulos
		$tablaclientes .='<table width="1190" border="0" cellspacing="0" cellpadding="0" ><tr>';
		$tablaclientes .="<td class="."recuento".">Seleccione el dep&oacute;sito para poder ingresar el producto en Planta </td></td></tr><tr><td "."height="."3"."></td></tr></table>";
		//		
		$tablaclientes .='<table width="1190" class="TableShow" id="tshow"><tr>';
		$tablaclientes .='<td width="50" class="TableShowT TAR">COA</td>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Cliente</td>";  
		$tablaclientes .="<td "."width="."270"." class="."TableShowT"."> Producto</td>"; 
		$tablaclientes .='<td width="60" class="TableShowT TAR">Cantidad Total</td>';	
		$tablaclientes .='<td width="60" class="TableShowT TAR">Cantidad en Planta</td>';
		$tablaclientes .='<td width="60" class="TableShowT TAR">Cantidad Pendiente</td>';
		$tablaclientes .='<td width="50" class="TableShowT" > Unidad</td>'; 	
		$tablaclientes .='<td width="50" class="TableShowT" > Envase</td>'; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Lote</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Remito</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Deposito</td>"; 
		$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Factor</td>"; 
		$tablaclientes .='<td width="40" class="TableShowT" > Uni Stock</td>';
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."></td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$clase="TableShowD";$estilo='';$link='';
		while($row=mysql_fetch_array($rs)){ 
			//deposito
			$combodep=ComboTablaRFXMasivo("depositos",0,"Nombre","","and Tipo=1",$conn);
			$cbdep='<select name="CbDeposito['.$row['Id'].']" style="width:90px" class="campos"><option value=""></option>'.$combodep.' </select>';
			//cantidad rojo si es cero
			if($row['Cant']==0){$stylecant='TRed';}else{$stylecant='';}
			$cantpdte=$row['Cant']-$row['CantI'];
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Cliente'],0,8)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Producto'],0,35)."</td>";
			$tablaclientes .='<td class="TableShowD TAR '.$stylecant.'"'.$link.'>'.$row['Cant']."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR '.'"'.$link.'>'.$row['CantI']."</td>";	
			$tablaclientes .='<td class="TableShowD TAR TBlue'.'"'.$link.'>'.number_format($cantpdte,2, '.', '')."</td>";	
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Uni'],0,6)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Env'],0,6)."</td>"; 		
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Lote'],0,15)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Rto'],0,15)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.$cbdep."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>';
			//muestra factor si no coinciden las unidades
			if($row['UniBar']!=$row['UniProd']){
				$tablaclientes .='<input name="TxtFactor['.$row['Id'].']"  type="text"  style="width:40px" maxlength="5" onChange="this.value=validarNumeroP(this.value);">';
			}
			$tablaclientes .='</td>';
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Abr2'],0,5)."</td>";
			$tablaclientes .='<td class="TableShowD TAR" >';
			if($cantpdte>0){
				$tablaclientes .=GLO_rowbutton("CmdAddFila",$row['Id'],"Alta en Planta",'self','dep','iconlgray','Alta en Planta',1,0,0);  
				$tablaclientes .=' &nbsp;&nbsp;&nbsp; '.GLO_rowbutton("CmdSplitFila",$row['Id'],"Dividir en Planta",'self','clone','iconlgray','Dividir en Planta',1,0,0);  
			}
			$tablaclientes .='</td></tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}

//html
GLOF_Init('','BannerConMenuHV','zInbox',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'../Inicio.php','INGRESAR MATERIA PRIMA','linksalir');
?>


<table width="700" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="70"></td><td width="170"></td><td width="70"></td><td width="170"></td><td width="70"></td><td width="100"></td><td width="50"></td></tr>
<tr> <td height="18" align="right">Cliente:</td><td >&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td height="18" align="right">Producto:</td><td>&nbsp;<select name="CbProducto" class="campos" id="CbProducto"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("items","CbProducto","Nombre","","and Tipo=0",$conn); ?></select></td><td height="18" align="right">Nro.Analisis:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPLAIB',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 


GLO_initcomment(0,0);
echo 'Si no coincien las <font class="comentario3">Unidades de medida</font> debe aplicar el <font class="comentario2">Factor</font> de conversion<br>';
echo 'COA <font class="comentario2">Aceptados</font> o que  <font class="comentario2">No llevan Analisis</font> no ingresados a Planta<br>';
echo 'Solo trae aquellos asociados a un item de <font class="comentario3">Barrera</font><br>';
echo 'Solo considera <font class="comentario2">Depositos</font> tipo <font class="comentario3">Planta</font>';
GLO_endcomment();

PLA_verimagenplanta();//imagen planta

include ("../Codigo/FooterConUsuario.php");
?>