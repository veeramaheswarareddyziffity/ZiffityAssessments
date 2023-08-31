<?php
// error_reporting(E_ALL);ini_set('display_errors', 1);
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
$historyData  = new AccountData();
$fd_history = $historyData->getFixedDeposits($userId,$accountType);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="table.css">
</head>
<body>
<?php if (isset($fd_history['error'])): ?>
        <p><?php echo $fd_history['error']; ?></p>
    <?php else: ?>
        <h2>Fixed Deposit History</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Principal Amount</th>
                <th>Interest Rate</th>
                <th>Interest Amount</th>
                <th>Maturity Amount</th>
                <th>Duration in Months</th>
                <th>Created At</th>
            </tr>
            <?php foreach ($fd_history as $fd): ?>
                <tr>
                    <td><?php echo $fd['user_id']; ?></td>
                    <td><?php echo $fd['principal_amount']; ?></td>
                    <td><?php echo $fd['interest_rate']; ?></td>
                    <td><?php echo $fd['intrest_amount']; ?></td>
                    <td><?php echo $fd['maturity_amount']; ?></td>
                    <td><?php echo $fd['duration_in_months']; ?></td>
                    <td><?php echo $fd['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

 <div class="button-container">
        <div><span class="formBtn"><a href="dashboard.php">Home</a></span> </div>
        <div><span class="formBtn"><a href="deposits.php">Deposits</a></span> </div>
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