<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

$_SESSION['TxtNumero']= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
$_SESSION['TxtNroEntidad']=$row['IdPadre'];//Solicitud
$_SESSION['CbCliente'] =$row['IdCliente'];
		
$_SESSION['TxtFechaA'] =GLO_FormatoFecha($row['Fecha']);
$_SESSION['TxtHora']=GLO_FormatoHora($row['Hora']);

$_SESSION['CbTipo'] =$row['IdTipo'];
$_SESSION['CbServicio'] =$row['IdServicio'];
//
$_SESSION['CbMedio'] =$row['Medio'];
$_SESSION['CbPersonal'] =$row['IdPersonal'];
$_SESSION['TxtFechaB'] =GLO_FormatoFecha($row['FechaEP']);
$_SESSION['TxtHora2']=GLO_FormatoHora($row['HoraEP']);
$_SESSION['TxtContacto'] =$row['Contacto'];
$_SESSION['TxtCliente'] =$row['CliFinal'];
$_SESSION['TxtUbic'] =$row['Loc'];
//
$_SESSION['TxtRto']=GLO_SinCero($row['Rto']);
//
$_SESSION['TxtObs'] =$row['Obs'];
//estado pedido/solicitud
$_SESSION['CbEstado'] =DES_asignar_estado($row['IdPadre'],$row['Id'],$conn);
//estado planta (esto es porque al escalar tuve que adaptar)
if($row['IdEstadoP']<3){$_SESSION['CbEstadoP']=0;}
if($row['IdEstadoP']>2){$_SESSION['CbEstadoP']=1;}


?>