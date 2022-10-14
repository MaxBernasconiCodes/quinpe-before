<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");

GLO_InitHTML($_SESSION["NivelArbol"],'','BannerInicio','Intranet/zIntranet',0,0,0,0);
?> 

<table width="100%"  style="width:57rem;"  border="0" cellspacing="0" cellpadding="0">
<tr> <td style="width:40rem; height:1rem"></td> <td style="width:17rem;"></td></tr>
<tr > 
<!--centro -->
<td valign="top">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr><td><? include("IncludesNG/zInicioIntra.php");?></td></tr>
<tr><td style="height:0.5rem"></td></tr>
</table>
</td>
<!--derecha -->
<td valign="top" >
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<? 
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==11){
    //ADMINISTRACION
    echo '<tr><td valign="top" align="center"><input name="CmdSisAdmin"  type="submit" class="botoninicio"  value="COMPRAS Y ALMACENES" onClick="'."document.Formulario.target='_self'".'">&nbsp;&nbsp;</td></tr><tr><td height="1"></td></tr>';
}

//INDICADORES
echo '<tr><td valign="top" align="center"><input name="CmdSisInd"  type="submit" class="botoninicio"  value="INDICADORES" onClick="'."document.Formulario.target='_self'".'">&nbsp;&nbsp;</td></tr><tr><td height="1"></td></tr>';


if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==11){
    //MANTENIMIENTO
    echo '<tr><td valign="top" align="center"><input name="CmdSisMante"  type="submit" class="botoninicio"  value="MANTENIMIENTO" onClick="'."document.Formulario.target='_self'".'">&nbsp;&nbsp;</td></tr><tr><td height="1"></td></tr>';
}


//OPERACIONES
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9  or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==16 ){
    echo '<tr><td valign="top" align="center"><input name="CmdSisOpe"  type="submit" class="botoninicio"  value="OPERACIONES" onClick="'."document.Formulario.target='_self'".'">&nbsp;&nbsp;</td></tr><tr><td height="1"></td></tr>';
}

//RRHH
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==11 ){
    echo '<tr><td valign="top" align="center"><input name="CmdSisRRHH"  type="submit" class="botoninicio"  value="RRHH" onClick="'."document.Formulario.target='_self'".'">&nbsp;&nbsp;</td></tr><tr><td height="1"></td></tr>';
}  

//SGI (10/15 son SGI externo)
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==10 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==15 ){
    echo '<tr><td valign="top" align="center"><input name="CmdSisCertif"  type="submit" class="botoninicio"  value="SGI" onClick="'."document.Formulario.target='_self'".'">&nbsp;&nbsp;</td></tr><tr><td height="1"></td></tr>';
}

//SMA
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
    echo '<tr><td valign="top" align="center"><input name="CmdSisSHT"  type="submit" class="botoninicio"  value="SMA" onClick="'."document.Formulario.target='_self'".'">&nbsp;&nbsp;</td></tr><tr><td height="1"></td></tr>';
}

?>          
</table>
<? 
GLO_cierratablaform(); 
include ("Codigo/FooterConUsuario.php");
?>