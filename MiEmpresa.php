<? include("Codigo/Seguridad.php") ;   $_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From parametros";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtSMTP'] = $row['ServerSMTP'];
	$_SESSION['TxtPOP'] = $row['ServerPOP'];
	$_SESSION['TxtUsuario'] = $row['Usuario'];
	$_SESSION['TxtPass'] = $row['Password'];
	$_SESSION['TxtMailF'] = $row['MailFrom'];
	$_SESSION['TxtMailT'] = $row['MailToAlertas'];
}mysql_free_result($rs);

GLOF_Init('','BannerConMenuHV','MiEmpresa/zModificar',0,'',0,0,0); 
GLO_tituloypath(0,600,'Inicio.php','MI EMPRESA','linksalir');
?>


<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="110" height="3"  ></td> <td width="490"></td> </tr>
<td height="18" colspan="2" align="left">&nbsp;<strong>Configuraci&oacute;n de Mail:</strong></td>
<tr><td height="18"  align="right"  >Contrase&ntilde;a:</td><td  valign="top" >&nbsp;<input name="TxtPass" type="password"  class="TextBox" style="width:250px" maxlength="15"  value="<? echo $_SESSION['TxtPass']; ?>" onKeyDown="enterxtab(event)"></td></tr>
<tr><td height="18"  align="right"  >Usuario:</td><td  valign="top" >&nbsp;<input name="TxtUsuario" type="text"  class="TextBox" style="width:250px" maxlength="30"  value="<? echo $_SESSION['TxtUsuario']; ?>" onKeyDown="enterxtab(event)"></td></tr>
<tr><td height="18"  align="right"  >Servidor SMTP:</td><td  valign="top" >&nbsp;<input name="TxtSMTP" type="text"  class="TextBox" style="width:250px" maxlength="30"  value="<? echo $_SESSION['TxtSMTP']; ?>" onKeyDown="enterxtab(event)"></td></tr>
<tr><td height="18"  align="right"  >Servidor POP3:</td><td  valign="top" >&nbsp;<input name="TxtPOP" type="text"  class="TextBox" style="width:250px" maxlength="30"  value="<? echo $_SESSION['TxtPOP']; ?>" onKeyDown="enterxtab(event)"></td></tr>
</table>  
      

<table width="600" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="110" height="3"  ></td> <td width="490"></td> </tr>
<td height="18" colspan="2" align="left">&nbsp;<strong>Remitentes Mail:</strong></td>
<tr><td height="18"  align="right"  >Mail Remitente:</td><td  valign="top" >&nbsp;<input name="TxtMailF" type="text"  class="TextBox" style="width:250px" maxlength="30"  value="<? echo $_SESSION['TxtMailF']; ?>" onKeyDown="enterxtab(event)"></td></tr>
</table>  
      

<table width="600" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="110" height="3"  ></td> <td width="490"></td> </tr>
<td height="18" colspan="2" align="left">&nbsp;<strong>Destinatarios Mail:</strong></td>
<tr><td height="18"  align="right"  >Mail Administrador:</td><td  valign="top" >&nbsp;<input name="TxtMailT" type="text"  class="TextBox" style="width:450px" maxlength="150"  value="<? echo $_SESSION['TxtMailT']; ?>" onKeyDown="enterxtab(event)"></td></tr>                    
</table>


<? 
GLO_botonesform(600,0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(600,0);
echo 'Datos para el envio de <font class="comentario2">Alertas</font> y <font class="comentario2">Notificaciones</font> desde <font class="comentario3">Intranet</font>';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>