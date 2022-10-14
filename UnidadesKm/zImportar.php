<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);

function obtenerformatohora($var){
	if($var==''){$var='00:00';}
	else{
		list($h,$m)=explode(":",$var);
		$h=str_pad($h, 2, "0", STR_PAD_LEFT);$m=str_pad($m, 2, "0", STR_PAD_LEFT);
		$var=$h.':'.$m;
	}
return $var;
}

if(isset($_POST['CmdAceptar'])) {
	//importo
	$nograbo=0;$cant=0;
	//valida fecha
	if( !(empty($_POST['TxtFecha1'])) ){
		// validate to check uploaded file is a valid csv file
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		//si es csv
		if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){	
			//si lo subio
			if(is_uploaded_file($_FILES['file']['tmp_name'])){
				$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
				$csv_file = fopen($_FILES['file']['tmp_name'], 'r');
				//fecha
				$fecha=GLO_FechaMySql($_POST['TxtFecha1']);
				//importa los datos de ese periodo
				// get data records from csv file(defino delimitador de campos ;)
				$fila=0;
				while(($csv_record = fgetcsv($csv_file,0,";")) !== FALSE){
					if($fila!=0){//si no es titulo
						$grabook=0;
						//obtengo datos de la linea del csv
						$dom=mysql_real_escape_string($csv_record[0]);
						$km=floatval(str_replace(',','.',$csv_record[1]));
						$hm=obtenerformatohora($csv_record[2]);
						$hr=obtenerformatohora($csv_record[3]);
						//grabo	
						$nroId=GLO_generoID('unidadeskm',$conn);
						$query="INSERT INTO unidadeskm (Id,Fecha,Dominio,Km,Hm,Hr) VALUES ($nroId,'$fecha','$dom',$km,'$hm','$hr')"; 
						$rs=mysql_query($query,$conn);
						if($rs){$cant++;$grabook=1;}
						//registro nro si no se graba
						if($grabook==0){$nograbo++;	}
					}
					$fila++;
				}
				//fin imortacion
				fclose($csv_file);
				mysql_close($conn); 
				$_SESSION['GLO_msgC']='Se grabaron '.$cant.' Dominios';	
				if($nograbo!=''){$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'No se grabaron: '.$nograbo.' Dominios';}						
			}
		}else{$_SESSION['GLO_msgE']='Por favor seleccione un archivo CSV';}
	}else{$_SESSION['GLO_msgE']='Por favor complete la Fecha';}
	//vuelvo
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Importar.php");
} 


if (isset($_POST['CmdManualIntra'])){
	GLO_OpenPDF('Manual/MANTImportarRSV.pdf',0);
}



?>