<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From unidadesmedida where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtNombre'] = $row['Nombre'];
	$_SESSION['TxtApellido'] = $row['Abr'];
}mysql_free_result($rs);


//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerConMenuHV','zModificar',0,0,0,0);
GLO_tituloypath(0,500,'../UnidadesMed.php','UNIDADES','linksalir');  
?> 


<table width="500" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="3"  ></td> <td width="400"></td> </tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:250px" maxlength="20" tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"><label class="MuestraError"> * </label> </td></tr>
<tr><td height="18"  align="right"  >Abreviatura:</td><td  valign="top" >&nbsp;<input name="TxtApellido" type="text" class="TextBox" style="width:40px" maxlength="3" tabindex="1" value="<? echo $_SESSION['TxtApellido']; ?>"><label class="MuestraError"> * </label></td></tr>
</table>	

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform(500,0,2);
GLO_mensajeerror();   
mysql_close($conn);   
GLO_cierratablaform();	             
include ("../Codigo/FooterConUsuario.php");
?>