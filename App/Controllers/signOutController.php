<?php
session_start();
session_unset();
session_destroy();
header("Location: /_PROJ/App/Views/main_page_view.php");
exit;
?>