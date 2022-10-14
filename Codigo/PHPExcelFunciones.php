<? include("Seguridad.php");


function PHPExcel_letracol($idcol){//A=0
	$l='';
	switch ($idcol) {
	case 0:	$l='A';break;
	case 1:	$l='B';break;
	case 2:	$l='C';break;
	case 3:	$l='D';break;
	case 4: $l='E';break;
	case 5:	$l='F';break;
	case 6:	$l='G';break;
	case 7:	$l='H';break;
	case 8:	$l='I';break;
	case 9:	$l='J';break;
	case 10: $l='K';break;
	case 11: $l='L';break;
	case 12: $l='M';break;
	case 13: $l='N';break;
	case 14: $l='O';break;
	case 15: $l='P';break;
	case 16: $l='Q';break;
	case 17: $l='R';break;
	case 18: $l='S';break;
	case 19: $l='T';break;
	case 20: $l='U';break;
	case 21: $l='V';break;
	case 22: $l='W';break;
	case 23: $l='X';break;
	case 24: $l='Y';break;
	case 25: $l='Z';break;
	case 26: $l='AA';break;
	case 27: $l='AB';break;
	case 28: $l='AC';break;
	case 29: $l='AD';break;
	case 30: $l='AE';break;	
	case 31: $l='AF';break;	
	case 32: $l='AG';break;	
	case 33: $l='AH';break;	
	case 34: $l='AI';break;	
	case 35: $l='AJ';break;	
	case 36: $l='AK';break;	
	case 37: $l='AL';break;	
	case 38: $l='AM';break;	
	case 39: $l='AN';break;	
	case 40: $l='AO';break;	
	}
	return $l;
}

?>