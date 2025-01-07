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
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const links = document.querySelectorAll(".gsap-link");

        links.forEach(link => {
            link.addEventListener("click", e => {
                e.preventDefault();
                const target = e.target.href;

                gsap.to("body", {
                    duration: 0.5,
                    opacity: 0,
                    onComplete: () => {
                        window.location.href = target;
                    },
                });
            });
        });
    });
</script>