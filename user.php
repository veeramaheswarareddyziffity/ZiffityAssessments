<?php
require '/var/www/html/assesment/PHP_Assesment/DB_Connection.php';
// echo "reddy";
class User{

    //signup process 

    public function signup($username,$password,$account_type,$balance,$username2 = null ,$password2 = null){
        if($account_type === 'single'){
            $userId = $this->createUser($username,$password,$account_type);
            $this->createSingleAccount($userId,$balance);
            return true;
        }
        if($account_type === 'joint'){
            $userId1 = $this->createUser($username,$password,$account_type);
            $userId2 = $this->createUser($username2,$password2,$account_type);
            $this->createJointAccount($userId1,$userId2,$balance);
            return true;
        }

        return null;
    }


    //creating users

    private function createUser($username,$password,$account_type){
        $conn = DBConnection::getConnection();
        // echo $username;
    
        // echo $password;
    
        // echo $account_type;
    
        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        $stmt = $conn->prepare("INSERT INTO users(username, password, account_type) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $encryptedPassword, $account_type);
        $stmt->execute();
        $stmt->close();
        
        $userId = $this->getUserIdByUsername($username);
        return $userId;
    }

    //getting userId by username

    public function getUserIdByUsername($username){
        $conn = DBConnection::getConnection();

        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $userId = $row['id'];

        $stmt->close();

        return $userId;
    }

    //getting accountType by user id
    public function getAccountType($user_id){
        $conn = DBConnection::getConnection();
        $stmt = $conn->prepare("SELECT account_type FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['account_type'];
        } else {
            return null; // invalid user_id
        }
        $stmt->close();
    }

    public function getUserAccountNumber($userId){
        $conn = DBConnection::getConnection();

        $account_type = $this->getAccountType($userId);
        if($account_type === 'single'){
            $stmt = $conn->prepare("SELECT account_number FROM ind_accounts WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $accountNumber = $row['account_number'];
               
            }
            $stmt->close();
            return $accountNumber;
        }
        if($account_type === 'joint'){
            $stmt = $conn->prepare("SELECT account_number FROM joint_accounts WHERE user1_id = ? OR user2_id = ?");
            $stmt->bind_param("ii", $userId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                $accountNumber = $row['account_number'];
            
            }
            $stmt->close();
            return $accountNumber;
        }
        
    }


    public function getUserAccountBalance($userId){
        $conn = DBConnection::getConnection();

        $account_type = $this->getAccountType($userId);
        if($account_type === 'single'){
            $stmt = $conn->prepare("SELECT balance FROM ind_accounts WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $balance = $row['balance'];
               
            }
            $stmt->close();
            return $balance;
        }
        if($account_type === 'joint'){
            $stmt = $conn->prepare("SELECT balance FROM joint_accounts WHERE user1_id = ? OR user2_id = ?");
            $stmt->bind_param("ii", $userId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                $balance = $row['balance'];
            
            }
            $stmt->close();
            return $balance;
        }
        
    }
    

    //login process

    public function login($username,$password){
        $conn = DBConnection::getConnection();
        $stmt = $conn->prepare("SELECT id,password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            return $userId;
        }
    }

    return false;

    }


    //creating individual account

    private function createSingleAccount($userId,$balance){
        $conn = DBConnection::getConnection();

        $accountNumber = "IND" . time(); //unique account number

        $stmt = $conn->prepare("INSERT INTO ind_accounts (account_number,user_id,balance) VALUES (?,?,?)");

        $stmt->bind_param("sid",$accountNumber,$userId,$balance);
        $stmt->execute();
        $stmt->close();
        $this->depositMoney($userId,$balance);
    }


    private function createJointAccount($userId1,$userId2,$balance){
        $conn = DBConnection::getConnection();

        $accountNumber = "JNT" . time(); // unique account number

        $stmt = $conn->prepare("INSERT INTO joint_accounts (account_number,user1_id,user2_id,balance) VALUES (?,?,?,?)");

        $stmt->bind_param("siid",$accountNumber,$userId1,$userId2,$balance);

        $stmt->execute();
        $stmt->close();
        $this->depositMoney($userId1,$balance);

    }


    //depositing money

