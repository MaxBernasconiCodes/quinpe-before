<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





function PSSA_VerTablaArchivos($idpadre,$conn,$tabla,$wt,$ruta,$butt){//GLO_TablaArchivos con botones distintos

$idpadre=intval($idpadre);

$query="SELECT a.*,t.Nombre as Tipo From pssa_archivos a,pssa_tipoarch t where a.IdTipo=t.Id and a.IdEntidad=$idpadre Order by a.Id";

$rs=mysql_query($query,$conn);

//calculos

$wd=$wt-60;$ld=($wd/100)*12;

//Titulos de la tabla

$tablaclientes="";

$tablaclientes .="<table width=".$wt." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";

$tablaclientes .="<td class="."TablaTituloLeft"."> </td>";  

$tablaclientes .="<td "."width=".$wd." class="."TablaTituloDato"."> Descripcion</td>";  

$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 

$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Tipo</td>";  

$tablaclientes .="<td class="."TablaTituloLeft"."> </td>";  

$tablaclientes .="<td width="."60"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddA'.$butt,'submit','','self','Agregar','add','iconbtn').'</td>'; 

$tablaclientes .="<td class="."TablaTituloRight"."> </td>";  

$tablaclientes .=" </tr> ";             

//Datos

while($row=mysql_fetch_array($rs)){

	$tablaclientes .=" <tr> ";  

	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  

	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Descripcion'],0,$ld)."</td>"; 

	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  

	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Tipo'],0,12)."</td>"; 

	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  

	$tablaclientes .="<td  class="."TablaDatoR"." >"; 

	$tablaclientes .=' <input name="CmdVerFile'.$butt.'" type="submit"  class="botonlupa"  value="" id="'.$row['Id'].'" onclick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_blank'".';">';  

	$tablaclientes .=' '.GLO_rowbutton("CmdBorrarFilaA".$butt,$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);  

	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  

}mysql_free_result($rs);	

$tablaclientes .="</table>";

echo $tablaclientes;	

}



