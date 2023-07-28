<?php
require 'user.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];

    $monthly_amount = $_POST['monthly_amount'];
    $duration_in_months = $_POST['duration_in_months'];

    $balance = new User();
    $account_balance = $balance->getUserAccountBalance($userId);
    if ($account_balance < $monthly_amount) {
        $error = "Insufficient balance";
    } else {
        $recurring_deposit = new User();

        $result = $recurring_deposit->createRecurringDeposit($userId, $monthly_amount, $duration_in_months);

        if ($result) {
            $intrest = new User();

            $intrestRateAmount = $intrest->calculateRdIntrestRate($monthly_amount, $duration_in_months);

            $intrest_amount = $intrestRateAmount[0];
            $intrest_rate = $intrestRateAmount[1];
            $success = "Recurring Deposit Account Created Successfully";
        } else {
            $error = " Error: Failed to Create Recurring Deposit Acccount.Please try again.";
            // echo $result;
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Recurring Deposit Account</title>
    <link rel="stylesheet" href="rd_form.css">
    <style>
        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .intrest_result {
            text-align: center;
        }

        .intrest_result h3 {
            color: lightseagreen;
        }
    </style>
</head>

<body>
    <h1>Create Recurring Deposit</h1>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="monthly_amount">Monthly Deposit Amount:</label>
            <input type="number" name="monthly_amount" id="monthly_amount" required>
            <label for="duration_in_months">Duration (in months):</label>
            <input type="number" name="duration_in_months" id="duration_in_months" required>
            <input type="submit" value="Create RD Account">
            <span class="success"><?php echo $success; ?></span>
            <span class="error"><?php echo $error; ?></span>

        </form>
        <div>
            <div class="intrest_result">
                <?php
                if ($result) {

                    echo "<h3>Based on your data</h3>";
                    echo "Intrest Rate : " . $intrest_rate . "</p><p>" . "Intrest Amount : " . $intrest_amount . "</p>";
                }
                ?>
            </div>
        </div>
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