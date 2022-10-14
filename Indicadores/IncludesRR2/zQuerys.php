<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//totales cantidad
$queryac="Select count(a.Id) as valor, $groupcol as grupo From personal a $grouptable Where a.Id<>0 $groupjoin $wsec $wherecomun  Group by $groupcol";


//totales por franjas edad
$queryfr1="Select count(a.Id) as valor,
CASE
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaNacimiento))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaNacimiento,5))) < 25 THEN 'a. entre 18 y 24'
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaNacimiento))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaNacimiento,5))) < 35 THEN 'b. entre 25 y 34'
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaNacimiento))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaNacimiento,5))) < 45 THEN 'c. entre 35 y 44'
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaNacimiento))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaNacimiento,5))) < 55 THEN 'd. entre 45 y 54'
ELSE 'e. mas de 54'
END
as grupo FROM personal a Where a.Id<>0 and a.FechaNacimiento<>'0000-00-00' $wsec $wherecomun GROUP BY grupo"; 



//totales por franjas antiguedad
$queryfr2="Select count(a.Id) as valor,
CASE
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaAlta))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaAlta,5))) < 2 THEN 'a. menor que 2'
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaAlta))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaAlta,5))) < 3 THEN 'b. entre 2 y 3'
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaAlta))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaAlta,5))) < 4 THEN 'c. entre 3 y 4'
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaAlta))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaAlta,5))) < 5 THEN 'd. entre 4 y 5'
WHEN ((YEAR(CURRENT_DATE) - YEAR(a.FechaAlta))-(RIGHT(CURRENT_DATE,5) < RIGHT(a.FechaAlta,5))) < 10 THEN 'e. entre 5 y 10'
ELSE 'f. mas de 10'
END
as grupo FROM personal a Where a.Id<>0 and a.FechaAlta<>'0000-00-00' $wsec $wherecomun GROUP BY grupo"; 

?>