<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$_SESSION['TxtNroEntidad']=$_GET['Id'];

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -12 month"));$_SESSION['TxtFechaH']=$hoy;
}

function MostrarTabla($conn){
	$query=$_SESSION['TxtQSTREITNP'];$query=str_replace("\\", "", $query); 
	if ( $query!=""){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){
			//informo LIMIT
			if(mysql_num_rows($rs)==2000){echo '<p class="MuestraError" align="center">La consulta permite mostrar hasta 2000 registros</p>';}
			//marco 			
			echo '<table width="1130"><tr><td>';	
			//guardar		
			echo '<table width="1130"><tr><td class="comentario">Seleccione el Item y luego grabe</td><td align="right">'.GLO_FAButton('CmdGuardar','submit','90','self','Agregar','save','boton02').' '.GLO_FAButton('CmdComprar','submit','90','self','Comprar','cart','boton02').'</td></tr></table>';
			//Titulos de la tabla
			echo '<table width="1130" class="TableShow" id="tshow"><tr>
			<td width="70" class="TableShowT"> Fecha</td>   
			<td width="55" class="TableShowT TAR"> Pedido</td>   
			<td width="100" class="TableShowT"> Destino</td>  
			<td width="400" class="TableShowT"> Art&iacute;culo o Producto</td> 
			<td width="200" class="TableShowT"> Obs.Item Pedido</td>   
			<td width="60" class="TableShowT" >Modifica Stock</td> 
			<td width="70" class="TableShowT TAC"> Cantidad</td> 
			<td width="30" class="TableShowT"> </td> 
			<td width="30" class="TableShowT TAC"><input type="checkbox" name="ChkAll" onclick="CheckMasivoColor();"></td> 
			<td width="30" class="TableShowT TAC"></td> 
			<td width="110" class="TableShowT">Dividir Item</td>
			</tr>';             
			$recuento=0;  
			while($row=mysql_fetch_array($rs)){ 
				//articulo,producto u observaciones
				$claseart='';
				if($row['IdArticuloItem']>0){
					$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
				}else{
					if($row['IdProd']>0){
						$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
					}else{$claseart=" TRed ";$textoart=$row['ObsItem'];$abr='';}	
				}
				include("../ComprobantesCo/Includes/zDestinoNP.php");
				if($row['FS']==0){$fs='';}else{$fs='Modifica';}

				//
				echo '<tr id="'.$row['IdItemNP'].'" > 
				<td class="TableShowD">'.FormatoFecha($row['Fecha']).'</td> 
				<td class="TableShowD TAR">'.str_pad($row['IdNP'], 8, "0", STR_PAD_LEFT).'</td> 
				<td class="TableShowD">'.substr($destino,0,12).'</td> 
				<td class="TableShowD'.$claseart.'" title="'.$textoart.'">'.substr($textoart,0,45).'</td> 
				<td class="TableShowD" title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,24).'</td> 
				<td class="TableShowD TRed">'.$fs.'</td>
				<td class="TableShowD TAR"> '.$row['CantAutoItem'].'<input name="TxtCant3['.$row['IdItemNP'].']"  type="hidden"  value="'.$row['CantAutoItem'].'"></td>
				<td class="TableShowD">'.substr($abr,0,5).'</td> 
				<td class="TableShowD TAC">';
				//solo adjunta/compra si tiene articulo
				if($row['IdArticuloItem']>0 or $row['IdProd']>0){
				echo '<input type="checkbox" name="campos['.$row['IdNP'].'|'.$row['IdItemNP'].'|'.$row['IdArticuloItem'].'|'.$row['IdProd'].']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;}" onChange="CheckRow('.$row['IdItemNP'].',this.value);">';
				}else{
					echo GLO_rowbutton("CmdCompletar",$row['IdItemNP'],"Completar",'self','add','iconlgray','Completar',0,0,0); 
				}
				echo '</td><td class="TableShowD TAC">';
				/*				
				//solo modifica si completo articulo
				if($row['INC']==1 and  ($row['IdArticuloItem']>0 or $row['IdProd']>0) ){
					echo GLO_rowbutton("CmdCompletar",$row['IdItemNP'],"Completar",'self','add','iconlgray','Completar',0,0,0); 
				}
				*/
				//modifica todos (pedido por liliana medina)
				if($row['IdArticuloItem']>0 or $row['IdProd']>0) {
					echo GLO_rowbutton("CmdCompletar",$row['IdItemNP'],"Modificar",'self','add','iconlgray','Modificar',0,0,0); 
				}				
				echo'</td><td class="TableShowD">';
				//solo divide si tiene articulo
				if($row['IdArticuloItem']>0 or $row['IdProd']>0){
					echo '&nbsp;<input name="TxtCant1['.$row['IdItemNP'].']"  type="text"  style="width:30px" maxlength="7" onChange="this.value=validarEntero(this.value);">&nbsp;&nbsp;<input name="TxtCant2['.$row['IdItemNP'].']"  type="text" style="width:30px" maxlength="7" onChange="this.value=validarEntero(this.value);">&nbsp;&nbsp;<button name="CmdDividir" type="submit" class="iconbtn" title="Dividir Item"  id="'.$row['IdItemNP'].'" onClick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_self'".';return confirm('."'Dividir Item'".');"><i class="fa fa-clone iconvsmallbt iconlgray"></i></button>'; 
				}
				echo '</td></tr>';				
				$recuento=$recuento+1;
			}
			//fin marco
			echo '</table><p class="comentario" align="right">'.$recuento.' registros</p></td></tr></table>';
		}mysql_free_result($rs);	
	}
}




GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUpMH','zAltaItemRENP',0,0,0,0);
GLO_tituloypath(0,700,"Modificar.php?id=".intval($_SESSION['TxtNroEntidad'])."&Flag1=True",'AGREGAR ITEMS NP A MOV EGRESO','linksalir');
?>
<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="80"></td><td width="110"></td><td width="80"></td><td width="100"></td><td width="30"></td></tr>
<tr> <td height="18"  align="right" >Alta NP:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td align="right">Unidad:</td><td>&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  style="width:90px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivoUni("unidades","CbUnidad","Nombre","","",$conn); ?></select></td>	<td  align="right">Pedido:</td><td colspan="2">&nbsp;<input   name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"></td></tr>
<tr> <td height="18"  align="right">Art&iacute;culo:</td><td colspan="2">&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:175px" maxlength="30" onKeyDown="enterxtab(event)"></td><td  align="right">Proveedor:</td><td>&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:90px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td>	<td  align="right"></td><td align="right" colspan="2"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>
<?
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtQSTREITNP',0);GLO_Hidden('TxtId',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(1130,0);
echo 'Los <font class="comentario2">Pedidos</font> deben estar en estado <font class="comentario3">Autorizado</font><br>';
echo 'Solo mostrar&aacute; <font class="comentario3">Items de NP </font> que no se hayan asociado a ning&uacute;n Remito o Ajuste <font class="comentario2">Egreso</font><br>';
echo 'Para asociar Items al movimiento y marcarlos como <font class="comentario2">Resueltos</font> seleccione el boton <i class="fa fa-save iconvsmallsp iconlgray"></i> <font class="comentario3">Agregar</font> <br>';
echo 'Para marcar el Item como <font class="comentario2">Comprar</font>, y que se pueda tomar desde una <font class="comentario2">OC</font> haga click en <i class="fa fa-shopping-cart iconvsmallsp iconlgray"></i> <font class="comentario3">Comprar</font><br>';
echo 'Para <font class="comentario2">dividir</font> un Item debe completar las <font class="comentario3">cantidades</font> de los dos Items resultantes y hacer click en <i class="fa fa-clone iconvsmallsp iconlgray"></i>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>