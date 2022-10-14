<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


echo '<table width="730" border="0"  cellpadding="0" cellspacing="0" class="TMT">';

//comunes a todas las auditorias
MostrarTablaAuditores($_SESSION['TxtNumero'],$conn);
MostrarTablaAuditados($_SESSION['TxtNumero'],$conn); 
MostrarTablaProcesos($_SESSION['TxtNumero'],$conn);
?>

<!--archivos-->
 <tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
 <tr> <td  align="center"><?php GLO_TablaArchivos(intval($_SESSION['TxtNumero']),$conn,"iso_audi_archivos",730,"NC/"); ?>	</td></tr>
<tr> <td height="15"></td></tr>

<?
if (intval($_SESSION['CbTipo'])==1){MostrarTablaDesvios($_SESSION['TxtNumero'],$conn);}//comportamental   
if (intval($_SESSION['CbTipo'])==2){MostrarTablaReq($_SESSION['TxtNumero'],$conn);}//gestion   

echo '</table>';
             
?>