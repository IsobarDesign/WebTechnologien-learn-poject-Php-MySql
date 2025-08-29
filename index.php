<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
if(isset($_GET['page']) && $_GET['page'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

$limit = 20; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT productCode, productName, productLine, buyPrice, MSRP 
        FROM products 
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</h1>
    <a href="?page=logout" class="btn-logout">Logout</a>
    <h2>Product List</h2>
    <div class="btn-add">
        <form method="GET" action="search.php" class="search-form">
            <input type="text" name="query" placeholder="Search products by name or code...">
            <button type="submit">Search</button>
        </form>
        <a href="add.php" class="btn-add">Add New Product</a>
    </div>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Product Line</th>
            <th>Buy Price</th>
            <th>MSRP</th>
        </tr>
        <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['productCode']) ?></td>
                    <td><?= htmlspecialchars($row['productName']) ?></td>
                    <td><?= htmlspecialchars($row['productLine']) ?></td>
                    <td><?= htmlspecialchars($row['buyPrice']) ?></td>
                    <td><?= htmlspecialchars($row['MSRP']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No products found</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>