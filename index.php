<?php
include 'db.php';

$limit = 20; // Limit the number of products displayed
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT productCode, productName,productLine,buyPrice,MSRP FROM products LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href=style.css >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Product List</h2>
<div class="flex-container">
    
    <from method="GET" action="search.php" class="search-form">
        <input type="text" name="query" placeholder="Search products by name or code...">
        <button type="submit">Search</button>
    </from>

    <a href="add.php" class="btn-add">Add New Product</a>

    
    </div>
    <table border ="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Product Line</th>
            <th>Buy Price</th>
            <th>MSRP</th>
        </tr>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['productCode']); ?></td>
                    <td><?php echo htmlspecialchars($row['productName']); ?></td>
                    <td><?php echo htmlspecialchars($row['productLine']); ?></td>
                    <td><?php echo htmlspecialchars($row['buyPrice']); ?></td>
                    <td><?php echo htmlspecialchars($row['MSRP']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No products found</td></tr>
        <?php endif; ?>
    </table>
    
    <?php $conn->close(); ?>

       
</body>
</html>