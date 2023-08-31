<?php
require 'User.php';
require 'AccountData.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$user = new User();
$accountType = $user->getAccountType($userId);
$history = new AccountData();
$transaction_history = $history->getTransaction($userId, $accountType);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="transaction.css">
</head>
<body>

<?php if (isset($transaction_history['error'])): ?>
        <p><?php echo $transaction_history['error']; ?></p>
    <?php else: ?>
        <h2>Transaction History</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Account Type</th>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Transaction Date</th>
            </tr>
            <?php foreach ($transaction_history as $transaction): ?>
                <tr>
                    <td><?= $transaction['user_id']; ?></td>
                    <td><?= $transaction['account_type']; ?></td>
                    <td><?= $transaction['transaction_type']; ?></td>
                    <td><?= $transaction['amount']; ?></td>
                    <td><?= $transaction['description']; ?></td>
                    <td><?= $transaction['transaction_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <div class="button-container">
        <div><span class="formBtn"><a href="dashboard.php">Home</a></span> </div>
        <div><span class="formBtn"><a href="logout.php">Log out</a></span> </div>
    </div>
    <script type="text/javascript">
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>
</body>

</html>