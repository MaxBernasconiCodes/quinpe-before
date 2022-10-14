<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['id'],0,0);
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT p.*,u.Nombre as Tipo,pp.Nombre as NomP,pp.Apellido as ApP From personal_des p,personal_destipo u,personal pp where p.Id<>0 and p.IdEntidad=pp.Id and p.IdTipo=u.Id and p.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA'] = FormatoFecha($row['Fecha']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['CbTipo'] = $row['IdTipo'];
		$_SESSION['CbPersonal'] = $row['IdPersonal'];
		$_SESSION['TxtObs'] = $row['Obs'];
	}mysql_free_result($rs);
}

?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.forms['Formulario']['TxtApellido'].focus()">
<? include ("../Codigo/BannerPopUp.php");?>

<form name="Formulario" action="zModificarDes.php" method="post" onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}">
<? GLO_tituloypath(0,600,'','DESEMPE&Ntilde;O','salir'); ?>
<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="150"></td><td width="350"></td></tr>
<tr><td height="18"  align="right"  >Fecha:</td><td  valign="top"  colspan="2">&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      ><label class="MuestraError"> * </label><?php  calendario("TxtFechaA","../Codigo/","actual"); ?></td></tr>
<tr><td height="18"  align="right"  >Novedad:</td><td  valign="top" colspan="2">&nbsp;<select name="CbTipo" style="width:300px"  tabindex="1" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("personal_destipo","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label> </td></tr>
<tr> <td height="18"  align="right" >Observador:</td><td  valign="top" colspan="2">&nbsp;<select name="CbPersonal"  style="width:300px" class="campos" id="CbPersonal" ><option value=""></option> <? ComboPersonalRFX("CbPersonal",$conn); ?> </select></td></tr>
</table>

<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(600,100,'Observaciones','TxtObs',2,0);
GLO_botonesform("600",0,2); ?>
<?php GLO_mensajeerror(); ?>        
           
<? GLO_cierratablaform(); ?>	
<? mysql_close($conn); 
$_SESSION['TxtNumero'] ="";
$_SESSION['TxtNroEntidad'] ="";
$_SESSION['TxtFechaA'] ="";
$_SESSION['TxtObs']="";
$_SESSION['CbPersonal'] ="";
$_SESSION['CbTipo'] = "";
?>			
				

<? include ("../Codigo/FooterConUsuario.php");?>