    public function depositMoney($userId,$deposit_amount){
         
        // echo "enter the function"; 
        $conn = DBConnection::getConnection();
        // echo "enter the conn"; 

        $account_type = $this->getAccountType($userId);

        // echo "enter the acounttype"; 
        if ($deposit_amount <= 0) {

            $conn->close();
            return false;
        }

        if($account_type === 'single'){
            
            $stmt = $conn->prepare("UPDATE ind_accounts SET balance = balance + ? WHERE user_id = ?");
            $stmt->bind_param("di",$deposit_amount,$userId);
           
        }
        elseif($account_type === "joint"){
            $stmt = $conn->prepare("UPDATE joint_accounts SET balance = balance + ? WHERE user1_id = ? OR user2_id = ?");
            $stmt->bind_param("dii",$deposit_amount,$userId,$userId);
        }
        else{
            $conn->close();
            return false;
        }

        if($stmt->execute()){
            $transaction_type = 'deposite';
            $description = "Deposited +$deposit_amount";

            $trans_stmt = $conn->prepare("INSERT INTO transactions(user_id, account_type, transaction_type, amount, description) VALUES (?, ?, ?, ?, ?)");
            $trans_stmt->bind_param("issds", $userId, $account_type, $transaction_type, $deposit_amount, $description);
            $trans_stmt->execute();
            $trans_stmt->close();
            $conn->close();

            return true;
        }
        else{
            $conn->close();
            return false;
        }


    }


    public function withdrawMoney($userId,$withdraw_amount){
        // echo $withdraw_amount;
        $conn = DBConnection::getConnection();
     
        $account_type = $this->getAccountType($userId);

        if ($withdraw_amount < 500 ) {

            $conn->close();
            return false;
        }
       
        if($account_type === 'single'){
            // echo $withdraw_amount;
            $stmt = $conn->prepare("UPDATE ind_accounts SET balance = balance - ? WHERE user_id = ?");
            // echo $account_type;
            $stmt->bind_param("di",$withdraw_amount,$userId);
           
        }
        elseif($account_type === "joint"){
           
            $stmt = $conn->prepare("UPDATE joint_accounts SET balance = balance - ? WHERE user1_id = ? OR user2_id = ?");
            $stmt->bind_param("dii",$withdraw_amount,$userId,$userId);
            // echo $withdraw_amount;
        }
        else{
            $conn->close();
            return false;
        }
        // echo $withdraw_amount;
        if($stmt->execute()){
            // echo $withdraw_amount;
            $transaction_type = 'withdraw';
            $description = "Withdraw -$withdraw_amount";
           

            $trans_stmt = $conn->prepare("INSERT INTO transactions(user_id, account_type, transaction_type, amount, description) VALUES (?, ?, ?, ?, ?)");
            $trans_stmt->bind_param("issds", $userId, $account_type, $transaction_type, $withdraw_amount, $description);
            $trans_stmt->execute();
            $trans_stmt->close();
            $conn->close();

            return true;
        }
        else{
            $conn->close();
            return false;
        }

    }

    //calculate intrest for fixed deposite
    public function calculateFdInterestRate($amount, $duration_in_months) {
       
        $intrest_rate_per_annum = 0.0;
    
        if ($duration_in_months > 0 && $duration_in_months <= 6) {
            $intrest_rate_per_annum = 3.0;
        } 
        elseif ($duration_in_months > 6 && $duration_in_months <= 12) {
            $intrest_rate_per_annum = 4.0;
        } 
        elseif ($duration_in_months > 12 && $duration_in_months <= 24) {
            $intrest_rate_per_annum = 5.0;
        } 
        elseif ($duration_in_months > 24) {
            $intrest_rate_per_annum= 6.0;
        }
    
        $duration_in_years = $duration_in_months / 12;
        $intrest_amount = ($amount * $intrest_rate_per_annum * $duration_in_years) / 100;
    
    return [$intrest_amount,floatval($intrest_rate_per_annum)];
    }
    

    // calculate intrest for recurring deposite
    public function calculateRdIntrestRate($monthly_amount,$duration_in_months){

        $intrest_rate_per_annum = 0.0;

        if ($duration_in_months > 0 && $duration_in_months <= 6) {
            $intrest_rate_per_annum = 3.0;
        } 
        elseif ($duration_in_months > 6 && $duration_in_months <= 12) {
            $intrest_rate_per_annum = 4.0;
        } 
        elseif ($duration_in_months > 12 && $duration_in_months <= 24) {
            $intrest_rate_per_annum = 5.0;
        } 
        elseif ($duration_in_months > 24) {
            $intrest_rate_per_annum= 6.0;
        }


        $intrest_amount = ($monthly_amount/12) * ($intrest_rate_per_annum/100 )* (($duration_in_months * ($duration_in_months + 1))/2);

        return [$intrest_amount,floatval($intrest_rate_per_annum)] ;
        
    }

    // creating fixed deposit

