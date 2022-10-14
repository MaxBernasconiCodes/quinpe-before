<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ; include("../Codigo/Funciones.php") ;  $_SESSION["NivelArbol"]="../";include("../Usuarios/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function ComboNombreUsuario($conn){ 
	$query="SELECT Id,Apellido FROM proveedores where Id<>0 and FechaBaja='0000-00-00' Order by Apellido";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
	  if( $row['Id'] == $_SESSION['CbNombre']) {$combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'],0,40)."</option>\n";
	   }else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'],0,40)."</option>\n"; }
	 }echo $combo;mysql_free_result($rs);

}



GLOF_Init('CbNombre','BannerConMenuHV','zAlta',0,'../Usuarios/MenuH',0,0,0); 
GLO_tituloypath(0,600,'../UsuariosPR.php','USUARIOS','linksalir'); 
?> 


<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td> </tr>
<tr><td height="18"  align="right"  >Puesto:</td><td valign="top" >&nbsp;<select name="CbPuesto" class="campos" id="CbPuesto" style="width:230px" ><? USR_ComboPuesto(3);?> </select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<select name="CbNombre"  class="campos" id="CbNombre" style="width:230px"><option value=""></option> <? ComboNombreUsuario($conn);?> </select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Perfil:</td><td  valign="top" >&nbsp;<select name="CbPerfil"  class="campos" id="CbPerfil" style="width:230px"><option value=""></option> <? USR_ComboPerfil(3,$conn); ?> </select> <label class="MuestraError"> * </label></td></tr>
</table>


<table width="600" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td> </tr>
<tr><td height="18"  align="right"  >Usuario:</td><td  valign="top" >&nbsp;<input name="TxtUsuario" type="text"  class="TextBox" style="width:230px" maxlength="15" value="<? echo $_SESSION['TxtUsuario']; ?>" onKeyUp="this.value=this.value.toLowerCase()"><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Clave:</td><td  valign="top" >&nbsp;<input name="TxtClave" type="password"  class="TextBox"  style="width:230px" maxlength="8" value="<? echo $_SESSION['TxtClave']; ?>"> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Confirmar Clave:</td><td  valign="top" >&nbsp;<input name="TxtConfirmar" type="password"  class="TextBox"  style="width:230px" maxlength="8" value="<? echo $_SESSION['TxtConfirmar']; ?>"> <label class="MuestraError"> * </label></td></tr>
</table>

				
<? 
GLO_botonesform(600,0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn);	

GLO_initcomment(600,0);
echo 'La Clave debe tener 8 caracteres y contener letras y numeros<br>';
echo 'El perfil <font class="comentario3">Administrador Sistema</font> tiene acceso a todos los  <font class="comentario2">Modulos</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>