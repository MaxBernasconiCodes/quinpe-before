<? 

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



?>





<!--adjuntos-->

<table width="700" border="0"  cellpadding="0" cellspacing="0" class="TMT" >

<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>

<tr> <td  align="center"><?php GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"instrumentosprog_a","700","Adjuntos/"); ?>	</td></tr>

</table>                  

