<?php
// Simple admin page to view all transactions
$db = new PDO("sqlite:db.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->query("SELECT * FROM transactions ORDER BY created_at DESC");
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Transactions</title>
</head>
<body>
<h2>All Transactions (Admin)</h2>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
<th>ID</th>
<th>Transaction ID</th>
<th>Type</th>
<th>Status</th>
<th>Amount (UGX)</th>
<th>Created At</th>
</tr>
<?php foreach ($transactions as $t): ?>
<tr>
<td><?= $t['id'] ?></td>
<td><?= $t['transaction_id'] ?></td>
<td><?= $t['type'] ?></td>
<td><?= $t['status'] ?></td>
<td><?= $t['amount'] ?></td>
<td><?= $t['created_at'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="index.php">Back to Home</a></p>
</body>
</html>
