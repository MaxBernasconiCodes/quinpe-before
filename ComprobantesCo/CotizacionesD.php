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
$query=$_SESSION['TxtQuery20'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1000,1,0,0);
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Cotizacion</td>";   
		$tablaclientes .='<td width="70" class="TableShowT"> Alta</td>';  
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Proveedor</td>"; 		
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Solicitante</td>"; 
		$tablaclientes .="<td "."width="."95"." class="."TableShowT"."> Sector</td>"; 
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Cant</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
		$tablaclientes .="<td "."width="."435"." class="."TableShowT"."> Art&iacute;culo o Producto</td>";
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'>Pedido</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Estado Cotiz</td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;' ";  $_SESSION['TxtOriCOCOT']=1;//para que vuelva a esta pagina
		$clase="TableShowD";	
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ModificarCotizacion.php?Flag1=True&id=".$row['Id']."'";
			//articulo,producto u observaciones
			$textoart='';$abr='';
			if($row['IdArticuloItem']>0){
				$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
			}
			if($row['IdProd']>0){
				$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
			}
			
			if($row['IdProv']==0){$prov=substr($row['Obs2'],0,10);}else{$prov=substr($row['Prov'],0,10);}
			//estado
			$colorest='';
			if($row['IdEstado']==3){$colorest=' style="font-weight:bold;color:#4CAF50"';}//verde
			if($row['IdEstado']==4){$colorest=' style="font-weight:bold;color:#f44336"';}//rojo
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['IdIC']).'>';
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".$prov."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['ApeS'].' '.$row['NomS'],0,10)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,9)."</td>";  
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$row['CantAutoItem']."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($abr,0,5)."</td>";  
			$tablaclientes .="<td class=".$clase.$link.' title="'.$textoart.'">'.substr($textoart,0,45)."</td>";  
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['IdNP'], 8, "0", STR_PAD_LEFT)."</td>";
			$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,9)."</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


function ComboPersonalSoliNP($conn){ 
$query="SELECT distinct p.Id,p.Nombre,p.Apellido FROM personal p,co_npedido n where p.Id<>0 and n.IdPerSoli=p.Id Order by p.Apellido, p.Nombre";
$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION['CbSoli']) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";
 }else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";}} 
echo $combo;mysql_free_result($rs);
}

function ComboPersonalAutoNP($conn){ 
$query="SELECT distinct p.Id,p.Nombre,p.Apellido FROM personal p,co_npedido n where p.Id<>0 and (n.IdPerAuto=p.Id or n.IdPerPAuto=p.Id) Order by p.Apellido, p.Nombre";
$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION['CbAuto']) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";
 }else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";}} 
echo $combo;mysql_free_result($rs);
}


function ComboPrioridad(){
$combo="";
if( "1" == $_SESSION['CbPrio']) { $combo .= " <option value="."1"." selected='selected'>"."ALTA"."</option>\n";}
else{$combo .= " <option value="."1"." >"."ALTA"."</option>\n";}
if( "2" == $_SESSION['CbPrio']) { $combo .= " <option value="."2"." selected='selected'>"."MEDIA"."</option>\n";}
else{$combo .= " <option value="."2"." >"."MEDIA"."</option>\n";}
if( "3" == $_SESSION['CbPrio']) { $combo .= " <option value="."3"." selected='selected'>"."BAJA"."</option>\n";}
else{$combo .= " <option value="."3"." >"."BAJA"."</option>\n";}
echo $combo;
}


GLOF_Init('','BannerConMenuHV','zCotizacionesD',0,'MenuH',0,0,0);
GLO_tituloypath(0,800,"Cotizaciones.php",'COTIZACIONES DETALLE','linksalir');
?> 


<table width="800" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="130"></td><td width="60"></td><td width="70"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaDCOCOT","../Codigo/","actual",1) ?></td><td> al&nbsp;<? GLO_calendario("TxtFechaHCOCOT","../Codigo/","actual",1) ?></td><td align="right">Sector:</td><td>&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td>
<td  align="right">Art&iacute;culo:</td><td >&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:100px" maxlength="30" onKeyDown="enterxtab(event)"></td><td  align="right">Cotizaci&oacute;n:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td></tr>
<tr> <td height="18"  align="right">Autorizante:</td><td   colspan="2">&nbsp;<select name="CbAuto" class="campos" id="CbAuto"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalAutoNP($conn); ?></select></td><td  align="right">Proveedor:</td><td >&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td><td  align="right">Estado:</td><td>&nbsp;<select name="CbEstado" style="width:100px" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("co_pcotiz_est","CbEstado","Id","","",$conn); ?> </select></td><td  align="right">Pedido:</td><td>&nbsp;<input  name="TxtNroPI" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPI'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td></tr>
<tr><td height="18"  align="right">Solicitante:</td><td   colspan="2">&nbsp;<select name="CbSoli" class="campos" id="CbSoli"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalSoliNP($conn); ?></select></td><td  align="right"></td><td>&nbsp;</td><td  align="right"></td><td>&nbsp;</td><td   align="right" colspan="2"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>




<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery20',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>