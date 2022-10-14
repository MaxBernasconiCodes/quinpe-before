<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);



GLOF_Init('','BannerConMenuHV','zImportar',1,'MenuH',1,0,0); 
GLO_tituloypath(1,600,'Consulta.php','IMPORTAR DATOS RSV','linksalir');

echo '<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td><td width="500"></td> </tr>
<tr> <td height="18"  align="right">Fecha:</td><td  >&nbsp;';GLO_calendario("TxtFecha1","../Codigo/","actual",1);
echo '</td></tr></table>';

echo '<table width="600" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td> </tr>
<tr> <td height="18"  align="right">Archivo CSV:</td><td  valign="top" >&nbsp;<input name="file" id="file" type="file"  class="TextBox"  tabindex="1" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
</table>';

GLO_Hidden('TxtNumero',0);
GLO_guardar(600,1,0);
GLO_mensajeerror();                      
GLO_cierratablaform();

GLO_initcomment(600,0);
echo 'Haciendo click en el icono de <font class="comentario2">Ayuda</font> podra obtener los pasos a seguir para la <font class="comentario3">Importacion</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");

?>