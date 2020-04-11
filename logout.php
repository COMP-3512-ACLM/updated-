<?php

include "includes/db-users.inc.php";
logout();
header("Location: " . $_SERVER["HTTP_REFERER"]);

?>