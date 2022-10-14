<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Despacho/zFunciones.php");
include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//3:salida. 5:formulado+carga+salida, 6:carga+salida
if ($_GET['Flag1']=="True"){
	$query="SELECT * From despacho where Id<>0 and IdTipo IN (3,5,6,7) and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){	include("../Despacho/Includes/zMostrar.php");}mysql_free_result($rs);
}

GLO_ValidaSESSION($_SESSION['TxtNumero'],0,$conn);
	
DES_Estado($_SESSION['CbEstado'],$colorrow,$colorfield,$estado);$_SESSION['TxtEstado'] =$estado;


function TablaEgresos($idpadre,$conn){
	$idpadre=intval($idpadre);
	$query="SELECT a1.Id,a1.Fecha,a1.Hora,a1.Tipo From procesosop_e1 a1 where a1.IdPedido=$idpadre Order by a1.Id";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .='<table width="670" border="0" cellspacing="0" cellpadding="0" class="TMT20"><tr>';
		//titulos y boton
		$tablaclientes .='<td class="recuento" width="400"><label class="TBold">Barrera Egreso</label> <label>Salida de Unidades</label></td><td width="200" align="right"></td></tr></table>';
		//
		$tablaclientes .='<table width="200" class="TableShow TMT" id="tshow"><tr>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Hora</td>";  
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Tipo</td>"; 
		$tablaclientes .='</tr>';  
		$estilo=" style='cursor:pointer;'";
		while($row=mysql_fetch_array($rs)){
			$link=" onclick="."location='ModificarVehiculo.php?Flag1=True&id=".$row['Id']."'";
			$_SESSION['TxtOriOPEBar']=1;//para que vuelva
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoHora($row['Hora'])."</td>"; 
			$tablaclientes .='<td class="TableShowD'.'"'.$link."> ".PROC_TipoUnidad($row['Tipo'])."</td>"; 
			$tablaclientes .="</tr>";  
		}	
		$tablaclientes .="</table>";echo $tablaclientes;	
	}mysql_free_result($rs);
}


GLOF_Init('','BannerConMenuHV','zModificarPD',0,'MenuH',1,0,0); 
GLO_tituloypath(0,750,'InboxP.php','PEDIDO LOGISTICA','linksalir');

$esdespacho=2;//es barrera
include("../Despacho/Includes/zCampos.php"); 

//pasos
echo '<table width="750" border="0"  cellspacing="0" class="TMT10"><tr> <td class="comentario">1. Acepte el Pedido<br>2. Seleccione Tipo, Conductor y genere el Egreso</td></tr></table>';


//si aceptado barrera(4) genero egreso
if( (intval($_SESSION['CbEstado'])==4)){
	echo '<table width="750" border="0"  cellspacing="0" class="TablaBuscar TMT10" > 
	<tr> <td width="100" height="3"></td> <td width="200"></td><td width="300"></td><td width="150"></td></tr>
	<tr> <td height="18"  align="right"></td><td>Tipo:&nbsp;<select name="CbTipo2" class="campos" id="CbTipo2"  style="width:100px" onKeyDown="enterxtab(event)">';echo PROC_CbTipoUnidadFilter('CbTipo2');	echo '</select></td><td></td><td align="right">'.GLO_FAButton("CmdAltaEgreso",'submit','100','self','Alta Egreso','add','boton02').'&nbsp;</td></tr>
	</table>';
}

DES_TablaItems($_SESSION['TxtNumero'],2,$conn,0);

include("../Despacho/Includes/zCamposTablas.php"); 



//ver egresos
echo '<table width="800" border="0" cellspacing="0" cellpadding="0" ><tr><td>';
TablaEgresos($_SESSION['TxtNumero'],$conn);
echo '</td></tr></table>';


mysql_close($conn);
GLO_cierratablaform();

GLO_initcomment(0,0);
echo 'Puede grabar <font class="comentario2">Observaciones</font> del <font class="comentario3">Pedido</font><br>';
echo 'Muestra el <font class="comentario2">Total</font> de productos si la <font class="comentario3">Unidad de Medida</font> coincide<br>';

GLO_endcomment();


include ("../Codigo/FooterConUsuario.php");
?>