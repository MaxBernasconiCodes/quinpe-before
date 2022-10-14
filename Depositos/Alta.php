<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerConMenuHV','zAlta',0,0,0,0);
GLO_tituloypath(0,500,'../Depositos.php','DEPOSITOS','linksalir');  
?> 

<table width="500" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="3"  ></td> <td width="400"></td> </tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:250px" maxlength="30" tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"><label class="MuestraError"> * </label> </td></tr>
<tr><td height="18"  align="right"  ></td><td  valign="top" >&nbsp;<input name="Chk1"  type="checkbox" class="check"  value="1" <? if ($_SESSION['Chk1'] =='1') echo 'checked'; ?>> Planta</td></tr>
</table>	

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform(500,0,2);
GLO_mensajeerror();   
GLO_cierratablaform();	             
include ("../Codigo/FooterConUsuario.php");


?>