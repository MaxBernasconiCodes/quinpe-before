<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//busca datos
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$query="SELECT * From noticias";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtTitulo'] = $row['Titulo'];
	$_SESSION['TxtSTitulo'] = $row['Subtitulo'];
	$_SESSION['TxtTexto'] = $row['Texto'];
	$_SESSION['TxtUrgente'] = $row['Urgente'];
	$_SESSION['TxtFoto'] = $row['Ruta'];
}mysql_free_result($rs);
mysql_close($conn);

//asigna default
if(empty($_SESSION['TxtTitulo']) and empty($_SESSION['TxtSTitulo']) and empty($_SESSION['TxtTexto'])){
	$_SESSION['TxtTitulo'] = 'Bienvenidos a Intranet';
	$_SESSION['TxtSTitulo'] = 'QUINPE SRL';
	$_SESSION['TxtTexto'] = 'Somos una empresa que brinda servicios petroleros, con sede en la Ciudad de Fernandez Oro, Patagonia Argentina, y conformada por un grupo de profesionales con una vasta trayectoria asistiendo a las m&aacute;s importantes empresas de la regi&oacute;n.';

}

?> 


<div class="post" >
<h2 class="title"><?php echo $_SESSION['TxtTitulo'];?></h2>
<p class="title2" <?php if($_SESSION['TxtUrgente']==1){echo 'style="color:#f44336;font-weight:bold;"';} ?> ><?php echo $_SESSION['TxtSTitulo'];?></p>
<p class="entry"><?php echo $_SESSION['TxtTexto'];?></p>
<? if($_SESSION['TxtFoto']!=''){ 
echo '<img src="'.'Codigo/OpenImage.php?id='.'../Archivos/Fotos/'.$_SESSION['TxtFoto'].'" style="width:38rem;height:auto;border-radius:4px;"></img>';
}?>
</div>            
