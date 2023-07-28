# ZiffityAssessments


## Requirement of the Task

 Title : Star Rating System and Comment Box

  * Collecting the Rating and Comments from the user  (like Amazon,Flipkart,E-Commerce Stores)
  * Collected Ratings and Comments are displayed as a table
  * It included option to search comments 
  * The table will be shown in pagination

    
## Solution Approach

* starrating.html,starRating.cssand main.js are the files of star rating system and comments.
* the html file includes a star rating system ,comment box ,user Name,submit button and a search bar for searching comments.
* the comments ,selected rating and user name are displayed in a table format and pagination are included.
* In the js file a view model is created with observables select ratings ,user name and comments and also includes the function to to submit comments and the comments  are visible four(4) rows per page. 
* the submitted comments are filter and displayed them based on search input and pagination is implimented using observables .
* the require js is used for module loading and knockout library is loaded.


  ## Duration of the Task

  * Duration : 11hrs
  * ETA : 4hrs

    ## Test Cases

    [{5,"veera","very nice"},{4,"karthick","very good"},{3," ","very bad"},{1,"praveen"," "},{0,"dharun","excellent}]

    * all test cases are satisfies

      * no bugs are reported
