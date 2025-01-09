<?php

if ($action == 'addNewEmployee') {
    try {
        $query = "INSERT INTO employee VALUES (NULL, :n1, :n2, :n3, :n4, :n5, :n6, :n7, :n8, :n9, :n10, CURRENT_TIMESTAMP, 1)";
        $insert = $pdo->prepare($query);

        // Asignar los valores a variables antes de pasarlos a bindParam
        $firstName = htmlspecialchars($_POST['firstName']);
        $secondName = htmlspecialchars($_POST['secondName']);
        $firstLastName = htmlspecialchars($_POST['firstLastName']);
        $secondLastName = htmlspecialchars($_POST['secondLastName']);
        $email = htmlspecialchars($_POST['email']) . "@willy.com";
        $hashedPassword = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
        $rolEmployee = htmlspecialchars($_POST['rolEmployee']);
        $birthDay = htmlspecialchars($_POST['birthDay']);
        $DUInumber = htmlspecialchars($_POST['DUInumber']);
        $startTime = !empty($_POST['startTime']) ? htmlspecialchars($_POST['startTime']) : NULL;

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $firstName);
        $insert->bindParam(':n2', $secondName);
        $insert->bindParam(':n3', $firstLastName);
        $insert->bindParam(':n4', $secondLastName);
        $insert->bindParam(':n5', $email);
        $insert->bindParam(':n6', $hashedPassword);
        $insert->bindParam(':n7', $rolEmployee);
        $insert->bindParam(':n8', $birthDay);
        $insert->bindParam(':n9', $DUInumber);
        $insert->bindParam(':n10', $startTime);
        $insert->execute();

        echo 1;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'changePasswordEmployee') {
    try {
        $query = "UPDATE employee set password = :n1 WHERE id = :n2";
        $insert = $pdo->prepare($query);
        $hashedPassword = password_hash(htmlspecialchars($_POST['newEditPassword']), PASSWORD_BCRYPT);
        $idEmployee = htmlspecialchars(intval($_POST['idCodigoEmpleado']));

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $hashedPassword);
        $insert->bindParam(':n2', $idEmployee);
        $insert->execute();

        echo 1;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'updateStatusEmployee') {
    try {
        $queryState = "SELECT status FROM employee WHERE id = ?";
        $stmt = $pdo->prepare($queryState);
        $stmt->execute([$_POST['idcodigoEmpleado']]);

        if ($stmt->rowCount() > 0) {
            $estadoActual = $stmt->fetchColumn();
            if ($estadoActual == 1) {
                // Si el estado es 1, cambia a 0
                $updateQuery = "UPDATE employee SET status = 0 WHERE id = ?";
            } else {
                // Si el estado es 0, cambia a 1
                $updateQuery = "UPDATE employee SET status = 1 WHERE id = ?";
            }

            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$_POST['idcodigoEmpleado']]);
            echo 1;
        } else {
            echo "Factura no encontrada.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'updateRegisterEmployee') {
    try {
        $query = "UPDATE employee set name1 = :n1, name2 = :n2, lastname1 = :n3, lastname2 = :n4, type = :n6, birthday = :n7, DUI = :n8, startTime = :n9 where id = :n10";

        // Asignar los valores a variables antes de pasarlos a bindParam
        $idEmployee = htmlspecialchars(intval($_POST['idCodigoEmpleado']));
        $firstName = htmlspecialchars($_POST['firstName']);
        $secondName = htmlspecialchars($_POST['secondName']);
        $firstLastName = htmlspecialchars($_POST['firstLastName']);
        $secondLastName = htmlspecialchars($_POST['secondLastName']);
        $rolEmployee = htmlspecialchars($_POST['rolEmployee']);
        $birthDay = htmlspecialchars($_POST['birthDay']);
        $DUInumber = htmlspecialchars($_POST['DUInumber']);
        $startTime = !empty($_POST['startTime']) ? htmlspecialchars($_POST['startTime']) : NULL;

        $insert = $pdo->prepare($query);
        $insert->bindParam(':n1', $firstName);
        $insert->bindParam(':n2', $secondName);
        $insert->bindParam(':n3', $firstLastName);
        $insert->bindParam(':n4', $secondLastName);
        $insert->bindParam(':n6', $rolEmployee);
        $insert->bindParam(':n7', $birthDay);
        $insert->bindParam(':n8', $DUInumber);
        $insert->bindParam(':n9', $startTime);
        $insert->bindParam(':n10', $idEmployee);
        $insert->execute();
        echo 1;
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage();
    }
} else if ($action == 'addNewCategory') {
    try {
        $query = "INSERT INTO product_category VALUES (NULL, :n1, :n2, CURRENT_TIMESTAMP, :n3)";
        $insert = $pdo->prepare($query);

        // Asignar los valores a variables antes de pasarlos a bindParam
        $nameCategory = htmlspecialchars($_POST['name']);
        $codeCategory = !empty($_POST['code']) ? htmlspecialchars($_POST['code']) : NULL;
        $statusCategory = htmlspecialchars(intval($_POST['status']));

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $nameCategory);
        $insert->bindParam(':n2', $codeCategory);
        $insert->bindParam(':n3', $statusCategory);
        $insert->execute();

        echo 1;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'updateStatusCategory') {
    try {
        $queryState = "SELECT status FROM product_category WHERE id = ?";
        $stmt = $pdo->prepare($queryState);
        $stmt->execute([$_POST['idcodigoCategory']]);

        if ($stmt->rowCount() > 0) {
            $estadoActual = $stmt->fetchColumn();
            if ($estadoActual == 1) {
                // Si el estado es 1, cambia a 0
                $updateQuery = "UPDATE product_category SET status = 0 WHERE id = ?";
            } else {
                // Si el estado es 0, cambia a 1
                $updateQuery = "UPDATE product_category SET status = 1 WHERE id = ?";
            }

            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$_POST['idcodigoCategory']]);
            echo 1;
        } else {
            echo "Categoria no encontrada.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'editCategoryRegister') {
    try {
        $query = "UPDATE product_category set name = :n1, code = :n2, status = :n3 where id = :n4";

        // Asignar los valores a variables antes de pasarlos a bindParam
        $idCategory = htmlspecialchars(intval($_POST['idCodigoCategoria']));
        $nameCategory = htmlspecialchars($_POST['name']);
        $codeCategory = !empty($_POST['code']) ? htmlspecialchars($_POST['code']) : NULL;
        $statusCategory = htmlspecialchars(intval($_POST['status']));

        $insert = $pdo->prepare($query);
        $insert->bindParam(':n1', $nameCategory);
        $insert->bindParam(':n2', $codeCategory);
        $insert->bindParam(':n3', $statusCategory);
        $insert->bindParam(':n4', $idCategory);
        $insert->execute();
        echo 1;
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage();
    }
} else if ($action == 'assignProductsToCategory') {
    try {
        // Datos recibidos por POST
        $categoriaId = $_POST['categoriaId'];
        $productos = $_POST['productos']; // Array de IDs de productos
        // Preparar la consulta para mayor seguridad
        $query = "UPDATE products SET id_category = :categoriaId WHERE id = :productoId";
        $stmt = $pdo->prepare($query);

        // Ejecutar la consulta para cada producto
        foreach ($productos as $productoId) {
            $stmt->execute([
                ':categoriaId' => $categoriaId,
                ':productoId' => $productoId
            ]);
        }

        echo 1; // Éxito
        exit;
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage();
    }
} else if ($action == 'addNewBrand') {
    try {
        $query = "INSERT INTO product_brand VALUES (NULL, :n1, :n2, CURRENT_TIMESTAMP, :n3)";
        $insert = $pdo->prepare($query);

        // Asignar los valores a variables antes de pasarlos a bindParam
        $nameBrand = htmlspecialchars($_POST['name']);
        $idCategory = htmlspecialchars(intval($_POST['idCategory']));
        $statusBrand = htmlspecialchars(intval($_POST['status']));

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $idCategory);
        $insert->bindParam(':n2', $nameBrand);
        $insert->bindParam(':n3', $statusBrand);
        $insert->execute();

        echo 1;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'editBrandRegister') {
    try {
        $query = "UPDATE product_brand set id_category = :n1, name = :n2, status = :n3 where id = :n4";

        // Asignar los valores a variables antes de pasarlos a bindParam
        $idBrand = htmlspecialchars(intval($_POST['idCodigoMarca']));
        $nameBrand = htmlspecialchars($_POST['name']);
        $idCategory = htmlspecialchars(intval($_POST['idCategory']));
        $statusBrand = htmlspecialchars(intval($_POST['status']));

        $insert = $pdo->prepare($query);
        $insert->bindParam(':n1', $idCategory);
        $insert->bindParam(':n2', $nameBrand);
        $insert->bindParam(':n3', $statusBrand);
        $insert->bindParam(':n4', $idBrand);
        $insert->execute();
        echo 1;
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage();
    }
} else if ($action == 'updateStatusBrand') {
    try {
        $queryState = "SELECT status FROM product_brand WHERE id = ?";
        $stmt = $pdo->prepare($queryState);
        $stmt->execute([$_POST['idcodigoMarca']]);

        if ($stmt->rowCount() > 0) {
            $estadoActual = $stmt->fetchColumn();
            if ($estadoActual == 1) {
                // Si el estado es 1, cambia a 0
                $updateQuery = "UPDATE product_brand SET status = 0 WHERE id = ?";
            } else {
                // Si el estado es 0, cambia a 1
                $updateQuery = "UPDATE product_brand SET status = 1 WHERE id = ?";
            }

            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$_POST['idcodigoMarca']]);
            echo 1;
        } else {
            echo "Brand no encontrada.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
//get de productos por categoria
else if ($action == 'getProductsByCategory') {
    try {
        $categoryId = $_POST['categoryId'];
        $query = "SELECT id, name, quantity, net_cost FROM products WHERE id_category = ? AND status = 1 AND net_cost IS NULL or net_cost = 0";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$categoryId]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
//get de marcas dentro de categoria con productos
else if ($action == 'getBrandsAndProducts') {
    try {
        $categoryId = intval($_POST['categoryId']);

        // Consultar el nombre de la categoría
        $queryCategory = "SELECT name FROM product_category WHERE id = ? AND status = 1";
        $stmtCategory = $pdo->prepare($queryCategory);
        $stmtCategory->execute([$categoryId]);
        $categoryName = $stmtCategory->fetchColumn();

        // Consultar las marcas asociadas a la categoría
        $queryBrands = "SELECT id, name FROM product_brand WHERE id_category = ? AND status = 1";
        $stmtBrands = $pdo->prepare($queryBrands);
        $stmtBrands->execute([$categoryId]);
        $brands = $stmtBrands->fetchAll(PDO::FETCH_ASSOC);

        $response = [
            "categoryName" => $categoryName,
            "brands" => [],
        ];

        // Consultar productos de cada marca
        foreach ($brands as $brand) {
            $brandId = intval($brand["id"]);

            $queryProducts = "SELECT name, net_cost, quantity FROM products WHERE id_brand = ? AND id_category = ? AND status = 1";
            $stmtProducts = $pdo->prepare($queryProducts);
            $stmtProducts->execute([$brandId, $categoryId]);
            $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

            $response["brands"][] = [
                "name" => $brand["name"],
                "products" => $products,
            ];
        }

        echo json_encode($response);
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
//get de productos sin categoria para asignarles una
else if ($action == 'getUnassignedProducts') {
    try {
        // Query para seleccionar los productos
        $query = "SELECT id, name, quantity, net_cost FROM products WHERE id_category IS NULL AND status = 1";

        $stmt = $pdo->prepare($query); // Preparar la consulta
        $stmt->execute();              // Ejecutar la consulta
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados en un array asociativo

        echo json_encode($productos); // Convertir a JSON y enviar al cliente
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
//get de productos por marca y categorias
else if ($action == 'getProductsByBrand') {

    try {
        $brandId = intval($_POST['brandId']);

        // Obtener nombre de la marca
        $brandNameQuery = $pdo->prepare("SELECT name FROM product_brand WHERE id = ? AND status = 1");
        $brandNameQuery->execute([$brandId]);
        $brandName = $brandNameQuery->fetchColumn();

        // Obtener categorías y productos de esta marca
        $categoriesQuery = $pdo->prepare("
    SELECT c.id AS category_id, c.name AS category_name FROM product_category c JOIN products p ON p.id_category = c.id WHERE p.id_brand = ? GROUP BY c.id, c.name;
    ");
        $categoriesQuery->execute([$brandId]);
        $categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);

        $result = [
            'brandName' => $brandName,
            'categories' => [],
        ];

        foreach ($categories as $category) {
            $productsQuery = $pdo->prepare("SELECT name, net_cost, quantity, status FROM products WHERE id_brand = ? AND id_category = ? AND status = 1");
            $productsQuery->execute([$brandId, $category['category_id']]);
            $products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);

            $result['categories'][] = [
                'name' => $category['category_name'],
                'products' => $products,
            ];
        }

        echo json_encode($result);
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'getCategories') {
    try {
        // Consulta para obtener las categorías
        $query = "SELECT id, name, code FROM product_category WHERE status = 1";
        $stmt = $pdo->query($query);

        // Verificar si hay resultados
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($categories) {
            echo json_encode($categories);
        } else {
            echo json_encode([]); // No se encontraron categorías
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener las categorías: ' . $e->getMessage()]);
    }
}
//get de marcas por categoria
else if ($action == 'getBrandsByCategory') {
    try {
        $idCategory = intval($_POST['idCategory']);
        $query = "SELECT id, name FROM product_brand WHERE id_category = :idCategory AND status = 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($brands);
        // exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'addNewProduct') {
    try {
        $query = "INSERT INTO products VALUES (NULL, :n1, :n2, :n3, :n4, :n5, :n6, CURRENT_TIMESTAMP, NULL, :n7)";
        $insert = $pdo->prepare($query);

        // Asignar los valores a variables antes de pasarlos a bindParam
        $idCategory = !empty($_POST['idCategoryProduct']) ? htmlspecialchars(intval($_POST['idCategoryProduct'])) : NULL;
        $idBrand = !empty($_POST['idBrandProduct']) ? htmlspecialchars(intval($_POST['idBrandProduct'])) : NULL;
        $nameProduct = htmlspecialchars($_POST['nameProduct']);
        $descProduct = !empty($_POST['productDescription']) ? htmlspecialchars($_POST['productDescription']) : NULL;
        $netCostProduct = !empty($_POST['costProduct']) ? htmlspecialchars($_POST['costProduct']) : NULL;
        $quantityProduct = !empty($_POST['quantityProduct']) ? htmlspecialchars(intval($_POST['quantityProduct'])) : NULL;
        $statusProduct = htmlspecialchars(intval($_POST['statusProduct']));

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $idCategory);
        $insert->bindParam(':n2', $idBrand);
        $insert->bindParam(':n3', $nameProduct);
        $insert->bindParam(':n4', $descProduct);
        $insert->bindParam(':n5', $netCostProduct);
        $insert->bindParam(':n6', $quantityProduct);
        $insert->bindParam(':n7', $statusProduct);
        $insert->execute();

        echo 1;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif ($action == 'updateStatusProduct') {
    try {
        $queryState = "SELECT status FROM products WHERE id = ?";
        $stmt = $pdo->prepare($queryState);
        $stmt->execute([$_POST['idcodigoProducto']]);

        if ($stmt->rowCount() > 0) {
            $estadoActual = $stmt->fetchColumn();
            if ($estadoActual == 1) {
                // Si el estado es 1, cambia a 0
                $updateQuery = "UPDATE products SET status = 0 WHERE id = ?";
            } else {
                // Si el estado es 0, cambia a 1
                $updateQuery = "UPDATE products SET status = 1 WHERE id = ?";
            }

            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$_POST['idcodigoProducto']]);
            echo 1;
        } else {
            echo "Producto no encontrada.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'editProductRegister') {
    try {
        $query = "UPDATE products set id_category = :n1, id_brand = :n2, name = :n3, description = :n4, net_cost = :n5, quantity = :n6, date_edit = CURRENT_TIMESTAMP, status = :n7 where id = :n8";

        // Asignar los valores a variables antes de pasarlos a bindParam
        $idProduct = htmlspecialchars(intval($_POST['idProductEdit']));
        $idCategory = !empty($_POST['idCategoryProductEdit']) ? htmlspecialchars(intval($_POST['idCategoryProductEdit'])) : NULL;
        $idBrand = !empty($_POST['idBrandProductEdit']) ? htmlspecialchars(intval($_POST['idBrandProductEdit'])) : NULL;
        $nameProduct = htmlspecialchars($_POST['nameProductEdit']);
        $descProduct = !empty($_POST['productDescriptionEdit']) ? htmlspecialchars($_POST['productDescriptionEdit']) : NULL;
        $netCostProduct = !empty($_POST['costProductEdit']) ? htmlspecialchars($_POST['costProductEdit']) : NULL;
        $quantityProduct = !empty($_POST['quantityProductEdit']) ? htmlspecialchars(intval($_POST['quantityProductEdit'])) : NULL;
        $statusProduct = htmlspecialchars(intval($_POST['statusProductEdit']));

        $insert = $pdo->prepare($query);
        $insert->bindParam(':n1', $idCategory);
        $insert->bindParam(':n2', $idBrand);
        $insert->bindParam(':n3', $nameProduct);
        $insert->bindParam(':n4', $descProduct);
        $insert->bindParam(':n5', $netCostProduct);
        $insert->bindParam(':n6', $quantityProduct);
        $insert->bindParam(':n7', $statusProduct);
        $insert->bindParam(':n8', $idProduct);
        $insert->execute();
        echo 1;
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage();
    }
}
//sumar productos
else if ($action == 'addProductQuantity') {
    try {
        $productId = $_POST['productId'];
        $quantityToAdd = (int) $_POST['quantity'];

        // Validar datos
        if ($quantityToAdd <= 0) {
            echo "Cantidad inválida.";
            exit;
        }

        // Obtener la cantidad actual
        $query = "SELECT quantity FROM products WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productId]);
        $currentQuantity = $stmt->fetchColumn();

        if ($currentQuantity === false) {
            echo "Producto no encontrado.";
            exit;
        }

        // Actualizar la cantidad
        $newQuantity = $currentQuantity + $quantityToAdd;
        $updateQuery = "UPDATE products SET quantity = ? WHERE id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$newQuantity, $productId]);

        // // Registrar el movimiento (opcional)
        // $logQuery = "INSERT INTO product_movements (product_id, change_type, quantity, description, created_at) 
        //              VALUES (?, 'addition', ?, ?, NOW())";
        // $logStmt = $pdo->prepare($logQuery);
        // $logStmt->execute([$productId, $quantityToAdd, $description]);

        echo 1; // Éxito
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
//restar productos
else if ($action == 'subtractProduct') {
    try {
        $productId = $_POST['productId'];
        $quantityToSubtract = $_POST['quantity'];

        // Verificar si la cantidad a restar es válida
        $query = $pdo->prepare("SELECT quantity FROM products WHERE id = ?");
        $query->execute([$productId]);
        $currentQuantity = $query->fetchColumn();

        if ($currentQuantity >= $quantityToSubtract) {
            // Restar la cantidad en la base de datos
            $newQuantity = $currentQuantity - $quantityToSubtract;
            $update = $pdo->prepare("UPDATE products SET quantity = ? WHERE id = ?");
            $update->execute([$newQuantity, $productId]);
            echo 1; // Éxito
        } else {
            echo 0; // Error: cantidad a restar mayor que la disponible
        }
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage();
    }
}
//colocar costo a producto en modal diferente xd
else if ($action == 'updateProductCosts') {
    try {
        $categoryId = $_POST['categoryId'];
        $costs = $_POST['costs'];

        foreach ($costs as $productId => $cost) {
            $query = "UPDATE products SET net_cost = ? WHERE id = ? AND id_category = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$cost, $productId, $categoryId]);
        }

        echo 1; // Respuesta de éxito
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage();
    }
}
