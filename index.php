<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Betting Wallet</title>
</head>
<body>
  <h2>Deposit Funds</h2>
  <p>Click the button below to pay via Pesapal:</p>

  <!-- Pesapal Iframe -->
  <iframe 
    width="300" 
    height="50" 
    src="https://store.pesapal.com/embed-code?pageUrl=https://store.pesapal.com/coldtechltd" 
    frameborder="0" 
    scrolling="no">
  </iframe>

  <hr>
  <h2>Withdraw Funds</h2>
  <form action="withdrawal.php" method="POST">
    <label>Phone Number:</label><br>
    <input type="text" name="phone" placeholder="+2567XXXXXXX" required><br><br>
    <label>Amount (UGX):</label><br>
    <input type="number" name="amount" required><br><br>
    <button type="submit">Request Withdrawal</button>
  </form>
  <hr>
  <p><a href="transactions.php">View All Transactions (Admin)</a></p>
</body>
</html>
