<? //perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,600,'Consulta.php','METODOS DE PRUEBA','linksalir');
?>
<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td>&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:350px" maxlength="50"  tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" /><label class="MuestraError"> * </label></td></tr>
</table>


<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_botonesform("600",0,2); 
GLO_mensajeerror();
?>
