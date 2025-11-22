<?php 
session_unset();
session_destroy();
header("Location: QLindex.php");
exit();
?>