function PSSA_TablaItems($idpadre,$conn){ 

$idpadre=intval($idpadre);

$query="SELECT ps.*,a.Nombre as Act,t.Nombre as Tipo,f.Nombre as Frec,r.Nombre as Resp From pssa_items ps ,pssa_act a,pssa_tipo t,pssa_frec f,pssa_resp r Where ps.IdPSSA=$idpadre and ps.IdAct=a.Id and ps.IdTipo=t.Id and ps.IdFrec=f.Id and ps.IdResp=r.Id  Order by t.Nombre,f.Nombre,a.Nombre";

$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>';

$tablaclientes .=GLO_inittabla(1160,1,0,0);

$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Tipo</td>";   

$tablaclientes .="<td "."width="."300"." class="."TableShowT"."> Actividad</td>";   

$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Frecuencia</td>"; 

$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Responsable</td>"; 

$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Equipo</td>"; 

$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> Obj</td>"; 

$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> Meta</td>"; 

for ($i=1; $i < 13; $i= $i +1) {

	$tablaclientes .="<td "."width="."20"." class="."TableShowT"."  style='text-align:center;'>".$i."</td>";   

}

$tablaclientes .="<td "."width="."180"." class="."TableShowT"."> Comentarios</td>"; 

$tablaclientes .="<td "."width="."40"." class="."TableShowT".' style="text-align:center;"'.'>'.GLO_FAButton('CmdAddD','submit','','self','Agregar','add','iconbtn').'</td>'; 

$tablaclientes .='</tr>';             

$recuento=0; 

while($row=mysql_fetch_array($rs)){ 

	$id=$row['Id'];

	//estado mes	(0,1prog,2cumpl,3atrasado)

	for ($i=1; $i < 13; $i= $i +1) {

		//limpio

		${'comboe'.$i}='';${'coloreb'.$i}='';${'colore'.$i}='';

		//construyo

		${'comboe'.$i} .='<option value=""></option>';

		if( "1" == $row['Mes'.$i]) { ${'comboe'.$i} .= " <option value="."'1'"." selected='selected'>"."PROGRAMADO"."</option>\n";}

		else{${'comboe'.$i} .= " <option value="."'1'"." >"."PROGRAMADO"."</option>\n";}

		if( "2" == $row['Mes'.$i]) { ${'comboe'.$i} .= " <option value="."'2'"." selected='selected'>"."CUMPLIDO"."</option>\n";}

		else{${'comboe'.$i} .= " <option value="."'2'"." >"."CUMPLIDO"."</option>\n";}

		if( "3" == $row['Mes'.$i]) { ${'comboe'.$i} .= " <option value="."'3'"." selected='selected'>"."ATRASADO"."</option>\n";}

		else{${'comboe'.$i} .= " <option value="."'3'"." >"."ATRASADO"."</option>\n";}

		//color

		if($row['Mes'.$i]==1){${'colore'.$i}=';font-weight:bold;color:#ffffff;background-color:#cc0099';}//violeta

		if($row['Mes'.$i]==2){${'colore'.$i}=';font-weight:bold;color:#ffffff;background-color:#4CAF50';}//verde

		if($row['Mes'.$i]==3){${'colore'.$i}=';font-weight:bold;color:#ffffff;background-color:#f44336';}//rojo

	}

			

	$tablaclientes .='<tr '.GLO_highlight($row['Id']).'>';  

	$tablaclientes .="<td class="."TableShowD"."> ".'<input type="text" readonly="true" class="TextBoxRO"  style="width:70px;border:none"  value="'.$row['Tipo'].'">'."</td>"; 

	$tablaclientes .="<td class="."TableShowD"."> ".'<input type="text" readonly="true" class="TextBoxRO"  style="width:290px;border:none"  value="'.$row['Act'].'">'."</td>"; 

	$tablaclientes .="<td class="."TableShowD"."> ".'<input type="text" readonly="true" class="TextBoxRO"  style="width:70px;border:none"  value="'.$row['Frec'].'">'."</td>"; 

	$tablaclientes .="<td class="."TableShowD"."> ".'<input type="text" readonly="true" class="TextBoxRO"  style="width:70px;border:none"  value="'.$row['Resp'].'">'."</td>";  

	$tablaclientes .="<td class="."TableShowD"."> ".'<input name="TxtCE['.$id.']" maxlength="100" type="text"  class="TextBox"  style="width:70px;"  value="'.$row['CE'].'">'."</td>"; 

	$tablaclientes .="<td class="."TableShowD"."> ".'<input name="TxtObj['.$id.']" maxlength="10" type="text"  class="TextBox"  style="width:30px;"  value="'.$row['Obj'].'" onChange="this.value=validarEntero(this.value);">'."</td>"; 

	$tablaclientes .="<td class="."TableShowD"."> ".'<input name="TxtMeta['.$id.']" maxlength="10" type="text"  class="TextBox"  style="width:30px;"  value="'.$row['Meta'].'" onChange="this.value=validarEntero(this.value);">'."</td>"; 

	//estado mes

	for ($i=1; $i < 13; $i= $i +1) {

		$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'> ".'<select name="CbE'.$i.'['.$id.']" style="width:15px'.${'colore'.$i}.'" class="campos">'.${'comboe'.$i}.' </select>'."</td>"; 

	}

	$tablaclientes .="<td class="."TableShowD"."> ".'<input name="TxtObs['.$id.']"  type="text" maxlength="200" class="TextBox"  style="width:170px;"  value="'.$row['Obs'].'">'."</td>"; 

	$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFilaD",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  

	$tablaclientes .='</tr>'; 

	$recuento=$recuento+1;

}	

//Cerrar tabla

$tablaclientes .="</table></td></tr></table> "; 

echo $tablaclientes;	

mysql_free_result($rs);

}



?>