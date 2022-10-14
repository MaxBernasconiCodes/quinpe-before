<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

$valor=intval($_POST['CbLocalidad']);$pcia="";$cp="";
if ($valor != 0){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT p.Nombre,l.CP  From provincias p, localidades l Where l.IdPcia=p.Id and l.Id= $valor";$rs=mysql_query($query,$conn);	
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$pcia=$row['Nombre'];$cp=$row['CP'];}mysql_free_result($rs);
	mysql_close($conn); 
}
//obtener datos del form anterior
foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
$_SESSION['TxtProvincia'] = $pcia;$_SESSION['TxtCP'] = $cp;
?>