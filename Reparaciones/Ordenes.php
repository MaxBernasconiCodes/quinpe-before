<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -1 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQREPORD'];
if ( $query!=""){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1020,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Orden</td>";  
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> F.Orden</td>";  
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Ingreso</td>";  
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Egreso</td>";   
		$tablaclientes .="<td "."width="."140"." class="."TableShowT".">Unidad </td>";   
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Sector</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Equipo</td>"; 
		$tablaclientes .="<td "."width="."190"." class="."TableShowT".">Accion Orden</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"." > Estado Orden</td>";  
		$tablaclientes .="<td "."colspan="."2"." class="."TableShowT"." >Solicitud</td>";  
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"." > </td>";  
		$tablaclientes .='</tr>';    
		$recuento=0; $clase="TableShowD";         
		$estilo=" style='cursor:pointer;' ";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='ModificarOrden.php?Flag1=True&id=".$row['Id']."'";
			$accion=TraerAccionOrden($row['Id'],$conn);
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaI'])."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaE'])."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Uni'].' '.$row['Dominio'],0,15)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,12)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Instr'],0,12)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($accion,0,24)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Estado'],0,12)."</td>"; 
			$tablaclientes .="<td width="."50"." class=".$clase.$link." style='text-align:right;'> ".GLO_SinCeroSTRPAD($row['IdSoli'],6)."</td>"; 
			$tablaclientes .="<td width="."50"." class=".$clase.$link.REP_colorestsoli($row['IdEstadoSoli'])."> ".substr($row['EstadoSoli'],0,5)."</td>"; 
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0). "</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	mysql_free_result($rs);
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}

GLOF_Init('TxtNroInterno','BannerConMenuHV','zOrdenes',0,'MenuH',0,0,0);
GLO_tituloypath(0,750,'Solicitudes.php','ORDENES MANTENIMIENTO','linksalir');
?>

<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="60" ></td><td width="100"></td><td width="120"></td><td width="60"></td><td width="100"></td><td width="80"></td><td width="100"></td><td width="130"></td></tr>
<tr><td  align="right" >Fecha:</td><td>&nbsp;<input name="TxtFechaD"  id="TxtFechaD" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaD']; ?>"   ><?php  calendario("TxtFechaD","../Codigo/","actual"); ?></td><td>al&nbsp;&nbsp;<input name="TxtFechaH"  id="TxtFechaH" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaH']; ?>"   ><?php  calendario("TxtFechaH","../Codigo/","actual"); ?></td><td align="right">Unidad:</td><td>&nbsp;<select name="CbUnidad" style="width:80px" class="campos" id="CbUnidad" ><? echo '<option value=""></option>';GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?> </select></td><td  align="right" >Sector:</td><td>&nbsp;<select name="CbSector" style="width:80px" class="campos" id="CbSector" > <? echo '<option value=""></option>';ComboTablaRFX("sectorm","CbSector","Nombre","","",$conn);?> </select></td><td>Estado:&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:70px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("pedidosrepord_est","CbEstado","Orden","","",$conn); ?></select></td></tr>
<tr><td  align="right" >Orden:</td><td >&nbsp;<input  name="TxtNroOR" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroOR'];?>" onChange="this.value=validarEntero(this.value);" style="width:65px"></td><td><input name="ChkSSoli"  type="checkbox"  value="1" <? if ($_SESSION['ChkSSoli'] =='1') echo 'checked'; ?>> Sin Solicitud</td><td  align="right" >Equipo:</td><td>&nbsp;<select name="CbInstrumento" class="campos" id="CbInstrumento"  style="width:80px" onKeyDown="enterxtab(event)"><? echo '<option value=""></option>';GLO_ComboEquipos("CbInstrumento","epparticulos",$conn); ?></select></td>
<td  align="right" ></td><td >&nbsp;</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>




<? 
GLO_linkbutton(750,'Agregar','AltaOrden.php','','','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQREPORD',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Para eliminar una <font class="comentario2">Orden</font> debe desvincular la <font class="comentario3">Solicitud</font> de la lista desplegable<br>';
echo 'Para eliminar una <font class="comentario2">Orden</font> debe borrar las <font class="comentario3">Acciones</font>registradas <br>';
echo 'Al filtrar por <font class="comentario2">Unidad</font> busca por <font class="comentario3">Numero</font> y <font class="comentario3">Nombre</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>