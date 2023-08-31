<?php
// require '/var/www/html/assesment/PHP_Assesment/DbConnection.php';
class AccountData
{
    public function displayIndividualAccount($userId)
    {
        try {
            $conn = DBConnection::getConnection();
            $stmt = $conn->prepare("SELECT id,account_number,balance FROM ind_accounts WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return [
                    'accountId' => $row['id'],
                    'accountNumber' => $row['account_number'],
                    'accountType' => 'Single',
                    'balance' => $row['balance']
                ];
            } else {
                return null; // Indicate no account found
            }
            $stmt->close();
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public static function displayJointAccount($userId)
    {
        try {
            $conn = DBConnection::getConnection();
            $stmt = $conn->prepare("SELECT id, account_number, balance FROM joint_accounts WHERE user1_id = ? OR user2_id = ?");
            $stmt->bind_param("ii", $userId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $accountId = $row['id'];
                $accountNumber = $row['account_number'];
                $balance = $row['balance'];

                return [
                    'accountId' => $accountId,
                    'accountType' => 'Joint Account',
                    'accountNumber' => $accountNumber,
                    'balance' => $balance
                ];
            } else {
                return null;
            }
            $stmt->close();
        } catch (Exception $e) {
            return [
                'error' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function getFixedDeposits($userId, $accountType)
    {
        try {
            $conn = DBConnection::getConnection();
            $fd_history = [];

            if ($accountType === 'single') {
                $query = "SELECT user_id, principal_amount, interest_rate, intrest_amount, maturity_amount, duration_in_months, created_at FROM fixed_deposits WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $fd_history[] = $row;
                }
                $stmt->close();
            } elseif ($accountType === 'joint') {
                $query = "SELECT user1_id, user2_id FROM joint_accounts WHERE user1_id = ? OR user2_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $userId, $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $userId1 = $row['user1_id'];
                    $userId2 = $row['user2_id'];
                }
                $stmt->close();

                $query = "SELECT user_id, principal_amount, interest_rate, intrest_amount, maturity_amount, duration_in_months, created_at FROM fixed_deposits WHERE user_id IN (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $userId1, $userId2);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $fd_history[] = $row;
                }
                $stmt->close();
            }

            return $fd_history;
        } catch (Exception $e) {
            return [
                'error' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }


    public function getRecurringDeposits($userId, $accountType)
    {
        try {
            $conn = DBConnection::getConnection();
            $rd_history = [];

            if ($accountType === 'single') {
                $query = "SELECT user_id, monthly_amount, interest_rate, intrest_amount, maturity_amount, duration_in_months, principal_amount, created_at FROM recurring_deposits WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $rd_history[] = $row;
                }
                $stmt->close();
            } elseif ($accountType === 'joint') {
                $query = "SELECT user1_id, user2_id FROM joint_accounts WHERE user1_id = ? OR user2_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $userId, $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $userId1 = $row['user1_id'];
                    $userId2 = $row['user2_id'];
                }
                $stmt->close();

                $query = "SELECT user_id, monthly_amount, interest_rate, intrest_amount, maturity_amount, duration_in_months, principal_amount, created_at FROM recurring_deposits WHERE user_id IN (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $userId1, $userId2);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $rd_history[] = $row;
                }
                $stmt->close();
            }
            return $rd_history;
        } catch (Exception $e) {
            return [
                'errorMessage' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function isUsernameAvailable($username)
    {
        try {
            $conn = DBConnection::getConnection();
            $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();
            return $result->num_rows > 0;
        } catch (Exception $e) {
            return false; // Return false in case of an error
        }
    }

    public function getTransaction($userId, $accountType)
    {
        try {
            $conn = DBConnection::getConnection();
            $transaction_history = [];

            if ($accountType === 'single') {
                $query = "SELECT user_id, account_type, transaction_type, amount, description, transaction_date FROM transactions WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $transaction_history[] = $row;
                }
                $stmt->close();
            } elseif ($accountType === 'joint') {
                $query = "SELECT user1_id, user2_id FROM joint_accounts WHERE user1_id = ? OR user2_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $userId, $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $userId1 = $row['user1_id'];
                    $userId2 = $row['user2_id'];
                }
                $stmt->close();

                $query = "SELECT user_id, account_type, transaction_type, amount, description, transaction_date FROM transactions WHERE user_id IN (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $userId1, $userId2);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $transaction_history[] = $row;
                }
                $stmt->close();
            }

            return $transaction_history;
        } catch (Exception $e) {
            return [
                'error' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }
}
