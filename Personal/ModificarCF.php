<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['id'],0,0);
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT p.*,u.Nombre as Tipo,pp.Nombre as NomP,pp.Apellido as ApP From personal_cargas p,personal_cargastipo u,personal pp where p.Id<>0 and p.IdEntidad=pp.Id and p.IdTipo=u.Id and p.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre']=$row['Nombre'];
		$_SESSION['TxtApellido'] = $row['Apellido'];
		$_SESSION['TxtCUIT']= $row['CUIL'];
		$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaD']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaH']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
		$_SESSION['ChkGan'] = $row['IIGG'];
		$_SESSION['CbTipo'] = $row['IdTipo'];
	}mysql_free_result($rs);
}

?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.forms['Formulario']['TxtApellido'].focus()">
<? include ("../Codigo/BannerPopUp.php");?>

<form name="Formulario" action="zModificarCF.php" method="post" onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}">
<? GLO_tituloypath(0,600,'','CARGAS FAMILIARES','salir'); ?>
<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="150"></td><td width="350"></td></tr>
<tr><td height="18"  align="right"  >Apellido:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtApellido" type="text"  class="TextBox" style="width:250px" maxlength="30" tabindex="1" value="<? echo $_SESSION['TxtApellido']; ?>" onKeyUp="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:250px" maxlength="30" tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >CUIL:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtCUIT" type="text"  class="TextBox"  maxlength="13"  tabindex="1"  style="width:100px" value="<? echo $_SESSION['TxtCUIT']; ?>" /></td></tr>
<tr><td height="18"  align="right"  >Desde:</td><td  valign="top"  colspan="2">&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      ><label class="MuestraError"> * </label><?php  calendario("TxtFechaA","../Codigo/","actual"); ?></td></tr>
<tr><td height="18"  align="right"  >Hasta:</td><td  valign="top"  colspan="2">&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      >&nbsp;&nbsp;&nbsp;<?php  calendario("TxtFechaB","../Codigo/","actual"); ?></td></tr>
<tr><td height="18"  align="right"  >Deducible IIGG:</td><td  valign="top" colspan="2"><input name="ChkGan"  type="checkbox" tabindex="1"  style="vertical-align:middle" value="1" <? if ($_SESSION['ChkGan'] =='1') echo 'checked'; ?>> </td></tr>
<tr> <td height="18"  align="right" >Tipo Carga:</td><td  valign="top" colspan="2">&nbsp;<select name="CbTipo" style="width:100px"  tabindex="1" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("personal_cargastipo","CbTipo","Nombre","","",$conn); ?> </select> </td></tr>
</table>

<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform("600",0,2); ?>
<?php GLO_mensajeerror(); ?>        
           
<? GLO_cierratablaform(); ?>	
<? mysql_close($conn); 
$_SESSION['TxtNumero'] ="";
$_SESSION['TxtNroEntidad'] ="";
$_SESSION['TxtFechaA'] ="";
$_SESSION['TxtFechaB'] ="";
$_SESSION['TxtNombre']="";
$_SESSION['TxtApellido'] ="";
$_SESSION['TxtCUIT']="";
$_SESSION['ChkGan'] ="";
$_SESSION['CbTipo'] = "";
?>			
				

<? include ("../Codigo/FooterConUsuario.php");?>