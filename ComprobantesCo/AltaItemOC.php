<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -12 month"));$_SESSION['TxtFechaH']=$hoy;
}




function MostrarTabla($conn){ 
	$query=$_SESSION['TxtQCOOCIT'];$query=str_replace("\\", "", $query); 
	if ( ($query!="")){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){
			$tablaclientes='';
			if(mysql_num_rows($rs)==2000){$tablaclientes= '<p class="MuestraError" align="center">La consulta permite mostrar hasta 2000 registros</p>';}
			//guardar		
			$tablaclientes .=GLO_inittabla(1170,0,0,0);
			$tablaclientes .="<td "."height="."3"."></td></tr><tr><td class="."recuento".">Seleccione el Item y luego grabe. </td><td align="."right".">".GLO_FAButton('CmdGuardar','submit','90','self','Grabar OC','save','boton02').' '.GLO_FAButton('CmdAlmacen','submit','90','self','Almacen','stock','boton02')."</td></tr><tr><td "."height="."3"."></td></tr></table>";
			//Titulos de la tabla
			$tablaclientes .='<table width="1170" class="TableShow" id="tshow"><tr>';
			$tablaclientes .='<td width="70" class="TableShowT"> Fecha</td>';   
			$tablaclientes .='<td width="55" class="TableShowT TAR">Pedido</td>';   
			$tablaclientes .='<td width="160" class="TableShowT"> Destino</td>';  
			$tablaclientes .='<td width="55" class="TableShowT TAR"> Cantidad</td>'; 
			$tablaclientes .='<td width="30" class="TableShowT"> </td>'; 
			$tablaclientes .='<td width="410" class="TableShowT"> Art&iacute;culo o Producto</td>';   
			$tablaclientes .='<td width="80" class="TableShowT"> Obs.Item</td>'; 
			$tablaclientes .='<td width="80" class="TableShowT"> Solicitante</td>'; 
			$tablaclientes .='<td width="30" class="TableShowT TAC"><input type="checkbox" name="ChkAll" onclick="CheckMasivoColor();"></td>'; 			
			$tablaclientes .='<td width="90" class="TableShowT TAC">OC</td>'; 
			$tablaclientes .='<td width="30" class="TableShowT TAC"></td> ';
			$tablaclientes .='<td width="110" class="TableShowT">Dividir Item</td>';
			$tablaclientes .='</tr>';             
			$recuento=0;  
			while($row=mysql_fetch_array($rs)){ 
				$idNP=$row['Id'];$idItemNP=$row['IdItemNP'];
				include("Includes/zDestinoNP.php");
				//articulo,producto u observaciones
				$claseart="";
				if($row['IdArticuloItem']>0){
					$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
				}else{
					if($row['IdProd']>0){
						$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
					}else{$claseart=" TRed ";$textoart=$row['ObsItem'];$abr='';}	
				}
				//oc
				if($row['NroOC']=='0' or $row['NroOC']==''){$nrooc='';}else{$nrooc=$row['NroOC'];}
				// 
				$tablaclientes .='<tr id="'.$row['IdItemNP'].'" >'; 
				$tablaclientes .='<td class="TableShowD"> '.FormatoFecha($row['Fecha']).'</td>'; 
				$tablaclientes .='<td class="TableShowD TAR"> '.str_pad($row['Id'], 6, "0", STR_PAD_LEFT).'</td>'; 
				$tablaclientes .='<td class="TableShowD"> '.substr($destino,0,20).'</td>'; 
				$tablaclientes .='<td class="TableShowD TAR"> '.$row['CantAutoItem'].'<input name="TxtCant3['.$row['IdItemNP'].']"  type="hidden"  value="'.$row['CantAutoItem'].'"></td>'; 
				$tablaclientes .='<td class="TableShowD"> '.substr($abr,0,5).'</td>'; 
				$tablaclientes .='<td class="TableShowD'.$claseart.'" title="'.$textoart.'">'.substr($textoart,0,48).'</td>'; 
				$tablaclientes .='<td class="TableShowD" title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,10).'</td>';  
				$tablaclientes .='<td class="TableShowD"> '.substr($row['ApeS'].' '.$row['NomS'],0,8).'</td>';  
				$tablaclientes .='<td class="TableShowD TAC">'; 
				//solo adjunta si tiene articulo
				if($row['IdArticuloItem']>0 or $row['IdProd']>0){
					$tablaclientes .='<input type="checkbox" name="campos['.$idNP.'|'.$idItemNP.']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;};" onChange="CheckRow('.$row['IdItemNP'].',this.value);">'; 
				}
				$tablaclientes .='</td><td class="TableShowD TAC">';
				$tablaclientes .='<input name="TxtNroOC['.$row['IdItemNP'].']"  type="text"  style="width:70px" maxlength="10" value="'.$nrooc.'">';
				$tablaclientes .='</td><td class="TableShowD TAC">';
				//modifica todos (pedido por liliana medina)
				if($row['IdArticuloItem']>0 or $row['IdProd']>0) {
					$tablaclientes .= GLO_rowbutton("CmdCompletar",$row['IdItemNP'],"Modificar",'self','add','iconlgray','Modificar',1,0,0); 
				}

				$tablaclientes .='</td><td class="TableShowD">';
				//solo divide si tiene articulo y no tiene OC
				if( ($row['IdArticuloItem']>0 or $row['IdProd']>0) and ($row['NroOC']=='0' or $row['NroOC']=='') ){
					$tablaclientes .='&nbsp;<input name="TxtCant1['.$row['IdItemNP'].']"  type="text"  style="width:30px" maxlength="7" onChange="this.value=validarEntero(this.value);">&nbsp;&nbsp;<input name="TxtCant2['.$row['IdItemNP'].']"  type="text" style="width:30px" maxlength="7" onChange="this.value=validarEntero(this.value);">&nbsp;&nbsp;<button name="CmdDividir" type="submit" class="iconbtn" title="Dividir Item"  id="'.$row['IdItemNP'].'" onClick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_self'".';return confirm('."'Dividir Item'".');" '.GLO_mouseoverbutton($row['IdItemNP'],0).'><i class="fa fa-clone iconvsmallbt iconlgray"></i></button>'; 
				}
				$tablaclientes .='</td></tr>';
				$recuento=$recuento+1;
			}
			$tablaclientes .=GLO_fintabla(0,0,$recuento);
			echo $tablaclientes;	
		}mysql_free_result($rs);
	}	
}


//html
GLOF_Init('','BannerConMenuHV','zAltaItemOC',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,"NotasPedidoD.php",'PEDIDOS A COMPRAR','linksalir');
?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="60"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="120"></td><td width="70"></td><td width="90"></td><td width="70"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td>	<td  align="right">Art&iacute;culo:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:100px" maxlength="30" onKeyDown="enterxtab(event)"></td><td align="right">Pedido:</td><td>&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"></td><td align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQCOOCIT',0);

GLO_mensajeerror(); 
MostrarTabla($conn);
mysql_close($conn); 
GLO_cierratablaform();

GLO_initcomment(1160,0);
echo 'Los <font class="comentario2">Pedidos</font> deben estar en estado <font class="comentario3">Comprar</font>.<br>';
echo 'Para <font class="comentario2">dividir</font> un Item debe completar las <font class="comentario3">cantidades</font> de los dos Items resultantes y hacer click en <i class="fa fa-clone iconvsmallsp iconlgray"></i><br>';
echo 'Para borrar el Item como <font class="comentario2">Comprar</font>, y que se revise nuevamente, haga click en <i class="fa fa-dolly-flatbed iconvsmallsp iconlgray"></i> <font class="comentario3">Almacen</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>