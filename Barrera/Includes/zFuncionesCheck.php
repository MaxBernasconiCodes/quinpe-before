<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


function BAR_checkpropios($i){
	$res='';
	switch ($i) {
		case 1:	$res='Luces Altas';break;
		case 2:	$res='      Bajas';break;
		case 3:	$res='      Posicion';break;
		case 4:	$res='      Giro';break;
		case 5:	$res='      Freno';break;	
		case 6:	$res='      Balizas';break;	
		case 7:	$res='      Tablero';break;
		case 8:	$res='      Adicionales';break;
		case 9:	$res='Bocina';break;
		case 10:$res='Limpiaparabrisas';break;
		case 11:$res='Lavaparabrisas';break;
		case 12:$res='Calefactor desempañador';break;
		case 13:$res='Velocimetro';break;
		case 14:$res='Parabrisas';break;
		case 15:$res='Cierre de puertas';break;	
		case 16:$res='Ventanillas';break;	
		case 17:$res='Espejos retrovisores';break;
		case 18:$res='Frenos';break;
		case 19:$res='Freno de mano';break;
		case 20:$res='Amortiguadores';break;
		case 21:$res='Ca&ntilde;o de escape';break;
		case 22:$res='Arrestallamas';break;
		case 23:$res='Cubiertas camion';break;
		case 24:$res='Ruedas de auxilio';break;
		case 25:$res='Balizas reglamentarias';break;	
		case 26:$res='Barra de remolque';break;	
		case 27:$res='Linterna';break;
		case 28:$res='Asientos';break;
		case 29:$res='Apoyacabezas';break;
		case 30:$res='Cinturones de seguridad';break;
		case 31:$res='Crique';break;
		case 32:$res='Herramientas';break;
		case 33:$res='Dep. y sist. dist. de comb.';break;
		case 34:$res='Instalacion electrica gral.';break;
		case 35:$res='Bandeja colectora';break;	
		case 36:$res='Estado y aspecto general';break;	
		case 37:$res='Cisterna';break;
		case 38:$res='Cubiertas semi';break;
		case 39:$res='Piso de carga';break;
		case 40:$res='Perno de enganche';break;
		case 41:$res='Verificar perdida de fluidos';break;
		case 42:$res='Verificar nivel de aceite';break;
		case 43:$res='Verificar nivel de agua';break;
		case 44:$res='Verificar nivel liq. de frenos';break;
		case 45:$res='Verificar nivel dir. hidraulica';break;	
		case 46:$res='Verificar presion de neum.';break;	
		case 47:$res='Verificar ultimo mant.';break;
		case 48:$res='Certificaciones';break;
		case 49:$res='Objetos de cabina';break;
		case 50:$res='Documentacion';break;
		case 51:$res='Tarjeta verde';break;
		case 52:$res='Recibo patente';break;
		case 53:$res='Tarjeta de seguro';break;
		case 54:$res='Licencia de conductor';break;
		case 55:$res='Permiso de circulacion';break;	
		case 56:$res='Bomba';break;	
		case 57:$res='Mangueras';break;
		case 58:$res='Carteleria';break;
		case 59:$res='Matafuegos';break;
		case 60:$res='Conos';break;
		case 61:$res='Manga de viento';break;
		case 62:$res='Pala';break;
		case 63:$res='Disco tacografo';break;
		case 64:$res='Botiquin';break;
		case 65:$res='Cinta de marcacion';break;	
		case 66:$res='Absorvente';break;	
		case 67:$res='Cu&ntilde;as';break;
		case 68:$res='Ducha emergencia';break;
	}
	return $res;
}	



function BAR_checkterceros($i){
	$res='';
	switch ($i) {
	case 1:	$res='Estado general de la carga';break;
	case 2:	$res='La se&ntilde;alizaci&oacute;n se corresponde con la carga';break;
	case 3:	$res='La carga est&aacute; bien protegida, tapas y/o v&aacute;lvulas precintadas';break;
	case 4:	$res='La carga palletizada est&aacute; asegurada con fajas';break;
	case 5:	$res='La carga y la se&ntilde;alizaci&oacute;n coincide con el remito';break;	
	case 6:	$res='Est&aacute;n los elementos de seguridad para actuar en caso de un incidente';break;	
	}
	return $res;
}


?>