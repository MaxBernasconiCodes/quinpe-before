<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
  

if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtFecha1']) or empty($_POST['TxtCod']) or ($_POST['TxtVs']=='') or empty($_POST['TxtNombre']) or ( empty($_POST['TxtFecha2']) and (intval($_POST["TxtIdEstado"])==2 or intval($_POST["TxtIdEstado"])>=4) ) or ( empty($_POST['TxtFecha3']) and (intval($_POST["TxtIdEstado"])==4 or intval($_POST["TxtIdEstado"])==6) )   ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}else{
		//post
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$id=intval($_POST['TxtNumero']);
		$cod=mysql_real_escape_string($_POST['TxtCod']);
		$vs=intval($_POST['TxtVs']);
		$tipo=intval($_POST['CbTipo']);
		$sec=intval($_POST['CbSector']);
		$ori=intval($_POST['CbOrigen']);
		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$com1=mysql_real_escape_string($_POST['TxtCom1']);
		$com2=mysql_real_escape_string($_POST['TxtCom2']);
		$com3=mysql_real_escape_string($_POST['TxtCom3']);			
		if (empty($_POST['TxtFecha1'])){$f1="0000-00-00";}else{$f1=FechaMySql($_POST['TxtFecha1']);}
		if (empty($_POST['TxtFecha2'])){$f2="0000-00-00";}else{$f2=FechaMySql($_POST['TxtFecha2']);}
		if (empty($_POST['TxtFecha3'])){$f3="0000-00-00";}else{$f3=FechaMySql($_POST['TxtFecha3']);}
		
		//verifica estado
		if(intval($_POST["TxtIdEstado"]==0) or intval($_POST["TxtIdEstado"]==3) ){ //0:elaborado  3:rev.control
			$query="UPDATE iso_doc set Codigo='$cod',Nombre='$nom',Version=$vs,IdSector=$sec,IdTipoDoc=$tipo,Origen=$ori,ComentCRE='$com1',ComentCON='$com2',ComentAPR='$com3',FechaCRE='$f1',FechaCON='$f2',FechaAPR='$f3' Where Id=$id"; 
		}else{
			$query="UPDATE iso_doc set Version=$vs,ComentCON='$com2',ComentAPR='$com3',FechaCRE='$f1',FechaCON='$f2',FechaAPR='$f3' Where Id=$id"; 
		}		
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);ISODOC_grabaauditoria($id,8,$conn);}else{GLO_feedback(2);} 
		mysql_close($conn); 			
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}		
}


//documento
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdVerDoc'])){
	GLO_OpenFile("iso_doc",intval($_POST['TxtNumero']),"SGIDoc/","Ruta");
}
elseif (isset($_POST['CmdBorrarDoc'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//busco path
	$archivo=mysql_real_escape_string($_POST['TxtArchivo']);
	//elimino
	$query="UPDATE iso_doc set Ruta='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){
		GLO_feedback(1);unlink('../Archivos/SGIDoc/'.$archivo) ;
		ISODOC_grabaauditoria(intval($_POST['TxtNumero']),9,$conn);
	}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//estados
elseif (isset($_POST['CmdElaborado'])){//abre obsoleto
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);	
	$query="UPDATE iso_doc set IdEstado=0 Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);	
	if ($rs){ISODOC_grabaauditoria(intval($_POST['TxtNumero']),19,$conn);}
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST['CmdAbrir'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));$estado=1;
	$com1=mysql_real_escape_string($_POST['TxtCom1']);
	//abre
	$query="UPDATE iso_doc set ComentCRE='$com1',IdEstado=$estado Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){ISODOC_grabaauditoria($id,4,$conn);}
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdControl'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));$estado=2;
	$com2=mysql_real_escape_string($_POST['TxtCom2']);
	// marca controlado
	if (empty($_POST['TxtFecha2'])){$query="UPDATE iso_doc set FechaCON='$fecha',ComentCON='$com2',IdEstado=$estado Where Id=$id";
	}else{$query="UPDATE iso_doc set ComentCON='$com2',IdEstado=$estado Where Id=$id";}	
	$rs=mysql_query($query,$conn);	
	if ($rs){ISODOC_grabaauditoria($id,2,$conn);}
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdRControl'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));$estado=3;
	$com2=mysql_real_escape_string($_POST['TxtCom2']);
	//corregir (control)
	$query="UPDATE iso_doc set ComentCON='$com2',IdEstado=$estado Where Id=$id"; $rs=mysql_query($query,$conn);
	if ($rs){ISODOC_grabaauditoria($id,3,$conn);}
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdAprobar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));$estado=4;$flagrev=intval($_POST['TxtFR']);
	$com3=mysql_real_escape_string($_POST['TxtCom3']);
	//aprobar
	if (empty($_POST['TxtFecha3'])){$query="UPDATE iso_doc set FechaAPR='$fecha',ComentAPR='$com3', IdEstado=$estado Where Id=$id";
	}else{$query="UPDATE iso_doc set ComentAPR='$com3',IdEstado=$estado Where Id=$id";}
	
	$rs=mysql_query($query,$conn);	
	if ($rs){
		//si es revision marca anterior vs obsoleto
		if($flagrev!=0){$query="UPDATE iso_doc set FechaEXP='$fecha', IdEstado=6 Where Id=$flagrev";$rs=mysql_query($query,$conn);}
		ISODOC_grabaauditoria($id,5,$conn);		
	}	
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}



