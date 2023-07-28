
<?php
session_start();
require 'user.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$user = new User();

$account_type = $user->getAccountType($userId);

// to display individual account details
function displayIndividualAccount($userId)
{
    $conn = DBConnection::getConnection();
    $stmt = $conn->prepare("SELECT id,account_number,balance FROM ind_accounts WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $accountId = $row['id'];
        $accountNumber = $row['account_number'];
        $balance = $row['balance'];

        echo "Account Id: $accountId <br>";
        echo "Account Type: single <br>";
        echo "Account Number: $accountNumber<br>";
        echo "Balance : $balance";
        // Display other individual account details as needed
    } else {
        echo "No individual account details found for this user.";
    }
    $stmt->close();
}

//to display joint account details

function displayJointAccount($userId)
{
    $conn = DBConnection::getConnection();
    $stmt = $conn->prepare("SELECT id,account_number,balance FROM joint_accounts WHERE user1_id = ? OR user2_id = ?");
    $stmt->bind_param("ii", $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $accountId = $row['id'];
        $accountNumber = $row['account_number'];
        $balance = $row['balance'];

        echo "Account Id: $accountId <br>";
        echo "Account Type: Joint Account<br>";
        echo "Account Number: $accountNumber<br>";
        echo "Balance : $balance";
    } else {
        echo "No joint account details found for this user.";
    }
    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $depo_succ = $depo_err = "";
    $with_succ = $with_err = "";
    if (isset($_POST["deposit_submit"])) {
        $deposit_amount = $_POST['deposit_amount'];

        $deposit_money = new User();


        $result = $deposit_money->depositMoney($userId, $deposit_amount);

        if ($result) {
            $depo_succ = "deposit of $deposit_amount was successful";
        } else {
            $depo_err = "Error:Deposit failed";
        }
    }
    if (isset($_POST["withdraw_submit"])) {
        $withdraw_amount = $_POST['withdraw_amount'];

        $balance = new User();
        $account_balance = $balance->getUserAccountBalance($userId);
        
        if ($account_balance < $withdraw_amount) {
            $with_err = "Insufficient balance";
        } 
        else {
            $withdraw_Money = new User();


            $result = $withdraw_Money->withdrawMoney($userId, $withdraw_amount);


            if ($result) {
                $with_succ = "withdraw of $withdraw_amount was successful";
            } else {
                $with_err =  "Error:Withdraw failed";
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
    <h1>Welcome to our Bank</h1>
    <?php
    // display account details 
    if ($account_type === 'single') {
        displayIndividualAccount($userId);
    } elseif ($account_type === 'joint') {
        displayJointAccount($userId);
    }
    ?>

    <h3>Deposite : </h3>

    <div class="form-container" id="depositForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
            <label for="deposit_amount">Deposit Amount:</label>
            <input type="number" name="deposit_amount" id="deposit_amount" required>
            <input type="submit" name="deposit_submit" value="Deposit"><br>
            <span class="success"><?php echo $depo_succ; ?></span>
            <span class="error"><?php echo $depo_err; ?></span>
        </form>
    </div>

    <h3>Withdraw : </h3>
    <div class="form-container" id="withdrawForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="withdraw_amount">Withdraw Amount:</label>
            <input type="number" name="withdraw_amount" id="withdraw_amount" required>
            <input type="submit" name="withdraw_submit" value="Withdraw"><br>
            
            <span class="success"><?php echo $with_succ;?></span>
            <span class="error"><?php echo $with_err; ?></span>
        </form>
    </div>
    <div class="button-container">
        <div><span class="formBtn"><a href="fd_Form.php" >Fixed Deposit</a></span> </div>
        <div><span class="formBtn"><a href="rd_Form.php" >RecurringDeposit</a></span> </div>
        <div><span class="formBtn"><a href="fund_Form.php" >Fund Transfer</a></span> </div>
        <div><span class="formBtn"><a href="transaction.php" >Show Transactions</a></span> </div>
        <div><span class="formBtn"><a href="deposits.php"  >Deposits</a></span> </div>
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