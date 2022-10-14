<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";require_once('Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){	
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$_SESSION['TxtFechaH']=$hoy;
}


function MostrarTabla($conn){ 
$query=$_SESSION[TxtQuery71];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(1050,0,0,0);
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Tipo</td>";   
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Movim.</td>";   
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Cantidad</td>";   
			$tablaclientes .='<td class="TablaTituloLeft"></td>';  
			$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Pendiente</td>"; 
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato".">Unid. </td>"; 
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'>Art&iacute;culo</td>"; 
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."250"." class="."TablaTituloDato"."> Descripci&oacute;n</td>"; 
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."90"." class="."TablaTituloDato"."> Marca</td>"; 
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."90"." class="."TablaTituloDato"."> Modelo</td>"; 
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato"."> Proveedor</td>";   
			$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
			$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Dep&oacute;sito</td>"; 
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> OC</td>";   
			$tablaclientes .='<td class="TablaTituloLeft"></td>';
			$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> Pedido</td>";   
			$tablaclientes .='<td class="TablaTituloRight"></td>';  
			$tablaclientes .='</tr>';    
			$recuento=0;  $estilo="";$link="";        
			//Datos
			while($row=mysql_fetch_array($rs)){ 	
				$pdte=0;$pdte=$row['CantAuto']-$row['Cantidad'];
				//muestra solo si pdte >0
				if($pdte>0){	
					if($pdte>0){$pdte=number_format($pdte,2, '.', '');}else{$pdte='';}			
					if ($row['Anulado']==0){$clase="TablaDato";}else{$clase="TablaDatoRed";}	
					if($row['IdOC']==0){$oc='';}else{$oc=str_pad($row['IdOC'], 6, "0", STR_PAD_LEFT);}
					if($row['NroNP']==0){$np='';}else{$np=str_pad($row['NroNP'], 8, "0", STR_PAD_LEFT);}
					if($row['NroOC2']==0){$nrooc='';}else{$nrooc=str_pad($row['NroOC2'], 8, "0", STR_PAD_LEFT);}
					//muestro
					$tablaclientes .='<tr '.$estilo.'>';  
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link." > ".FormatoFecha($row['Fecha'])."</td>";
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
					$tablaclientes .="<td class=".$clase.$link."> ".substr($row['TipoM'],0,10)."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";  
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$row['Cantidad']."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;font-weight:bold;color:#f44336;'> ".$pdte."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link."> ".$row['Abr']."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT)."</td>";  
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link.' title="'.$row['Articulo'].'">'.substr($row['Articulo'],0,33)."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
					$tablaclientes .="<td  class=".$clase.$link." > ".substr($row['Marca'],0,9)."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
					$tablaclientes .="<td  class=".$clase.$link." > ".substr($row['Modelo'],0,9)."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Proveedor'],0,9)."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
					$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Deposito'],0,8)."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$nrooc."</td>"; 
					$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$np."</td>"; 
					$tablaclientes .='<td class="TablaMostrarRight"></td>';  
					$tablaclientes .='</tr>'; 
					$recuento=$recuento+1;
				}
			}	
			$tablaclientes .=GLO_fintabla(1,0,$recuento);
			echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaD','BannerConMenuHV','Stock/zStockP',0,0,0,0);
include("Stock/MenuH.php");
GLO_tituloypath(1060,710,'Stock.php','PENDIENTES REMITOS INTERNOS','linksalir');
?>



<table width="710" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td  width="100"></td><td width="130"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="70"></td><td width="100"></td></tr>
<tr><td  align="right">Fecha:</td><td width="100" >&nbsp;<input name="TxtFechaD"  id="TxtFechaD" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION[TxtFechaD]; ?>"   >
<?php  calendario("TxtFechaD","Codigo/","actual"); ?>
</td><td width="140" > al&nbsp;<input name="TxtFechaH"  id="TxtFechaH" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION[TxtFechaH]; ?>"   >
<?php  calendario("TxtFechaH","Codigo/","actual"); ?>
</td><td align="right">Dep&oacute;sito:</td><td>&nbsp;<select name="CbDeposito" class="campos" id="CbDeposito"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("depositos","CbDeposito","Nombre","","",$conn); ?></select></td><td align="right">Tipo:</td><td colspan="2">&nbsp;<select name="CbTipoMS" class="campos" id="CbTipoMS"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("stock_tipomov","CbTipoMS","Nombre","","",$conn); ?></select></td></tr>
<tr><td  align="right" >Art&iacute;culo:</td><td colspan="2">&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:190px" maxlength="30" onKeyDown="enterxtab(event)"></td><td align="right">Rubro:</td><td>&nbsp;<select name="CbRubro" class="campos" id="CbRubro"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("rubros","CbRubro","Nombre","","",$conn); ?></select></td>
<td align="right">Nro.OC:</td><td>&nbsp;<input  name="TxtNroOC" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION[TxtNroOC];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td  align="right" ><? GLOF_Search('CmdBuscar',0); ?>&nbsp;</td>	</tr>
</table>



<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery71',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
?>
		
<!-- Comentario-->
<table  width="1050" border="0" cellspacing="0" cellpadding="0" >
<tr><td class="comentario">
Remitos de Ingreso con <font class="comentario2">Art&iacute;culos</font> pendientes para ingresar a <font class="comentario3">Stock</font>.
</table>
<!-- fin Comentario-->

<? include ("Codigo/FooterConUsuario.php");?>