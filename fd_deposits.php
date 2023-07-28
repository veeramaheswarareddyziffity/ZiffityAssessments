<?php
require 'user.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$user = new User();
$account_type = $user->getAccountType($userId);

function getFixedDeposits($userId,$account_type){
    $conn = DBConnection::getConnection();

    if($account_type === 'single'){

        $query = "SELECT user_id,principal_amount,interest_rate,intrest_amount,maturity_amount,duration_in_months,created_at FROM fixed_deposits WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",$userId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $fd_history[] = $row;
        }
        $stmt->close();
        
    }
    elseif($account_type === 'joint'){
        $query = "SELECT user1_id,user2_id FROM joint_accounts WHERE user1_id = ? OR user2_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii",$userId,$userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $userId1 = $row['user1_id'];
            $userId2 = $row['user2_id'];
        }
        $stmt->close();
        
        $query = "SELECT user_id,principal_amount,interest_rate,intrest_amount,maturity_amount,duration_in_months,created_at FROM fixed_deposits WHERE user_id IN (?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii",$userId1,$userId2);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $fd_history[] = $row;
        }
        $stmt->close();
        


    }
    return $fd_history;

}
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
<h2>Fixed Deposits</h2>
    
<?php
$details = getFixedDeposits($userId,$account_type);

if (!empty($details)) {
   
    echo '<table>';
    echo '<tr><th>User ID</th><th>Principal_amount</th><th>Intrest_Rate</th><th>Maturity_Amount</th><th>Duration(in months)</th><th>Created_at</th></tr>';
    foreach ($details as $fd) {
        echo '<tr>';
        echo '<td>' . $fd['user_id'] . '</td>';
        echo '<td>' . $fd['principal_amount'] . '</td>';
        echo '<td>' . $fd['interest_rate'] . '</td>';
        echo '<td>' . $fd['maturity_amount'] . '</td>';
        echo '<td>' . $fd['duration_in_months'] . '</td>';
        echo '<td>' . $fd['created_at'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} 
else {
    echo 'No Fixed Deposits found.';
}
?>
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