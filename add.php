<?php
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $productCode = $_POST['productCode'];
    $productName = $_POST['productName'];
    $productLine = $_POST['productLine'];
    $productScale = $_POST['productScale'];
    $productVendor = $_POST['productVendor'];
    $productDescription = $_POST['productDescription'];
    $buyPrice = $_POST['buyPrice'];
    $MSRP = $_POST['MSRP'];

    $sql = "INSERT INTO products (productCode, productName, productLine, productScale, productVendor, productDescription, buyPrice, MSRP) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssdd", $productCode, $productName, $productLine, $productScale, $productVendor, $productDescription, $buyPrice, $MSRP);
    
    if ($stmt->execute()) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Add New Product</h2>
    
<form method = "POST" action = "add.php">
    <input type="text" name="productCode" placeholder="Product Code"required>
    <input type="text" name="productName" placeholder="Product Name"required>
    <input type="text" name="productLine" placeholder="Product Line"required>
    <input type ="text" name="productScale" placeholder="Product Scale"required>
    <input type="text" name="productVendor" placeholder="Product Vendor"required>
    <textarea name="productDescription" placeholder="Product Description"required></textarea>
    <input type="number" step="0.01" name="buyPrice" placeholder="Buy Price"required>
    <input type="number" step="0.01" name="MSRP" placeholder="MSRP"required>
    <button type="submit" name="submit">Add Product</button>    
</form>

</body>
</html>
