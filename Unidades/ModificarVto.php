<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	//busco datos
	$query="SELECT p.* From unidadesvtos p where p.Id<>0  and p.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbTipo'] = $row['IdTipo'];
		$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaE']);
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['Fecha']);
		$_SESSION['ChkReq'] = $row['Req'];
	    $_SESSION['TxtArchivo'] = $row['Certif'];	
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['ChkInactivo']=  $row['Inactivo'];
	}mysql_free_result($rs);
}


?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('CbTipo',0,0); ?>
<? include ("../Codigo/BannerPopUp.php");?>
<? GLO_formform('Formulario','zModificarVto.php',1,0,0); ?>

<? include ("Includes/zCamposVtos.php");?>

<!--adjuntos-->
<table width="700" border="0"  cellpadding="0" cellspacing="0" class="fondo" >
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center"  colspan="2"><?php GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"unidadesvtos_a","700","Adjuntos/"); ?>	</td></tr>
</table>                  

<? GLO_cierratablaform(); ?>
<? mysql_close($conn);?>			

<? include ("../Codigo/FooterConUsuario.php");?>