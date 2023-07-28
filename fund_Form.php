<?php
require 'user.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_SESSION['user_id'];
    $reci_acc_num = $_POST['receiver_account_number'];
    $trans_amount = $_POST['amount'];

    $balance = new User();
    $account_balance = $balance->getUserAccountBalance($userId);

    if ($account_balance < $trans_amount) {
        $error = "Insufficient balance";
    } else {
        $validate_account = new User;
        $checkAcc = $validate_account->getAccTypeUserIdFromAccountNumber($reci_acc_num);

        if ($checkAcc === null) {
            $error = "Account Not Found";
        } else {
            $trans_fund = new User();
            $result = $trans_fund->transferFunds($userId, $reci_acc_num, $trans_amount);
            if ($result) {
                $success = "Transfer Successfully";
            } else {
                $error = " Error: Failed to transfer Money.Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Fund Transfer</title>
    <link rel="stylesheet" href="fund_form.css">
    <style>
        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Fund Transfer</h2>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            Receiver Account Number:
            <input type="text" id="receiver_account_number" name="receiver_account_number" required>
            <br>

            Amount:
            <input type="number" id="amount" name="amount" required>
            <br>
            <input type="submit" value="Transfer Funds">
            <div>
                <span class="success"><?php echo $success; ?></span>
                <span class="error"><?php echo $error; ?></span>

            </div>
        </form>

        <div class="button-container">
            <div><span class="formBtn"><a href="dashboard.php">Home</a></span> </div>
            <div><span class="formBtn"><a href="logout.php">Log out</a></span> </div>

        </div>
    </div>
    <script type="text/javascript">
        window.history.forward();

        function noBack() {
            window.history.forward();
        }
    </script>
</body>

</html>