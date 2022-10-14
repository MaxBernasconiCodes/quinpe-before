<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


function UNIKM_buscarunidad($domrsv,&$nom,&$nro,$conn){
    $nom='';$nro='';
    //saca espacios, pasa a mayuscula y elimina guiones y espacios rsv
    $domrsv=trim(strtoupper(str_replace('-','',str_replace(' ','',$domrsv))));
    //saca espacios, pasa a mayuscula y elimina guiones y espacios quinpe
	$query="SELECT Id,Nombre From unidades where TRIM(UCASE(REPLACE(REPLACE(Dominio, ' ', ''), '-', '')))='$domrsv'";
	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
    if(mysql_num_rows($rs2)!=0){$nom=$row2['Nombre'];$nro=$row2['Id'];}mysql_free_result($rs2);
}

?>