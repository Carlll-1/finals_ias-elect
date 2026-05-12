<?php
// 1. Simulan ang session para ma-access ang current data
session_start();

// 2. Alisin lahat ng session variables
session_unset();

// 3. I-destroy ang mismong session folder sa server
session_destroy();

// 4. I-redirect ang user pabalik sa login page
header("Location: login.php");
exit();
?>