<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>

 <!-- grabar -->   
<table width="725" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="200" height="5"  ></td><td width="325" height="5"  ></td><td width="200" height="5"  ></td></tr>
<tr><td></td><td height="18"  align="center"  >
<?  
// si no es obsoleto
if($_SESSION['TxtIdEstado']!=6){
	//guardar cambios : si es perf.coord/admin 0/1, o con 1/5, o apr 2
	if ( (($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14)) or ($_SESSION["GLO_IdPersLog"]==$_SESSION["TxtIdPers2"] and ($_SESSION['TxtIdEstado']==1 or $_SESSION['TxtIdEstado']==5)) or ($_SESSION["GLO_IdPersLog"]==$_SESSION["TxtIdPers3"] and ($_SESSION['TxtIdEstado']==2)) ){
	echo '<input name="CmdAceptar" type="submit" class="boton"  value="Guardar" onClick="document.Formulario.target='."'_self'".'">';
	}
}
?>
</td><td align="right">

<? 
//revision de version: si es perf.coord/perf admin y si est&aacute; aprobado, y no existe ya una nueva version
if (($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14) and $_SESSION['TxtIdEstado']==4 and $_SESSION['TxtFVS']==0){
echo GLO_FAButton('CmdNuevo','submit','80','self','Nuevo','file','boton02');}
?>
&nbsp;</td></tr>
</table>


<? 
GLO_mensajeerror(); 
?>
