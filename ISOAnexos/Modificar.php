<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT d.*  From iso_anexos d where d.Id<>0 and d.Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']= str_pad($row['Id'], 5, "0", STR_PAD_LEFT); 
		$_SESSION['TxtNombre']= $row['Nombre']; 
		$_SESSION['TxtArchivo']= $row['Ruta']; 
		$_SESSION['CbOrigen']= $row['Origen'];
		$_SESSION['CbSector']= $row['IdSector'];
	}mysql_free_result($rs);
	
} 
?> 

<? GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerConMenuHV','zModificar',0,0,0,0); ?>

<? include("Includes/zCampos.php");?>

<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="5"></td></tr></table>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="80" height="5"  ></td> <td width="620"></td></tr>
<tr> <td height="18"  align="right">Archivo:</td><td>&nbsp;<input name="TxtArchivo" type="hidden" value="<? echo $_SESSION['TxtArchivo']; ?>">&nbsp; 
<? //examinar: (si es perf.coord/admin )
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
echo '<input name="CmdArchivo" type="submit" class="botonexplorar" title="Agregar" value=" " onClick="document.Formulario.target='."'_self'".'">';}
//ver archivo: 
 if ( !(empty($_SESSION['TxtArchivo']))){echo ' <input name="CmdVerFile" type="submit" class="botonlupa" title="Ver" value=" " onClick="document.Formulario.target='."'_blank'".'">';}
 ?>
</td></tr>
</table>


    

<? 
GLO_Hidden('TxtId',0);

//guardar cambios : si es perf.coord/admin 
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
GLO_botonesform("700",0,2);}else{GLO_botonesform("700",1,2);}


GLO_mensajeerror(); 
GLO_cierratablaform(); 
mysql_close($conn); 
?>

<? include ("../Codigo/FooterConUsuario.php");?>