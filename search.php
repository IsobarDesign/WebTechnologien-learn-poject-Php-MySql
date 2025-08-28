<?php
include 'db.php';
if(isset($_GET['query'])){
    $search = "%".$_GET['query']."%";
    $sql = "SELECT productCode, productName,productLine,buyPrice,MSRP FROM products WHERE productName LIKE ? OR productLine LIKE ?";
    $smt = $conn->prepare($sql);
    $likeSearch = "%".$search."%";
    $smt->bind_param("ss",$search,$search);
    $smt->execute();
    $result = $smt->get_result();
} else {
    $result=[];
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
            <tr><td colspan="5">No results found</td></tr>
        <?php endif; ?>
</body>
</html>