<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,840,'','ACCIDENTE/ENFERMEDAD','salir');
GLO_mensajeerror(); 
?>



<table width="840" border="0"  cellspacing="0"><tr> <td  class="encabezado">DATOS DEL LESIONADO</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="130"></td></tr>
<tr> <td align="right"  >Apellido y Nombre:</td><td>&nbsp;<input  name="TxtNombre" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNombre'];?>" style="width:270px"></td><td align="right"  >Nro.Denuncia:</td><td>&nbsp;<input name="TxtNro" type="text"  tabindex="1" class="TextBox"  maxlength="10"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtNro']; ?>" /></td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Telefono:</td><td>&nbsp;<input  name="TxtTel" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtTel'];?>" style="width:270px"></td><td align="right"  >Legajo:</td><td>&nbsp;<input  name="TxtLegajo" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtLegajo'];?>" style="width:65px"></td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Domicilio:</td><td>&nbsp;<input  name="TxtDir2" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtDir2'];?>" style="width:270px"></td><td align="right"  >DNI:</td><td>&nbsp;<input  name="TxtDNI" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtDNI'];?>" style="width:100px"></td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Localidad:</td><td>&nbsp;<input  name="TxtLocalidad2" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtLocalidad2'];?>" style="width:270px"></td><td align="right"  >Provincia:</td><td colspan="3">&nbsp;<input name="TxtProvincia2" type="text"  class="TextBoxRO" style="width:250px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia2']; ?>">&nbsp;<input name="TxtCP2" type="text"  class="TextBoxRO" style="width:55px"  readonly="true" value="<? echo $_SESSION['TxtCP2']; ?>"></td></tr>
</table>

<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="130"></td></tr>
<tr> <td align="right"  >Sector:</td><td>&nbsp;<input  name="TxtSector" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtSector'];?>" style="width:270px"></td><td align="right"  ></td><td colspan="3">&nbsp;</td></tr>
<tr> <td align="right"  >Funcion:</td><td>&nbsp;<input  name="TxtPuesto" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPuesto'];?>" style="width:270px"></td><td align="right"  >Categoria:</td><td colspan="3">&nbsp;<input name="TxtCat" type="text"  class="TextBoxRO" style="width:310px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtCat']; ?>"></td></tr>
<tr> <td align="right"  >Tiempo Exper.:</td><td>&nbsp;<input name="TxtTpoE" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" value="<? echo $_SESSION['TxtTpoE']; ?>" ></td><td align="right"  >Tiempo Puesto:</td><td>&nbsp;<input name="TxtTpoP" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" value="<? echo $_SESSION['TxtTpoP']; ?>" ></td><td align="right"  ></td><td>&nbsp;</td></tr>
</table>



<table width="840" border="0"  cellspacing="0" class="TMT2"><tr> <td  class="encabezado">DATOS DEL LUGAR DONDE OCURRIO EL ACCIDENTE/DIAGNOSTICO EP</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="130"></td></tr>
<tr> <td align="right"  >Fecha:</td><td>&nbsp;<input name="TxtFecha"  type="text"  readonly="true"  class="TextBoxRO" style="width:65px"  value="<? echo $_SESSION['TxtFecha']; ?>" tabindex="1">&nbsp;<input name="TxtHora"  type="text"  readonly="true"  class="TextBoxRO" style="width:50px"  value="<? echo $_SESSION['TxtHora']; ?>" tabindex="1"></td><td align="right"  >Lugar:</td><td colspan="3">&nbsp;<input name="TxtLugar" type="text"  class="TextBoxRO" style="width:310px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtLugar']; ?>"></td></tr>
<tr> <td align="right"  >Direccion:</td><td colspan="5">&nbsp;<input name="TxtDir" type="text"  tabindex="1" class="TextBox"  maxlength="100"  style="width:710px" value="<? echo $_SESSION['TxtDir']; ?>" ></td></tr>
<tr> <td align="right"  >Localidad:</td><td>&nbsp;<select name="CbLocalidad" style="width:270px"  tabindex="1" class="campos" id="CbLocalidad" onChange="this.form.submit()" ><option value=""></option> <? ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn); ?> </select></td><td align="right"  >Provincia:</td><td colspan="3">&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:250px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp;<input name="TxtCP" type="text"  class="TextBoxRO" style="width:55px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"></td></tr>
</table>


<table width="840" border="0"  cellspacing="0" class="TMT2"><tr> <td  class="encabezado">DESCRIPCION DEL ACCIDENTE O ENFERMEDAD PROFESIONAL Y SUS CONSECUENCIAS</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="130"></td></tr>
<tr> <td align="right"  >Lesion:</td><td colspan="5">&nbsp;<input name="TxtObs1" type="text"  tabindex="1" class="TextBox"  maxlength="100"  style="width:710px" value="<? echo $_SESSION['TxtObs1']; ?>" ></td></tr>
<tr> <td align="right"  >Primeros Auxilios:</td><td colspan="5">&nbsp;<input name="TxtObs2" type="text"  tabindex="1" class="TextBox"  maxlength="100"  style="width:710px" value="<? echo $_SESSION['TxtObs2']; ?>" ></td></tr>
<tr> <td align="right"  >Atencion Medica:</td><td colspan="5">&nbsp;<input name="TxtObs3" type="text"  tabindex="1" class="TextBox"  maxlength="100"  style="width:710px" value="<? echo $_SESSION['TxtObs3']; ?>" ></td></tr>

