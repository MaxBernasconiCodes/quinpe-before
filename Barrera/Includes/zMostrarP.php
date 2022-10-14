<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar propios y terceros persona

//generales
$_SESSION['TxtNumero']=$row['Id'];
$_SESSION['TxtNroEntidad']=$row['IdPadre'];//proceso
$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
$_SESSION['TxtHora']=GLO_FormatoHora($row['Hora']);
$_SESSION['TxtObs']=$row['Obs'];
$_SESSION['TxtTemp']=$row['Temp'];
$_SESSION['CbOlf']=$row['Olf'];


//0:ingreso,1:salida
if($row['Etapa']==0){$_SESSION['CbEtapa']=1;}else{$_SESSION['CbEtapa']=2;}

//propio
$_SESSION['CbTipo']=$row['Tipo'];
$_SESSION['CbPersonal'] = $row['IdChofer'];

//terceros
$_SESSION['CbProv'] = $row['IdProv'];		
$_SESSION['CbCliente'] = $row['IdCli'];
$_SESSION['TxtChofer'] = $row['Chofer'];
$_SESSION['TxtDoc']= $row['DNI'];
$_SESSION['TxtDocCong']= $row['DNI'];//congelado
?>