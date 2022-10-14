<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$_SESSION['TxtNumero']=intval($_GET['Id']);//id registro
$_SESSION['TxtIdDoc']=intval($_GET['IdDoc']);//id doc



//mostrar datos
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$query="SELECT * From iso_doc_reg Where Id=".intval($_SESSION['TxtNumero']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){	$_SESSION['TxtDesA'] =$row['Descripcion'];}mysql_free_result($rs);
mysql_close($conn);

//html	  
include ("../Codigo/HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ("../Codigo/BannerPopUp.php");
echo'<form name="Formulario" action="zModificarRegistro.php" method="post" enctype="multipart/form-data">';
GLO_tituloypath(0,700,'','DOCUMENTACION','salir');
echo '<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right">Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
</table>';
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtIdDoc',0);
GLO_obsform(700,100,'Observaciones','TxtDesA',0,2);
GLO_botonesform(700,0,2);
GLO_mensajeerror();                      
GLO_cierratablaform();
GLO_initcomment(700,0);
echo 'Si <font class="comentario3">no</font> selecciona <font class="comentario2">Archivo</font>, grabar&aacute; la <font class="comentario2">Descripci&oacute;n</font> y mantendr&aacute; el <font class="comentario3">Archivo</font> anterior';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>