    public function createFixedDeposit($userId,$amount,$duration_in_months){
        $conn = DBConnection::getConnection();

        if ($amount <= 0 || $duration_in_months <= 0) {
            
            // echo "fialed1";
            $conn->close();
            return false;
        }
        $user_balance = $this->getUserAccountBalance($userId);

        $account_type = $this->getAccountType($userId);

        if( $user_balance < $amount ){
            $conn->close();
            // echo "fialed2";
            return false;
        }

        $intrest_rate = $this->calculateFdInterestRate($amount,$duration_in_months);
         
        $intrest_amount = $intrest_rate[0];

        $intrest_rate_per_annum = $intrest_rate[1];

        $maturity_amount = $amount + $intrest_amount;

        if($account_type === 'single'){
            $update_balance_stmt=$conn->prepare("UPDATE ind_accounts SET balance = balance - ? WHERE user_id = ?");
            $update_balance_stmt->bind_param("di",$amount,$userId);
        }
        elseif($account_type === "joint"){
           
            $update_balance_stmt = $conn->prepare("UPDATE joint_accounts SET balance = balance - ? WHERE user1_id = ? OR user2_id = ?");
            $update_balance_stmt ->bind_param("dii",$amount,$userId,$userId);
            
        }
        else{
            $conn->close();
            return false;
        }

        if($update_balance_stmt->execute()){
            
            $transaction_type = 'fixed Deposit';
            $description = "Fixed Deposite -$amount";
           

            $trans_stmt = $conn->prepare("INSERT INTO transactions(user_id, account_type, transaction_type, amount, description) VALUES (?, ?, ?, ?, ?)");
            $trans_stmt->bind_param("issds", $userId, $account_type, $transaction_type, $amount, $description);
            $trans_stmt->execute();
            $trans_stmt->close();
           
        }
        else{
            $conn->close();
            return false;
        }

        $fd_stmt = $conn->prepare("INSERT INTO fixed_deposits (user_id, principal_amount, interest_rate,intrest_amount,maturity_amount,duration_in_months) VALUES (?,?,?,?,?,?)");
        $fd_stmt->bind_param("ididdi", $userId, $amount, $intrest_rate_per_annum,$intrest_amount, $maturity_amount, $duration_in_months);
        $fd_stmt->execute();
        $fd_stmt->close();
        
        $conn->close();

        return true;

    }

    public function createRecurringDeposit($userId,$monthly_amount,$duration_in_months){

        $conn = DBConnection::getConnection();
       
       
        if ($monthly_amount <= 0 || $duration_in_months <= 0) {
            // echo "failed1";
            $conn->close();
            return false;
        }
        $user_balance = $this->getUserAccountBalance($userId);

        $account_type = $this->getAccountType($userId);

        if( $user_balance < $monthly_amount ){
            // echo "failed2";
            $conn->close();
            return false;
        }
       
        $intrest_rate = $this->calculateRdIntrestRate($monthly_amount,$duration_in_months);
        
        $intrest_amount = $intrest_rate[0];
        // echo $intrest_rate[1];
        $intrest_rate_per_annum = $intrest_rate[1];
        
        $principle_amount = ($monthly_amount * $duration_in_months);

        $maturity_amount = $principle_amount + $intrest_amount;

        if($account_type === 'single'){
            // echo  $duration_in_months;
            $update_balance_stmt=$conn->prepare("UPDATE ind_accounts SET balance = balance - ? WHERE user_id = ?");
            $update_balance_stmt->bind_param("di",$monthly_amount,$userId);
        }
        elseif($account_type === "joint"){
            // echo  $duration_in_months;
            $update_balance_stmt = $conn->prepare("UPDATE joint_accounts SET balance = balance - ? WHERE user1_id = ? OR user2_id = ?");
            $update_balance_stmt ->bind_param("dii",$monthly_amount,$userId,$userId);
            
        }
        else{
            echo  $duration_in_months;
            $conn->close();
            return false;
        }

        if($update_balance_stmt->execute()){
            
            $transaction_type = 'Recurring Deposit';
            $description = "Recurring Deposit -$monthly_amount";
           

            $trans_stmt = $conn->prepare("INSERT INTO transactions(user_id, account_type, transaction_type, amount, description) VALUES (?, ?, ?, ?, ?)");
            $trans_stmt->bind_param("issds", $userId, $account_type, $transaction_type, $monthly_amount, $description);
            $trans_stmt->execute();
            $trans_stmt->close();
           
        }
        else{
            $conn->close();
            return false;
        }
        // echo $intrest_rate_per_annum;
        $rd_stmt = $conn->prepare("INSERT INTO recurring_deposits (user_id, monthly_amount, interest_rate,intrest_amount,maturity_amount,duration_in_months,principal_amount) VALUES (?,?,?,?,?,?,?)");
        $rd_stmt->bind_param("ididdid", $userId, $monthly_amount, $intrest_rate_per_annum,$intrest_amount, $maturity_amount, $duration_in_months,$principle_amount);
        $rd_stmt->execute();
        $rd_stmt->close();
        
        $conn->close();

        return true;

     }

