<?php

$logged = (isset($_SESSION['user_id'])) ? true : false;
$view = (isset($_GET['view'])) ? $_GET['view'] : '';

if ($view == '') {
    include("./views/public.php");
} else if ($view == 'login') {
    include("./views/login.php");
} else if ($view == 'main' && $logged) {
    include("./views/view.main.php");
} else if ($view == 'main/gestionarUsuarios' && $logged) {
    include("./views/admin/employees/view.users.admin.php");
} else if ($view == 'main/gestionarProductos' && $logged) {
    # code...
} else if ($view == 'main/gestionarCategorias' && $logged) {
    include("./views/admin/categories/view.categories.admin.php");
} else if ($view == 'main/gestionarUsuarios' && $logged) {
    # code...
} else if ($view == 'main/gestionarMarcas' && $logged) {
    # code...
} else if ($view == 'main/gestionarProveedores' && $logged) {
    # code...
}
