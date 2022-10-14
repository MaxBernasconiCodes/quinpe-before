<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>

<!-- documento -->
<table width="725" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="2" >&nbsp;<strong>Documento:</strong></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Nombre:</td><td  valign="top"  colspan="3"> &nbsp; <input name="TxtNombre" type="text" <? if(($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14)  or ($_SESSION['TxtIdEstado']!=0 and $_SESSION['TxtIdEstado']!=3)){echo'readonly="true" class="TextBoxRO"';}else{echo'class="TextBox"';} ?> style="width:600px" maxlength="200"  value="<? echo $_SESSION['TxtNombre']; ?>"> <label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Archivo:</td><td> &nbsp; <input name="TxtArchivo" type="hidden"  value="<? echo $_SESSION['TxtArchivo']; ?>" >&nbsp; 

<? 
//examinar: (si es perf.coord/admin y estado 0,3 )
//admin examina siempre (Felix Aun 202011)
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or (((($_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or  $_SESSION["IdPerfilUser"]==5 or  $_SESSION["IdPerfilUser"]==6 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14)) and ($_SESSION['TxtIdEstado']==0 or $_SESSION['TxtIdEstado']==3)))){
    echo GLO_FAButton('CmdArchivo','submit','','self','Explorar','folder','iconbtn').' &nbsp; ';
}

//ver archivo:
//si es obsoleto(6) solo usuario  perfil admin
//todos los estados si es perf.coord/perf.admin/contr/apr, y los demas solo aprobado(4)
if ((($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["GLO_IdPersLog"]==$_SESSION["TxtIdPers2"] or $_SESSION["GLO_IdPersLog"]==$_SESSION["TxtIdPers3"]  or $_SESSION['TxtIdEstado']==4 ) and $_SESSION['TxtIdEstado']!=6) or ($_SESSION['TxtIdEstado']==6 and ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2))){
 if ( !(empty($_SESSION['TxtArchivo']))){echo GLO_FAButton('CmdVerDoc','submit','','blank','Ver','lupa','iconbtn');}
 }
 

 //borrar: (si es perf.coord/admin y estado 0:elaborado o 3:rev.control )
if (((($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or  $_SESSION["IdPerfilUser"]==5 or  $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==10)) and ($_SESSION['TxtIdEstado']==0 or $_SESSION['TxtIdEstado']==3))){
    if ( !(empty($_SESSION['TxtArchivo']))){echo ' &nbsp; '.GLO_FAButton('CmdBorrarDoc','submit','','self','Borrar','trash','iconbtn');}
}

 ?> 
 </td><td align="right"  ></td><td>&nbsp;  </td></tr>
</table>
