<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar propios y terceros vehiculo


//generales
$_SESSION['TxtNumero']=$row['Id'];
$_SESSION['TxtNroEntidad']=str_pad($row['IdPadre'], 6, "0", STR_PAD_LEFT);//proceso
$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
$_SESSION['TxtHora']=GLO_FormatoHora($row['Hora']);
$_SESSION['TxtObs']=$row['Obs'];
$_SESSION['TxtTemp']=$row['Temp'];
$_SESSION['CbOlf']=$row['Olf'];
$_SESSION['TxtRto'] = $row['Rto'];
$_SESSION['TxtMotivo'] = $row['Mot'];
$_SESSION['CbCliente2'] = $row['IdCliP'];//cliente proceso


//si es egreso puede tener pedido
if($row['IdPedido']==0){$_SESSION['TxtNroPedido'] = '';}else{$_SESSION['TxtNroPedido'] =str_pad($row['IdPedido'], 6, "0", STR_PAD_LEFT);}

//0:ingreso,1:salida
if($row['Etapa']==0){$_SESSION['CbEtapa']=1;}else{$_SESSION['CbEtapa']=2;}


//propio
$_SESSION['CbTipo']=$row['Tipo'];
$_SESSION['CbPersonal'] = $row['IdChofer'];
$_SESSION['CbUnidad'] = $row['IdUnidad'];
$_SESSION['CbUnidad2'] = $row['IdSemi'];
$_SESSION['TxtKm'] = $row['Km'];if ($_SESSION['TxtKm']==0){$_SESSION['TxtKm'] ="";}
$_SESSION['ChkRE'] = $row['Retorno'];


//terceros
$_SESSION['CbProv'] = $row['IdProv'];		
$_SESSION['CbCliente'] = $row['IdCli'];
$_SESSION['TxtChofer'] = $row['Chofer'];
$_SESSION['TxtDoc']= $row['DNI'];
$_SESSION['TxtDocCong']= $row['DNI'];//congelado
$_SESSION['TxtSedronar'] = $row['Sedro'];
$_SESSION['CbMarca'] = $row['IdMarca'];
$_SESSION['CbCateg'] = $row['IdCateg'];
$_SESSION['TxtModelo'] = $row['Modelo'];
$_SESSION['TxtDominio'] = $row['Dominio'];
$_SESSION['TxtDominioCong'] = $row['Dominio'];
$_SESSION['CbMarca2'] = $row['IdMarca2'];
$_SESSION['CbCateg2'] = $row['IdCateg2'];
$_SESSION['TxtModelo2'] = $row['Modelo2'];
$_SESSION['TxtDominio2'] = $row['Dominio2'];
$_SESSION['TxtDominio2Cong'] = $row['Dominio2'];
$_SESSION['Chk1'] = $row['Chk1'];//Certificado de analisis
$_SESSION['Chk2'] = $row['Chk2'];//Hojas de seguridad de los productos
//habilitaciones
$_SESSION['ChkU1'] = $row['ChkU1'];$_SESSION['ChkU2'] = $row['ChkU2'];$_SESSION['ChkU3'] = $row['ChkU3'];
$_SESSION['ChkS1'] = $row['ChkS1'];$_SESSION['ChkS2'] = $row['ChkS2'];$_SESSION['ChkS3'] = $row['ChkS3'];
$_SESSION['ChkC1'] = $row['ChkC1'];$_SESSION['ChkC2'] = $row['ChkC2'];
$_SESSION['TxtFechaU1'] =GLO_FormatoFecha($row['FU1']);$_SESSION['TxtFechaU2'] =GLO_FormatoFecha($row['FU2']);
$_SESSION['TxtFechaU3'] =GLO_FormatoFecha($row['FU3']);
$_SESSION['TxtFechaS1'] =GLO_FormatoFecha($row['FS1']);$_SESSION['TxtFechaS2'] =GLO_FormatoFecha($row['FS2']);
$_SESSION['TxtFechaS3'] =GLO_FormatoFecha($row['FS3']);
$_SESSION['TxtFechaC1'] =GLO_FormatoFecha($row['FC1']);$_SESSION['TxtFechaC2'] =GLO_FormatoFecha($row['FC2']);
?>