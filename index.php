<?php
include("./config/net.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("./template/meta.php"); ?>
</head>
<body>
    <?php
    include("./template/header.php");
    include("./config/router.php");
    include("./template/footer.php");
    ?>
</body>
</html>