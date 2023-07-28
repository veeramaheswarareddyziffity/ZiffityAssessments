# ZiffityAssessments
## Task Requirements 
- Create an online banking website
- sign up and login page with password encryption 
- should work for both single account and joint accounts
- have facility to open RD and FD and you have to calculate the interest rate based on the 	    	duration of deposit
- have fund transfer option
- show transaction history
- add validations wherever applicable


# solution approach
 
 
 * create the tables for the project we need 
 
* There will be a two buttons signup and login ,in signup page there will be two forms one is individual account and another form is joint account,the account number and account_type will         create automatically for both accounts after signup.
 * in login page the credentails will take from the user and verify credentials from database.
* after login it direct to the dashboard page ,in that page the account details and 	deposit ,withdraw and etc.
* in deposit and withdraw function will work similarly after succussful transaction it will store in transaction table and update the balnance in user account.
* fixed deposit and recurring deposit have different functions and based on duration of months the intrest rate is selecting and calculate the intrest amount also and return both values .after     the successful deposits the data will store that desired tables ,and also stored 	 in transaction table;
* the fund transfer ,taking reciever account number and search in database and update sender 	balance and receiver balance and update the transaction history
* the transaction history also shown based on login user.
* And also applying validation wherever needed.
