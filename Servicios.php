<? include("Codigo/Seguridad.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Servicios/Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if( empty($_SESSION['ChkActivo']) ){$_SESSION['ChkActivo']=1;}



GLOF_Init('','BannerConMenuHV','Servicios/zServicios',0,'Servicios/MenuH',0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','SERVICIOS','linksalir');
?> 

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td width="120"></td><td width="70"></td><td width="140"></td><td width="90"></td><td width="120"></td><td  width="100"></td></tr>
<tr><td  align="right" >Cliente:</td><td>&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td  align="right" >Linea A:</td><td>&nbsp;<select name="CbServicio" class="campos" id="CbServicio"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("serviciostipo1","CbServicio","Nombre","","",$conn); ?></select></td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Activos</td><td><input name="Chk1"  type="checkbox"  value="1" <? if ($_SESSION['Chk1'] =='1') echo 'checked'; ?>> Vista Detallada</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>	</tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQSERV',0);GLO_Hidden('TxtQSERV2',0);
GLO_linkbutton(700,'Agregar','Servicios/Alta.php','','','','');
GLO_mensajeerror();

//tipo vista
if(intval($_SESSION['Chk1'])==0){SERV_MostrarTabla($conn);}else{SERV_MostrarTabla2($conn);}

GLO_cierratablaform(); 
mysql_close($conn); 
include ("Codigo/FooterConUsuario.php");
?>