    public function getAccTypeUserIdFromAccountNumber($account_number){

        $conn = DBConnection::getConnection();

        $query = "SELECT u.account_type,u.id
              FROM users u
              LEFT JOIN ind_accounts ia ON u.id = ia.user_id
              LEFT JOIN joint_accounts ja ON u.id = ja.user1_id OR u.id = ja.user2_id
              WHERE ia.account_number = ? OR ja.account_number = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $account_number, $account_number);
        $stmt->execute();

       
        $stmt->bind_result($account_type,$userId);
        if ($stmt->fetch()) {    
            $stmt->close();
            $conn->close();
            return ['account_type'=>$account_type,'userId' =>$userId];
        }
        $stmt->close();
        $conn->close();
        return null;

    }

    public function transferFunds($userId,$reci_acc_num,$trans_amount){

        $conn = DBConnection::getConnection();

        

        if ($trans_amount <= 0) {
            
            $conn->close();
            return false;
        }
         

        $sender_balance = $this->getUserAccountBalance($userId);
        
        $sender_acc_num =$this->getUserAccountNumber($userId);

       

        $sender_account_type = $this->getAccountType($userId);
        
        $receiver_account_type_id = $this->getAccTypeUserIdFromAccountNumber($reci_acc_num);

        $receiver_account_type = $receiver_account_type_id['account_type'];

        $receiver_id = $receiver_account_type_id['userId'];
       
        if ($trans_amount < $sender_balance) {
            // echo $reci_acc_num;
            $conn->close();
            return false;
        }
        
        if ($sender_account_type === 'single') {
            
            $sender_update_stmt = $conn->prepare("UPDATE ind_accounts SET balance = balance - ? WHERE user_id = ?");
            $sender_update_stmt->bind_param("di", $trans_amount, $userId);
        } 
        else if ($sender_account_type === 'joint') {

            $sender_update_stmt = $conn->prepare("UPDATE joint_accounts SET balance = balance - ? WHERE user1_id = ? OR user2_id=?");
            $sender_update_stmt->bind_param("dii", $trans_amount, $userId,$userId);
            // echo $sender_acc_num;
        } 
        else {
            
            $conn->close();
            return false;
        }

        
        $sender_update_stmt->execute();
        $sender_update_stmt->close();

        if ($receiver_account_type === 'single') {
            
            $receiver_update_stmt = $conn->prepare("UPDATE ind_accounts SET balance = balance + ? WHERE account_number = ?");
            
        } 
        else if ($receiver_account_type === 'joint') {
            $receiver_update_stmt = $conn->prepare("UPDATE joint_accounts SET balance = balance + ? WHERE account_number = ?");
        }
         else {
            
            $conn->close();
            return false;
        }

        $receiver_update_stmt->bind_param("ds",$trans_amount,$reci_acc_num);
        
        $receiver_update_stmt->execute();
        $receiver_update_stmt->close();


        $transaction_type = 'fund_transfer';
        $sender_description = "Transferred $trans_amount to Account Number: $reci_acc_num";
        

        $sender_transaction_stmt = $conn->prepare("INSERT INTO transactions (user_id, account_type, transaction_type, amount, description) VALUES (?, ?, ?, ?, ?)");
        $sender_transaction_stmt->bind_param("issds", $userId, $sender_account_type, $transaction_type, $trans_amount, $sender_description);
        
        $sender_transaction_stmt->execute();
        // echo $reci_acc_num;
        $sender_transaction_stmt->close();

        $receiver_description = "Received $trans_amount from Account Number: $sender_acc_num";

        $receiver_transaction_stmt = $conn->prepare("INSERT INTO transactions (user_id, account_type, transaction_type, amount, description) VALUES (?, ?, ?, ?, ?)");
        $receiver_transaction_stmt->bind_param("issds", $receiver_id, $receiver_account_type, $transaction_type, $trans_amount, $receiver_description);
        $receiver_transaction_stmt->execute();
        $receiver_transaction_stmt->close();

        
        $conn->close();

        
        return true;

    }
    

    
}


?>