<? 
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



?>

<table width="740" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="5"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="110"></td><td width="175"></td> </tr>
<tr> <td height="18"  align="right" valign="top">Dirigido a:</td><td  valign="top" colspan="4">&nbsp;<input name="TxtDir" type="text" class="TextBox" tabindex="3" style="width:600px" maxlength="200"  value="<? echo $_SESSION['TxtDir']; ?>"> </td></tr>
<tr> <td height="18"  align="right" valign="top">Objetivos:</td><td  valign="top" colspan="4">&nbsp;<textarea name="TxtObj" style="width:600px" rows="1" class="TextBox" tabindex="3" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObj']; ?></textarea> </td></tr>
</table>
