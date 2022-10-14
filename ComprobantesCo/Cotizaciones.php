<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if (empty($_SESSION['TxtFechaDCOCOT'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaDCOCOT']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION['TxtFechaHCOCOT']=$hoy;
}




function MostrarTabla($conn){
$query=$_SESSION['TxtQuery17'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(700,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Alta</td>";   
		$tablaclientes .="<td "."width="."450"." class="."TableShowT"."> Proveedor</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Estado</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;'";$_SESSION['TxtOriCOCOT']=0;//para que vuelva a esta pgina 
		$clase="TableShowD";	
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ModificarCotizacion.php?Flag1=True&id=".$row['Id']."'";
			//estado
			$colorest='';
			if($row['IdEstado']==3){$colorest=' style="font-weight:bold;color:#4CAF50"';}//verde
			if($row['IdEstado']==4){$colorest=' style="font-weight:bold;color:#f44336"';}//rojo
			if($row['IdProv']==0){$prov=substr($row['Obs2'],0,40);}else{$prov=substr($row['Prov'],0,40);}
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".$prov."</td>";  
			$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,9)."</td>";  
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>"; 
			$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  
			$tablaclientes .="</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}

GLOF_Init('','BannerConMenuHV','zCotizaciones',0,'MenuH',0,0,0);
GLO_tituloypath(950,700,"NotasPedidoD.php",'COTIZACIONES','linksalir');
?> 



<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="130"></td><td width="80"></td><td width="100"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaDCOCOT","../Codigo/","actual",1) ?></td>
     <td> al&nbsp;<? GLO_calendario("TxtFechaHCOCOT","../Codigo/","actual",1) ?></td><td  align="right">Estado:</td><td >&nbsp;<select name="CbEstado" style="width:100px" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("co_pcotiz_est","CbEstado","Id","","",$conn); ?> </select></td><td  align="right">Cotizacion:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td></tr>
<tr> <td height="18"  align="right">Proveedor:</td><td   colspan="2">&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td><td  align="right"></td><td >&nbsp;</td><td  colspan="2" align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>



<!--Boton agregar y tabla-->
<table  width="700" border="0" cellspacing="0" cellpadding="0"  align="center">
<tr><td  height=3 width="660" ></td><td  height=3 width="40" ></td></tr>
<tr  valign="bottom"><td  valign="bottom" align="left"><input name="CmdAgregar" type="button" class="boton"   value="Agregar" onClick="document.Formulario.target='_self';window.location.href='AltaCotizacion.php'"> <input name="CmdDetalle" type="button" class="boton"   value="Detalle" onClick="document.Formulario.target='_self';window.location.href='CotizacionesD.php'"> <input  name="TxtId"  type="hidden"  value="<? echo $_SESSION['TxtId']; ?>"><input  name="TxtQuery17"  type="hidden"   value="<? echo $_SESSION['TxtQuery17']; ?>"></td><td   align="right" ></td>		</tr>
</table>

<? 
GLO_mensajeerror();
MostrarTabla($conn);
?>

<? GLO_cierratablaform(); ?>

<? mysql_close($conn);
?>
		
<!-- Comentario-->
<table  width="700" border="0" cellspacing="0" cellpadding="0" >
<tr><td class="comentario">
S&oacute;lo es posible <font class="comentario2">Eliminar</font> una Cotizaci&oacute;n si no tiene <font class="comentario3">Items</font>.
</td></tr>
</table>
<!-- fin Comentario-->


<? include ("../Codigo/FooterConUsuario.php");?>