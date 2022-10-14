<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";include("../Articulos/Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQSTOCKDEP'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1000,1,0,0);
		$tablaclientes .="<td "."width="."120"." class="."TableShowT"."> Dep&oacute;sito</td>";  
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Propietario</td>";  
		$tablaclientes .="<td "."width="."440"." class="."TableShowT"."> Articulo o Producto</td>";   
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Marca</td>";   
		$tablaclientes .="<td "."width="."120"." class="."TableShowT"."> Modelo</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"." style='text-align:right;'> Stock</td>"; 
		$tablaclientes .="<td "."width="."40"." class="."TableShowT"." > Unid.</td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;  $suma=0;
		$estilo=" style='cursor:pointer;' ";$clase="TableShowD";        
		while($row=mysql_fetch_array($rs)){ 
			//articulo,producto u observaciones
			if($row['Id']>0){//articulo
				$textoart=str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.$row['Nombre'];	$abr=$row['Abr'];
				$link=' onClick="window.open('."'StockDepositoH.php?Id=".$row['Id']."&IdP=".$row['IdCliente']."&IdD=".$row['IdDeposito']."'".');"';
			}else{//producto
				$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
				$link=' onClick="window.open('."'StockDepositoHLAB.php?Id=".$row['IdProd']."&IdP=".$row['IdCliente']."&IdD=".$row['IdDeposito']."'".');"';
			}
			
			//pasa id articulo
			$suma=$suma+$row['Stock'];
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['IdST']).'>'; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Dep'],0,15)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cliente'],0,12)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link.' title="'.$textoart.'">'.substr($textoart,0,50)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Marca'],0,12)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Modelo'],0,15)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$row['Stock']."</td>"; 
			$tablaclientes .="<td class=".$clase.$link." > ".$abr."</td>"; 
			$tablaclientes .='</tr>'; 
			$recuento++;
		}mysql_free_result($rs);	
		$tablaclientes .=GLO_fintablaConSuma(1,0,$recuento,$suma,'total');
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}

GLOF_Init('TxtBusqueda','BannerConMenuHV','zStockDeposito',0,'MenuH',0,0,0); 
GLO_tituloypath(0,650,'../Stock.php','STOCK POR DEPOSITO','linksalir');
?>

<table width="650" border="0" cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td  width="180"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="130"></td><td width="30"></td></tr>
<tr><td  align="right" >Art&iacute;culo:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:160px" maxlength="30" onKeyDown="enterxtab(event)"></td><td  align="right" >Tipo:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  tabindex="1"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ART_CbTipo('CbTipo'); ?></select></td><td align="right">Dep&oacute;sito:</td><td>&nbsp;<select name="CbDeposito" class="campos" id="CbDeposito"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("depositos","CbDeposito","Nombre","","",$conn); ?></select></td><td></td></tr>

<tr><td  align="right" >Propietario:</td><td>&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:160px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td  align="right" >Rubro:</td><td>&nbsp;<select name="CbRubro" class="campos" id="CbRubro"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("rubros","CbRubro","Nombre","","",$conn); ?></select></td><td align="right"></td><td><input name="ChkVer"  type="checkbox"  value="1" <? if ($_SESSION['ChkVer'] =='1') echo 'checked'; ?>>Ver items stock 0</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>




<? 

//ajustes en tablas solo webmaster
//if($_SESSION["IdPerfilUser"]==1){echo GLO_FAButton('CmdWM','submit','80','self','WMaster','','boton02');}

GLO_Hidden('TxtQSTOCKDEP',0);
MostrarTabla($conn); 
GLO_cierratablaform(); 
mysql_close($conn);

GLO_initcomment(0,0);
echo 'La <font class="comentario3">Unidad de medida</font> es la establecida para medir el stock en el <font class="comentario2">Art&iacute;culo</font> o <font class="comentario2">Producto</font><br>';
echo 'Muestra el stock total por <font class="comentario2">Deposito</font> y <font class="comentario2">Propietario</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>