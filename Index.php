<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Intranet</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="STYLESHEET" type="text/css" href="CSS/Estilo.css" >
<link rel="STYLESHEET" type="text/css" href="CSS/fontawesome/css/all.css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0"  marginheight="0" onLoad="document.forms['Formulario']['TxtUsuario'].focus()">

<!--banner-->
<table  height="100%" width="100%"  cellpadding="0"  cellspacing="0" border="0" align="center">
<tr> <td  class="bannerLOGOINDEX" > </td></tr>
<tr> <td width="100%"  height="100%"  align="center" valign="top">  
<!--form--> 
<form name="Formulario" action="Codigo/Verifica_Login.php" method="post">
<table border="0" cellspacing="0" class="TablaLogin"  style="margin-top:1.4rem; width:23rem; background-color:#FFFFFF" align="center">
<tr><td style="padding-top:2.1rem;padding-bottom:0.5rem"  align="center" >&nbsp;<input name="TxtUsuario" type="text" class="TextBoxLogin" maxlength="15"  style="width:14rem;height:2rem;font-size: 1.1rem;" placeholder="Usuario" onKeyDown="enterxtab(event)" ></td></tr>
<tr> <td align="center" style="padding-bottom:0.9rem"> &nbsp;<input name="TxtPassword" type="password" maxlength="8"  style="width:14rem;height:2rem;font-size: 1.1rem;" placeholder="Contrase&ntilde;a"  class="TextBoxLogin"></td></tr>
<tr><td style="padding-bottom:1.4rem" align="center" ><input name="CmdAceptar" type="submit" class="botonlogin"  value="Iniciar sesi&oacute;n" ></td></tr>
</table>
<!--Error-->
<table width="250" border="0" cellspacing="0" cellpadding="0" >
<tr align="center"> <td align="center" class="MuestraError" > <? if (!(empty($_GET['msgE']))){echo '<i class="fas fa-exclamation-circle iconvsmallsp"></i> '.$_GET['msgE'];} ?> </td> </tr>
</table> 
</Form>
<!--fin contenedor--> 
</td></tr> 

<!--footer-->   
<tr><td class="footerUSR" style="text-align:center;"><a href="http://www.quinpe.com" target="_blank" >www.quinpe.com</a></td></tr>

<!--fin tabla-->  
</table>
</body>
</html>

<? $_SESSION['TxtUsuario'] = "";$_SESSION['TxtPassword'] = "";?>