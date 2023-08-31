<?php
// error_reporting(E_ALL);ini_set('display_errors', 1);
session_start();
require 'User.php';
require 'AccountData.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$user = new User();
$accountType = $user->getAccountType($userId);
$accountInfo = new AccountData();
if($accountType === "single"){
    $customerData = $accountInfo->displayIndividualAccount($userId);
}
if($accountType === "joint"){
    $customerData = $accountInfo->displayJointAccount($userId);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $depoSucc = $depoErr = "";
    $withSucc = $withErr = "";
    if (isset($_POST["deposit_submit"])) {
        $depositAmount = $_POST['deposit_amount'];
        if ($depositAmount <= 0) {
            $depoErr = "Please enter valid amount";
        } else {
            $depositMoney = new User();
            $result = $depositMoney->depositMoney($userId, $depositAmount);
            if ($result) {
                $depoSucc = "deposit of $depositAmount was successful";
            } else {
                $depErr = "Error:Deposit failed";
            }
        }
    }
    if (isset($_POST["withdraw_submit"])) {
        $withdrawAmount = $_POST['withdraw_amount'];
        $balance = new User();
        $accountBalance = $balance->getUserAccountBalance($userId);
        $remainingBalance = $accountBalance - $withdrawAmount;
        if ($accountBalance < $withdrawAmount) {
            $withErr = "Insufficient balance";
        } elseif ($withdrawAmount <= 0) {
            $withErr = "Enter the valid amount";
        } elseif ($remainingBalance < 500) {
            $withErr = "Failed : The entered amount is below the minimum required.";
        } else {
            $withdrawMoney = new User();
            $result = $withdrawMoney->withdrawMoney($userId, $withdrawAmount);
            if ($result) {
                $withSucc = "withdraw of $withdrawAmount was successful";
            } else {
                $withErr =  "Error:Withdraw failed";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <h1>Welcome to our Bank</h1>
    <?php if ($customerData === null): ?>
        <p>No individual account details found for this user.</p>
    <?php elseif (isset($customerData['error'])): ?>
        <p>An error occurred: <?= $customerData['error']; ?></p>
    <?php else: ?>
        <p>Account Id: <?= $customerData['accountId']; ?></p>
        <p>Account Type: <?= $customerData['accountType']; ?></p>
        <p>Account Number: <?= $customerData['accountNumber']; ?></p>
        <p>Balance: <?= $customerData['balance']; ?></p>
    <?php endif; ?>
    
    <h3>Deposite : </h3>
    <div class="form-container" id="depositForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="deposit_amount">Deposit Amount:</label>
            <input type="number" name="deposit_amount" id="deposit_amount" required>
            <input type="submit" name="deposit_submit" value="Deposit"><br>
            <span class="success"><?php echo $depoSucc; ?></span>
            <span class="error"><?php echo $depoErr; ?></span>
        </form>
    </div>

    <h3>Withdraw : </h3>
    <div class="form-container" id="withdrawForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="withdraw_amount">Withdraw Amount:</label>
            <input type="number" name="withdraw_amount" id="withdraw_amount" required>
            <input type="submit" name="withdraw_submit" value="Withdraw"><br>

            <span class="success"><?php echo $withSucc; ?></span>
            <span class="error"><?php echo $withErr; ?></span>
        </form>
    </div>
    <div class="button-container">
        <div><span class="formBtn"><a href="FdForm.php">Fixed Deposit</a></span> </div>
        <div><span class="formBtn"><a href="RdForm.php">RecurringDeposit</a></span> </div>
        <div><span class="formBtn"><a href="FundForm.php">Fund Transfer</a></span> </div>
        <div><span class="formBtn"><a href="transaction.php">Show Transactions</a></span> </div>
        <div><span class="formBtn"><a href="deposits.php">Deposits</a></span> </div>
    </div>

    <br>
    <div><span class="formBtn"><a href="logout.php">Logout</a></span> </div>
    <script type="text/javascript">
        window.history.forward();

        function noBack() {
            window.history.forward();
        }
    </script>
</body>

</html>