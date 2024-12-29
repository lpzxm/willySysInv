<?php
include("./config/net.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("./template/meta.php"); ?>
</head>
<body>
    <?php
    session_start();
    include("./template/header.php");
    include("./config/router.php");
    include("./template/footer.php");
    ?>
</body>
</html>