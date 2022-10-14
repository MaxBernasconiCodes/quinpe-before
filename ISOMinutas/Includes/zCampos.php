<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



GLO_tituloypath(0,750,'../ISO_Minutas.php','MINUTA DE REUNION','linksalir');

?>





<link rel="STYLESHEET" type="text/css" href="../../CSS/Estilo.css" >

<table width="750" border="0"   cellspacing="0"  class="Tabla">

<tr><td width="70" height="3" ></td><td width="110" ></td><td width="140" ></td><td width="130" ></td><td width="100" ></td><td width="150" ></td></tr>

<tr> <td  align="right" height="18">Fecha:</td><td >&nbsp;<? GLO_calendario("TxtFecha","../Codigo/","actual",1) ?></td><td>&nbsp;<input name="TxtHora1"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  value="<? echo $_SESSION['TxtHora1']; ?>" onChange="this.value=validarHora(this.value);" tabindex="1"><label class="MuestraError"> * </label></td><td ></td><td align="right"></td><td ></td></tr>

<tr> <td  align="right" height="18">Tema:</td><td  colspan="5">&nbsp;<input name="TxtNombre" type="text" class="TextBox"   tabindex="1"  style="width:600px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" > <label class="MuestraError"> * </label></td></tr>

</table>



<?

GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform("750",0,2); 

if(intval($_SESSION['TxtNumero'])!=0){GLO_exportarform(750,1,0,0,0,0);}

GLO_mensajeerror();

?>