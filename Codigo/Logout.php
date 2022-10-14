<? 
session_start();
if(!isset($_SESSION)){//no existe session
header("location:../Index.php");
} else {
//borro session
session_unset();
session_destroy();
header("location:../Index.php");
}
?>

