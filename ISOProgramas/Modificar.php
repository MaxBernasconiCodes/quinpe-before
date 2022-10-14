<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);

//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT p.*,t.Obs as Ref From programas p,iso_tiporef t where p.Id<>0 and p.IdRef=t.Id and p.Id=".intval($_GET['id']);	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
		$_SESSION['TxtFecha'] = $row['Fecha'];
		$_SESSION['TxtNombre'] =  $row['Nombre'];
		$_SESSION['CbSector'] =  $row['IdSector'];
		$_SESSION['CbTipo'] =  $row['IdTipo'];
		$_SESSION['CbTipoR'] =  $row['IdRef'];
		$_SESSION['CbTipoE'] = $row['IdTipoE'];	 
		$_SESSION['TxtRef'] =  $row['Ref'];
		$_SESSION['TxtObs'] =  $row['Obs'];	
		$_SESSION['TxtNombre1'] =  $row['T1'];//titulo detalle
		$_SESSION['TxtNombre2'] =  $row['T2'];//titulo detalle
		$_SESSION['CbPersonal'] =  $row['IdResp'];
	}mysql_free_result($rs);
}


GLO_InitHTML($_SESSION["NivelArbol"],'TxtFecha','BannerPopUpMH','zModificar',0,0,0,0);

include("Includes/zCampos.php");

?>

<table width="700" border="0"  cellpadding="0" cellspacing="0">
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_VerTablaArchivos($_SESSION['TxtNumero'],$conn,"programas_adj","700","",'1'); ?>	</td></tr>
</table>


<?
GLO_cierratablaform(); 
mysql_close($conn); 
//limpio
for ($i=1; $i < 13; $i= $i +1) {$opt='TxtM'.$i.'P';$_SESSION[$opt]="";}
for ($i=1; $i < 13; $i= $i +1) {$opt='TxtM'.$i.'R';$_SESSION[$opt]="";}	
for ($i=1; $i < 13; $i= $i +1) {$opt='TxtM'.$i.'Q';$_SESSION[$opt]="";}	
GLO_initcomment(0,0);
echo 'Los <font class="comentario3">cumplimientos</font> se consideran para los meses <font class="comentario2">finalizados</font><br>';
echo 'Mensualmente <font class="comentario3">rojo</font> pendiente, <font class="comentario3">amarillo</font> es reprogramado, <font class="comentario3">verde</font> cumplido <br>';
echo 'Anualmente <font class="comentario3">rojo</font> es 0 a 65%, <font class="comentario3">amarillo</font> 65% a 99%, <font class="comentario3">verde</font> >= 100% de cumplimiento';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>