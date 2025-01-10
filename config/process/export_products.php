<?php
require '../../vendor/autoload.php'; // Autoload de PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

include("../../config/net.php"); // Conexión a la base de datos

try {
    // Consulta para obtener las categorías con sus productos activos
    $query = "
        SELECT 
            pc.name AS category_name, 
            p.name AS product_name, 
            p.quantity, 
            p.net_cost, 
            (p.quantity * p.net_cost) AS total_cost
        FROM product_category pc
        JOIN products p ON pc.id = p.id_category
        WHERE p.status = 1
        ORDER BY pc.name, p.name;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($products)) {
        die("No hay productos activos para exportar.");
    }

    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Establecer el título del archivo
    $sheet->setTitle('Inventario Willy 2024');

    // Estilos generales
    $centerAlignment = [
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ];
    $boldStyle = [
        'font' => ['bold' => true],
    ];
    $headerFillStyle = [
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']],
    ];
    $categoryFillStyle = [
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'B4C7E7']],
    ];
    $borderStyle = [
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
        ],
    ];

    // Encabezados principales
    $sheet->mergeCells("A1:D1");
    $sheet->setCellValue("A1", "Ferreteria \"Willy\"");
    $sheet->getStyle("A1")->applyFromArray(array_merge($boldStyle, ['font' => ['size' => 16]]));
    $sheet->getStyle("A1")->applyFromArray($centerAlignment);

    $sheet->mergeCells("A2:D2");
    $sheet->setCellValue("A2", "Inventario de productos al 31 de diciembre de 2024.");
    $sheet->getStyle("A2")->applyFromArray(array_merge($boldStyle, ['font' => ['size' => 12]]));
    $sheet->getStyle("A2")->applyFromArray($centerAlignment);

    // Ajuste inicial de columnas
    $sheet->getColumnDimension('A')->setWidth(40);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(25);

    // Variables para la iteración
    $currentCategory = '';
    $row = 4; // Fila inicial para los datos
    $grandTotal = 0; // Total general

    foreach ($products as $product) {
        // Si cambia la categoría, agrega un encabezado para la nueva categoría
        if ($currentCategory !== $product['category_name']) {
            $currentCategory = $product['category_name'];

            // Escribir la categoría como encabezado (combinado y centrado)
            $sheet->mergeCells("A$row:D$row");
            $sheet->setCellValue("A$row", "Categoría: {$currentCategory}");
            $sheet->getStyle("A$row")->applyFromArray(array_merge($boldStyle, $centerAlignment, $categoryFillStyle));
            $row++;

            // Escribir encabezados para los productos
            $sheet->setCellValue("A$row", "Producto");
            $sheet->setCellValue("B$row", "Cantidad");
            $sheet->setCellValue("C$row", "Costo Unitario");
            $sheet->setCellValue("D$row", "Total (Cantidad x Costo)");
            $sheet->getStyle("A$row:D$row")->applyFromArray(array_merge($boldStyle, $headerFillStyle, $borderStyle, $centerAlignment));
            $row++;
        }

        // Escribir los datos del producto
        $sheet->setCellValue("A$row", $product['product_name']);
        $sheet->setCellValue("B$row", $product['quantity']);
        $sheet->setCellValue("C$row", number_format($product['net_cost'] ?? 0, 2));
        $sheet->setCellValue("D$row", number_format($product['total_cost'] ?? 0, 2));
        $sheet->getStyle("A$row:D$row")->applyFromArray($borderStyle);

        // Sumar al total general
        $grandTotal += $product['total_cost'];
        $row++;
    }

    // Escribir el total general
    $row++;
    $sheet->mergeCells("A$row:C$row");
    $sheet->setCellValue("A$row", "TOTAL GENERAL:");
    $sheet->getStyle("A$row")->applyFromArray(array_merge($boldStyle, $centerAlignment));
    $sheet->setCellValue("D$row", number_format($grandTotal, 2));
    $sheet->getStyle("D$row")->applyFromArray(array_merge($boldStyle, $centerAlignment));

    // Crear y descargar el archivo XLSX
    $writer = new Xlsx($spreadsheet);
    $filename = 'Inventario_Willys_2024.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $writer->save('php://output');
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
