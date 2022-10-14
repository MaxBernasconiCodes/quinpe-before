<? include("Codigo/Seguridad.php") ; include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$query="SELECT * From noticias";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtNumero']=1;
	$_SESSION['TxtTitulo'] = $row['Titulo'];
	$_SESSION['TxtSTitulo'] = $row['Subtitulo'];
	$_SESSION['TxtTexto'] = $row['Texto'];
	$_SESSION['ChkUrg'] = $row['Urgente'];
	$_SESSION['TxtFoto'] = $row['Ruta'];
}mysql_free_result($rs);
mysql_close($conn);


GLOF_Init('TxtTitulo','BannerConMenuHV','MiEmpresa/zNoticias',0,'',0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','NOTICIAS','linksalir');
?> 

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Titulo:</td><td valign="top" >&nbsp;<input name="TxtTitulo" type="text" class="TextBox" style="width:350px" maxlength="40"  value="<? echo $_SESSION['TxtTitulo']; ?>"></td></tr>
<tr><td height="18"  align="right"  >Subtitulo:</td><td valign="top" >&nbsp;<input name="TxtSTitulo" maxlength="40" type="text" class="TextBox" value="<? echo $_SESSION['TxtSTitulo']; ?>" style="width:350px<?php if($_SESSION['ChkUrg']==1){echo ';color:#f44336;font-weight:bold;"';} ?>" >&nbsp;<input name="ChkUrg"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkUrg'] =='1') echo 'checked'; ?>>Urgente</td></tr>
</table>

<? GLO_obsform(700,100,'Texto','TxtTexto',10,0);?>

<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Imagen:</td><td valign="top" >&nbsp;
<? 
GLO_Hidden('TxtFoto',0);
if (intval($_SESSION['TxtNumero'])!=0){echo GLO_FAButton('CmdArchivo','submit','','self','Explorar','folder','iconbtn').'&nbsp;&nbsp;';}
if (intval($_SESSION['TxtNumero'])!=0 and !(empty($_SESSION['TxtFoto']))){echo GLO_FAButton('CmdVerFoto','submit','','blank','Ver','lupa','iconbtn').' &nbsp; '.GLO_FAButton('CmdBorrarFoto','submit','','self','Borrar','trash','iconbtn');}
?> 
</td></tr>
</table>


<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform("700",0,2);
GLO_mensajeerror();
GLO_cierratablaform(); 

GLO_initcomment(700,0);
echo 'Las <font class="comentario3">Noticias</font> se mostrar&aacute;n en la p&aacute;gina inicial de la <font class="comentario2">Intranet</font> en reemplazo del mensaje de bienvenida<br>';
echo 'Las que tengan seleccionado <font class="comentario2">Urgente</font> mostrar&aacute;n el <font class="comentario3">Subt&iacute;tulo</font> en color <font class="comentario3">rojo</font>';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>