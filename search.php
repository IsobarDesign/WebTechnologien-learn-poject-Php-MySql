<?php
require_once 'db.php';

$result = [];

if(isset($_GET['query'])){
    $search = "%".$_GET['query']."%";

    $sql = "SELECT productCode, productName, productLine, buyPrice, MSRP 
            FROM products 
            WHERE productName LIKE :search OR productLine LIKE :search2";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->bindValue(':search2', $search, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>
</head>
<body>
    <h2>Search Products</h2>
    <a href="index.php">Back to product list</a>

    <table border="1" cellpadding='5' cellspacing='0'>
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Product Line</th>
            <th>Buy Price</th>
            <th>MSRP</th>
        </tr>
        <?php if(!empty($result)): ?>
            <?php foreach($result as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['productCode']) ?></td>
                    <td><?= htmlspecialchars($row['productName']) ?></td>
                    <td><?= htmlspecialchars($row['productLine']) ?></td>
                    <td><?= htmlspecialchars($row['buyPrice']) ?></td>
                    <td><?= htmlspecialchars($row['MSRP']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No results found</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