<tr> <td align="right"  >Turno en Horas:</td><td>&nbsp;<input  name="TxtTurno" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtTurno'];?>" style="width:100px"></td><td align="right"  >Hs.Trabajadas:</td><td>&nbsp;<input name="TxtHs" type="text"  tabindex="1" class="TextBox"  maxlength="6"  style="width:50px" value="<? echo $_SESSION['TxtHs']; ?>"  onchange="this.value=validarNumero(this.value);"></td><td align="right"  >Foto escena:</td><td>&nbsp;<input name="TxtFoto"  type="hidden"  value="<? echo $_SESSION['TxtFoto']; ?>" />&nbsp; <? if (($_SESSION['TxtNumero']!="" and $_SESSION['TxtNumero']!="0") ){echo '<input name="CmdArchivo" type="submit" class="botonexplorar" title="Agregar" value=" " onClick="document.Formulario.target='."'_self'".'">&nbsp;&nbsp;';	}	if ($_SESSION['TxtNumero']!="" and $_SESSION['TxtNumero']!="0" and !(empty($_SESSION['TxtFoto']))){echo '<input name="CmdVerFoto" type="submit" class="botonlupa" title="Ver Foto" value=" " onClick="document.Formulario.target='."'_blank'".'"> &nbsp; '.GLO_FAButton('CmdBorrarFoto','submit','','self','Borrar','trash','iconbtn');}?></td></tr>
<tr> <td align="right"  >Diagrama:</td><td>&nbsp;<input  name="TxtDiag" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtDiag'];?>" style="width:100px"></td><td align="right"  >Dias Trabajados:</td><td>&nbsp;<input name="TxtDias" type="text"  tabindex="1" class="TextBox"  maxlength="3"  style="width:50px" value="<? echo $_SESSION['TxtDias']; ?>"  onchange="this.value=validarEntero(this.value);"></td><td align="right"  ></td><td>&nbsp;</td></tr>
</table>


<table width="840" border="0"  cellspacing="0" class="TMT2"><tr> <td  class="encabezado">TESTIGOS</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="230">&nbsp;Nombre y Apellido:</td> <td width="230">&nbsp;Empleador:</td><td width="230">&nbsp;Cargo:</td><td width="150">&nbsp;Telefono:</td></tr>
<tr> <td>&nbsp;<input  name="TxtTN1" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTN1'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTE1" type="text"  class="TextBox"  maxlength="50"   value="<? echo $_SESSION['TxtTE1'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTC1" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTC1'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTT1" type="text"  class="TextBox"  maxlength="30"  value="<? echo $_SESSION['TxtTT1'];?>" style="width:130px"></td></tr>
<tr> <td>&nbsp;<input  name="TxtTN2" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTN2'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTE2" type="text"  class="TextBox"  maxlength="50"   value="<? echo $_SESSION['TxtTE2'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTC2" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTC2'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTT2" type="text"  class="TextBox"  maxlength="30"  value="<? echo $_SESSION['TxtTT2'];?>" style="width:130px"></td></tr>
<tr> <td>&nbsp;<input  name="TxtTN3" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTN3'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTE3" type="text"  class="TextBox"  maxlength="50"   value="<? echo $_SESSION['TxtTE3'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTC3" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTC3'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTT3" type="text"  class="TextBox"  maxlength="30"  value="<? echo $_SESSION['TxtTT3'];?>" style="width:130px"></td></tr>
<tr> <td>&nbsp;<input  name="TxtTN4" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTN4'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTE4" type="text"  class="TextBox"  maxlength="50"   value="<? echo $_SESSION['TxtTE4'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTC4" type="text"  class="TextBox"  maxlength="50"  value="<? echo $_SESSION['TxtTC4'];?>" style="width:200px"></td><td>&nbsp;<input  name="TxtTT4" type="text"  class="TextBox"  maxlength="30"  value="<? echo $_SESSION['TxtTT4'];?>" style="width:130px"></td></tr>
</table>



<table width="840" border="0"  cellspacing="0" class="TMT2"><tr> <td  class="encabezado">TIPO DE ACCIDENTE</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="210" height="3"  ></td> <td width="210"></td><td width="210"></td><td width="210"></td></tr>
<tr><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="1"<? if ($_SESSION['OptTipo']==1) echo 'checked'; ?> > Golpeado por</td><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="2"<? if ($_SESSION['OptTipo']==2) echo 'checked'; ?> > Caida mismo nivel</td><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="3"<? if ($_SESSION['OptTipo']==3) echo 'checked'; ?> > Contacto electrico</td><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="8"<? if ($_SESSION['OptTipo']==8) echo 'checked'; ?> > Otros</td></tr>
<tr><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="5"<? if ($_SESSION['OptTipo']==5) echo 'checked'; ?> > Golpeado contra</td><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="6"<? if ($_SESSION['OptTipo']==6) echo 'checked'; ?> > Caida distinto nivel</td><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="7"<? if ($_SESSION['OptTipo']==7) echo 'checked'; ?> > Contacto quimico</td><td></td></tr>
<tr><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="9"<? if ($_SESSION['OptTipo']==9) echo 'checked'; ?> > Atrapado entre</td><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="10"<? if ($_SESSION['OptTipo']==10) echo 'checked'; ?> > Sobresfuerzo</td><td>&nbsp;<input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"   value="11"<? if ($_SESSION['OptTipo']==11) echo 'checked'; ?> > Llama o calor</td><td>&nbsp;</td></tr>
</table>



<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_guardar("840",1,0);
GLO_mensajeerror(); 
?>