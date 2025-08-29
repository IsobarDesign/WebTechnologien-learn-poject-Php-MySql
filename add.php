<?php
require_once 'db.php';

$message = "";

// Pobierz dostępne linie produktów
$productLines = [];
try {
    $stmt = $pdo->query("SELECT productLine FROM productlines ORDER BY productLine");
    $productLines = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die("Error fetching product lines: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productCode = $_POST['productCode'];
    $productName = $_POST['productName'];
    $productLine = $_POST['productLine'];
    $productScale = $_POST['productScale'];
    $productVendor = $_POST['productVendor'];
    $productDescription = $_POST['productDescription'];
    $buyPrice = $_POST['buyPrice'];
    $MSRP = $_POST['MSRP'];

    $sql = "INSERT INTO products 
            (productCode, productName, productLine, productScale, productVendor, productDescription, buyPrice, MSRP)
            VALUES
            (:productCode, :productName, :productLine, :productScale, :productVendor, :productDescription, :buyPrice, :MSRP)";
    
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            ':productCode' => $productCode,
            ':productName' => $productName,
            ':productLine' => $productLine,
            ':productScale' => $productScale,
            ':productVendor' => $productVendor,
            ':productDescription' => $productDescription,
            ':buyPrice' => $buyPrice,
            ':MSRP' => $MSRP
        ]);
        $message = "New product added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
            margin: 0;
        }
        .add-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .add-box input, .add-box select, .add-box textarea, .add-box button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .add-box button {
            background: #667eea;
            color: white;
            border: none;
            cursor: pointer;
        }
        .add-box button:hover {
            background: #5563d9;
        }
        .message {
            margin-bottom: 15px;
            color: green;
        }
    </style>
</head>
<body>
<div class="add-box">
    <h2>Add New Product</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="productCode" placeholder="Product Code" required>
        <input type="text" name="productName" placeholder="Product Name" required>
        <select name="productLine" required>
            <option value="">Select Product Line</option>
            <?php foreach($productLines as $line): ?>
                <option value="<?= htmlspecialchars($line) ?>"><?= htmlspecialchars($line) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="productScale" placeholder="Product Scale" required>
        <input type="text" name="productVendor" placeholder="Product Vendor" required>
        <textarea name="productDescription" placeholder="Product Description" required></textarea>
        <input type="number" step="0.01" name="buyPrice" placeholder="Buy Price" required>
        <input type="number" step="0.01" name="MSRP" placeholder="MSRP" required>
        <button type="submit">Add Product</button>
    </form>
</div>
</body>
</html>