elseif (isset($_POST['CmdRAprobar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));$estado=5;
	$com3=mysql_real_escape_string($_POST['TxtCom3']);
	//corregir
	$query="UPDATE iso_doc set ComentAPR='$com3',IdEstado=$estado Where Id=$id"; $rs=mysql_query($query,$conn);
	if ($rs){ISODOC_grabaauditoria($id,6,$conn);}	
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdBaja'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE iso_doc set FechaEXP='$fecha', IdEstado=6 Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){ISODOC_grabaauditoria($id,15,$conn);	}	
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}




//otros botones
elseif (isset($_POST['CmdVersiones'])){
	//pasa el campo FlagOrigen(id documento version original - padre de todas las versiones de un doc)
	header("Location:Versiones.php?Id=".intval($_POST['TxtFO']));
}

elseif (isset($_POST['CmdAuditoria'])){
	header("Location:Auditoria.php?Id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdNuevo'])){//revisi&oacute;n version
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
	header("Location:Revision.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}



//copias
elseif (isset($_POST['CmdAddC'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaCopia.php?Id=".intval($_POST['TxtNumero']));
}



//otra documentacion
elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaRegistro.php?Id=".intval($_POST['TxtNumero']));//Id: id doc
}
elseif (isset($_POST['CmdActReg'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarRegistro.php?Id=".intval($_POST['TxtId'])."&IdDoc=".intval($_POST['TxtNumero']));//Id: id registro
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtId']);$iddoc=intval($_POST['TxtNumero']);
	//busco path
	$query="SELECT Ruta From iso_doc_reg Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From iso_doc_reg Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){
		unlink('../Archivos/SGIDoc/Registros/'.$archivo) ;
		ISODOC_grabaauditoria($iddoc,11,$conn);
	}	
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

elseif (isset($_POST['CmdVerFile'])){	
	GLO_OpenFile("iso_doc_reg",intval($_POST['TxtId']),"SGIDoc/Registros/","Ruta");
}





//evidencias
elseif (isset($_POST['CmdAddAEVI'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaEvidencia.php?Id=".intval($_POST['TxtNumero']));//Id: id doc
}
elseif (isset($_POST['CmdActRegEVI'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarEvidencia.php?Id=".intval($_POST['TxtId'])."&IdDoc=".intval($_POST['TxtNumero']));//Id: id registro
}
elseif (isset($_POST['CmdBorrarFilaAEVI'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtId']);$iddoc=intval($_POST['TxtNumero']);
	//busco path
	$query="SELECT Ruta From iso_doc_evi Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From iso_doc_evi Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){
		unlink('../Archivos/SGIDoc/Evidencias/'.$archivo) ;
		ISODOC_grabaauditoria($iddoc,17,$conn);
	}	
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

elseif (isset($_POST['CmdVerFileEVI'])){	
	GLO_OpenFile("iso_doc_evi",intval($_POST['TxtId']),"SGIDoc/Evidencias/","Ruta");
}










elseif (isset($_POST['CmdResumen'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Select d.*,t.Nombre as Tipo,e.Nombre as Estado,s.Nombre as Sector,r.Nombre as Req,r.Nro as NReq,p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2,p3.Nombre as N3,p3.Apellido as A3,pr.Apellido as RSProv From iso_doc d,iso_doc_tipo t,iso_doc_estados e,sector s,iso_nc_req r,personal p1,personal p2,personal p3,proveedores pr Where t.Id=d.IdTipoDoc and e.Id=d.IdEstado and s.Id=d.IdSector and  r.Id=d.IdReq and p1.Id=d.IdPersCRE and pr.Id=d.IdProvCRE and p2.Id=d.IdPersCON and p3.Id=d.IdPersAPR and d.Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){	
		$id=$row['Id'];
		$nrodoc=str_pad($row['Id'], 5, "0", STR_PAD_LEFT);	
		$backgr='#FFFF99';//amarillo
		if($row['FechaCRE']!='0000-00-00'){$fecha1 =FormatoFecha($row['FechaCRE']);}else{$fecha1='';}
		if($row['FechaCON']!='0000-00-00'){$fecha2 =FormatoFecha($row['FechaCON']);}else{$fecha2='';}
		if($row['FechaAPR']!='0000-00-00'){$fecha3 =FormatoFecha($row['FechaAPR']);}else{$fecha3='';}
		if($row['FechaEXP']!='0000-00-00'){$fecha4 =FormatoFecha($row['FechaEXP']);}else{$fecha4='';}
		$ori='';if($row['Origen']==1){$ori='Externo';}if($row['Origen']==2){$ori='Interno';}
		//Titulos excel
		include("../Codigo/ExcelHeader.php");	
		echo "<table border=0 ".'style="font-size:10px"'.">\n ";
		echo '<tr><td colspan="4" align="center" style="background:'.$backgr.'">'."<strong>DOCUMENTO ".$nrodoc."</strong><td></tr>\n </table>\n";
		//blanco			
		echo "<table border=0 >\n <tr><td> </td>\n<td> </td>\n</tr>\n </table>\n";
		//generales
		echo "<table border=1 ".'style="font-size:10px"'.">\n";
		echo '<tr> <th colspan="4" align="center" style="background:#FFCC00">'."Propiedades</th>\n </tr>\n";
		echo '<tr><th align="left">'."C&oacute;digo</th>\n".'<td align="left" colspan="3">'.$row['Codigo']."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Versi&oacute;n</th>\n".'<td align="left" colspan="3">'.$row['Version']."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Nombre</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['Nombre'])."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Estado</th>\n".'<td align="left" colspan="3">'.$row['Estado']."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Tipo</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['Tipo'])."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Sector</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['Sector'])."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Origen</th>\n".'<td align="left" colspan="3">'.$ori."</td>\n</tr>\n";	
		echo '<tr><th align="left">'."Expiraci&oacute;n</th>\n".'<td align="left" colspan="3">'.$fecha4."</td>\n</tr>\n";			
		echo "</table>\n";	
		//blanco			
		echo "<table border=0 >\n <tr><td> </td>\n<td> </td>\n</tr>\n </table>\n";	
		//creacion
		echo "<table border=1 ".'style="font-size:10px"'.">\n";
		echo '<tr> <th colspan="4" align="center" style="background:#FFCC00">'."Creaci&oacute;n</th>\n </tr>\n";
		echo '<tr><th align="left">'."Personal</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['A1'].' '.$row['N1'])."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Proveedor</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['RSProv'])."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Fecha</th>\n".'<td align="left" colspan="3">'.$fecha1."</td>\n</tr>\n";
		echo '<tr><th align="left" valign="top">'."Comentario</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['ComentCRE'])."</td>\n</tr>\n";
		echo "</table>\n";	
		//blanco			
		echo "<table border=0 >\n <tr><td> </td>\n<td> </td>\n</tr>\n </table>\n";	
		//control
		echo "<table border=1 ".'style="font-size:10px"'.">\n";
		echo '<tr> <th colspan="4" align="center" style="background:#FFCC00">'."Control</th>\n </tr>\n";
		echo '<tr><th align="left">'."Responsable</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['A2'].' '.$row['N2'])."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Fecha</th>\n".'<td align="left" colspan="3">'.$fecha2."</td>\n</tr>\n";
		echo '<tr><th align="left" valign="top">'."Comentario</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['ComentCON'])."</td>\n</tr>\n";
		echo "</table>\n";	
		//blanco			
		echo "<table border=0 >\n <tr><td> </td>\n<td> </td>\n</tr>\n </table>\n";	
		//aprob
		echo "<table border=1 ".'style="font-size:10px"'.">\n";
		echo '<tr> <th colspan="4" align="center" style="background:#FFCC00">'."Aprobaci&oacute;n</th>\n </tr>\n";
		echo '<tr><th align="left">'."Responsable</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['A3'].' '.$row['N3'])."</td>\n</tr>\n";
		echo '<tr><th align="left">'."Fecha</th>\n".'<td align="left" colspan="3">'.$fecha3."</td>\n</tr>\n";
		echo '<tr><th align="left" valign="top">'."Comentario</th>\n".'<td align="left" colspan="3">'.GLO_textoExcel($row['ComentAPR'])."</td>\n</tr>\n";
		echo "</table>\n";	
	
		//blanco			
		echo "<table border=0 >\n <tr><td> </td>\n<td> </td>\n</tr>\n </table>\n";	
	
		//registros
		echo "<table border=1 ".'style="font-size:10px"'.">\n";
		echo '<tr> <th colspan="4" align="center" style="background:#FFCC00">'."Registros</th>\n </tr>\n";
		echo "<tr>\n";
		echo '<th align="center" style="background:#C0C0C0">'."Archivo</th>\n".'<th align="center" style="background:#C0C0C0" colspan="2">'."Descripci&oacute;n</th>\n".'<th align="center" style="background:#C0C0C0">'."Actualizaci&oacute;n</th>\n";
		echo "</tr>\n";
	$query2="SELECT r.* From iso_doc_reg r where r.IdDoc=$id Order by r.Id";
		$rs2=mysql_query($query2,$conn);	
		while($row2=mysql_fetch_array($rs2)){ 
			$fult = FormatoFecha($row2['FechaU']);if ($fult=='00-00-0000'){$fult="";}
			echo "<tr>\n";
			echo '<td align="left">'.$row2['Id']."</td>\n".'<td align="left" colspan="2">'.GLO_textoExcel($row2['Descripcion'])."</td>\n".'<td align="left">'.$fult."</td>\n";			
			echo "</tr>\n";				
		}mysql_free_result($rs2);
		echo "</table>\n";	
	

		//blanco			
		echo "<table border=0 >\n <tr><td> </td>\n<td> </td>\n</tr>\n </table>\n";	
	
		//copias
		echo "<table border=1 ".'style="font-size:10px"'.">\n";
		echo '<tr> <th colspan="4" align="center" style="background:#FFCC00">'."Copias</th>\n </tr>\n";
		echo "<tr>\n";
		echo '<th align="center" style="background:#C0C0C0">'."Cantidad</th>\n".'<th align="center" style="background:#C0C0C0">'."Entregada</th>\n".'<th align="center" style="background:#C0C0C0">'."Retirada</th>\n";
		echo "</tr>\n";
		$query2="SELECT d.* From iso_doc_copias d where d.IdDoc=$id Order by d.FechaB,c.Nombre";
		$rs2=mysql_query($query2,$conn);	
		while($row2=mysql_fetch_array($rs2)){ 
			$falta = FormatoFecha($row2['FechaA']);if ($falta=='00-00-0000'){$falta="";}
			$fbaja= FormatoFecha($row2['FechaB']);if ($fbaja=='00-00-0000'){$fbaja="";}			
			echo "<tr>\n";
			echo '<td align="left">'.$row2['Cantidad']."</td>\n".'<td align="left">'.$falta."</td>\n".'<td align="left">'.$fbaja."</td>\n";			
			echo "</tr>\n";				
		}mysql_free_result($rs2);
		echo "</table>\n";	


		//Cierra tabla excel
		echo "</table>\n";				
	}	
		mysql_free_result($rs);	mysql_close($conn); 
}
?>