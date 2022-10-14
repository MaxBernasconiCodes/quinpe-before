<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

include ("../Codigo/HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="'.'../CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ("../Codigo/BannerPopUp.php");
echo'<form name="Formulario" action="" method="post" enctype="multipart/form-data">';
GLO_tituloypath(0,500,'','ARCHIVO','salir');
echo '<table width="500" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="3"  ></td> <td width="400"></td> </tr>
<tr> <td height="18"  align="right"  >Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
</table>';
GLO_Hidden('TxtNumero',0);
GLO_botonesform(500,0,2);
GLO_cierratablaform();
GLO_initcomment(500,0);
echo 'Seleccione un <font class="comentario2">Archivo</font> y grabe los cambios';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>