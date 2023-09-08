# ZiffityAssessments
## Feedback Module
ETA: 24h

## TASK 1 :
	
    1. First Display the Customer Feedback Link at Footer, For that we need to modify the footer template to include a link to the customer feedback page .
    2. Create a new page for showing the feedback form ,in that feedback form we need to include following fields – First Name ,Last Name,Email,Comment text area.
    3. Include the Magento Form Validation.
    4.  After submitting the form data to the database table ,the page will redirect to the home page and display the succes message.
    5. Create a “Customer Feedback” tab under customer menu in admin panel.
    6. Implement the grid view to display the Submitted feedback data with sorting,searching and pagination. 
       
## TASK 2 :	

    1. Create a two buttons  “approve” and “Decline” in the admin grid for feedback records and also create a controller action for these two buttons. 
    2. Configure the magento to send emails to based on the approval/decline actions by admin .
    3. Add the Status Column to the grid to display aproval status.
    4.  Create a custom  block to display the approved feedback on the home page with a scroller and each record will be displayed individually in the scroller.
       
	
## TASK 3 :

    1. Modify the form if the customer is logged-in will populate the fields with the logged-in customer information.
    2. After form submission send the confirmation email to the  customer for that Modify the email functionality.
    3. Send a BCC email to the store admin and retrieve the admin email from magento cofiguration.
    4. Add a View link in the admin grid and Create a admin controller action to display the feedback details when view link is clicked.
    5. Create another landing page for displaying the feedback details and also include the approve and include buttons at the top of the feedback details for admin action.
