<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	if ( (empty($_POST['TxtNombre'])) or (empty($_POST['TxtDominio'])) or (empty($_POST['TxtFechaA'])) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		$sec=intval($_POST['CbSector']); 
		$serv=intval($_POST['CbServicio']); 
		$elem=intval($_POST['CbElem']); 
		$anio=intval($_POST['TxtAnio']); 
		$dom=mysql_real_escape_string($_POST['TxtDominio']);
		$mar=intval($_POST['CbMarca']); 
		$cat=intval($_POST['CbCateg']); 
		$cond=intval($_POST['CbCond']); 
		$fabr=intval($_POST['CbFabr']); 
		$mod=mysql_real_escape_string($_POST['TxtModelo']);
		$chas=mysql_real_escape_string($_POST['TxtChasis']);
		$mot=mysql_real_escape_string($_POST['TxtMotor']);
		$prop=mysql_real_escape_string($_POST['CbProp']); 
		$alq=intval($_POST['ChkAlq']); 
		$propio=intval($_POST['ChkProp']); 
		$leas=intval($_POST['ChkLeas']); 
		$af=intval($_POST['ChkAfe']); 
		$vtovtv="0000-00-00";$vtoseg="0000-00-00";	$fatv="0000-00-00";$fati="0000-00-00";$favtv="0000-00-00";	
		$atv=0; $ati=0; $avtv=0; 
		$foto="";	
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$mart=intval($_POST['CbMarcaT']); 
		$rod=intval($_POST['CbRodado']); 
		$kmi=intval($_POST['TxtKmI']); 
		$taco=intval($_POST['ChkTaco']); 
		$ntaco=mysql_real_escape_string($_POST['TxtTaco']); 
		$cub=intval($_POST['TxtCub']); 
		$psa=intval($_POST['CbPSA']); 
		$pst=intval($_POST['CbPST']); 
		$psrcc=intval($_POST['CbPSRCC']); 
		$ipsa=intval($_POST['TxtPSA']); 
		$ipst=intval($_POST['TxtPST']); 
		$ipsrcc=intval($_POST['TxtPSRCC']); 	
		$costo=GLO_GrabarImporte($_POST['TxtPrecio']);
		$costor=GLO_GrabarImporte($_POST['TxtPrecioR']);
		$mes=intval($_POST['TxtMes']); 
		$fadq=intval($_POST['CbFAdq']); 
		//generoid
		$query="SELECT Max(Id) as UltimoId FROM unidades";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
		//query
		$query="INSERT INTO unidades (Id,Nombre,FechaAlta,FechaBaja,IdElemento,Anio,Dominio,IdMarca,IdCateg,IdCond,IdFabr,Modelo,Titular,Alquilado,Afectado,Foto,Obs,VtoVTV,VtoSeg,IdSector,IdServicio,A1TV,A2TI,A3VTV,FA1TV,FA2TI,FA3VTV,IdMarcaTaco,IdRodado,NroChasis,NroMotor,KmI,Taco,NroTaco,Cub,IdPSA,IdPST,ItPSA,ItPST,Propio,Leasing,Precio,Meses,PrecioR,IdFormaA,IdPSRCC,ItPSRCC) VALUES ($nroId,'$nom','$fechaa','$fechab',$elem,$anio,'$dom',$mar,$cat,$cond,$fabr,'$mod','$prop',$alq,$af,'$foto','$obs','$vtovtv','$vtoseg',$sec,$serv,$atv,$ati,$avtv,'$fatv','$fati','$favtv',$mart,$rod,'$chas','$mot',$kmi,$taco,'$ntaco',$cub,$psa,$pst,$ipsa,$ipst,$propio,$leas,$costo,$mes,$costor,$fadq,$psrcc,$ipsrcc)"; 
		$rs=mysql_query($query,$conn); 
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'. Verifique que Dominio y Nombre no esten repetidos'; 
			header("Location:Alta.php");
		}			
	}	
}





?>

