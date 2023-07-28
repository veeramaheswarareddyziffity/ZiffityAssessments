requirejs.config({
    baseUrl : "Lib" ,
    paths : {knockout : 'knockout-3.5.1'}
})

require(['knockout'],function(ko){
    function myComment(name,rating,comment){
        this.name =ko.observable(name);
        this.rating = ko.observable(rating);
        this.comment = ko.observable(comment) ;
    }
    
    function viewModel(){
        this.selectedRating = ko.observable(0);
        this.nameInput = ko.observable('');
        this.commentInput = ko.observable('');
        this.comments = ko.observableArray([]);
        this.commentsDisplay = ko.observableArray(this.comments());

        
        
    
        this.searchInput = ko.observable('');
         this.isVisible = ko.observable(false);
    
        this.selectRating = function(rating) {
        this.selectedRating(rating);
    }
    
    
        this.submitComment = function() {
            // console.log(this.totalPages())
            // console.log(this.nameInput());
            // console.log(this.commentInput())
    
            // console.log(this.totalPages())
            // console.log(this.pageNumbers())
            
    
            console.log(this.currentPage())
            
            console.log(this.comments())
            if (this.selectedRating() === 0) {
            alert('Please select a rating!');
            return ;
            }
    
            // console.log(this.paginatedComments())
        if (this.nameInput() === '') {
            alert('Please enter a name!');
            return ;
           
        } 
        if (this.commentInput() === '') {
            alert('Please enter a comment!');
            return ;
            
        }
        
        this.comments.push(new myComment(this.nameInput(),this.selectedRating(), this.commentInput()));
        this.isVisible(true);
        console.log(this.selectedRating())
        this.nameInput('');
        this.selectRating(0);
        this.commentInput('');
            console.log(this.commentsDisplay())
            
        
    };
    
            this.filteredComments = ko.computed(function(){
                var searchText = this.searchInput().toLowerCase();
                var filteredComment = [];
                var comments = this.comments();

                
               
                for(var i=0 ;i<comments.length ;i++){
                    // var comment = comments[i];
                    var filterName = comments[i].name().toLowerCase();
                    var filterComment = comments[i].comment().toLowerCase();
    
                    if(filterComment.indexOf(searchText) > -1 || filterName.indexOf(searchText) > -1){
                        filteredComment.push(comments[i]);
                    }
                }

                this.commentsDisplay(filteredComment)
                // console.log(this.commentsDisplay())
                // console.log(filteredComment)
                return filteredComment ;
    
            },this);
    
    
            this.rowsPerPage = ko.observable(4);
            this.currentPage = ko.observable(1); 
           
            this.totalPages = ko.computed(function(){
                var totalRows = this.filteredComments().length;
                var rowsPerPage = this.rowsPerPage();
                return Math.ceil(totalRows/rowsPerPage)
            },this);
    
    
            this.paginatedComments = ko.computed(function() {
                 var startIndex = (this.currentPage() - 1) * this.rowsPerPage();
                var endIndex = startIndex + this.rowsPerPage();
                return this.commentsDisplay().slice(startIndex, endIndex);
        
            },this);
    
            

            this.pageNumbers = ko.computed(function() {
                var numbers = [];
                for (var i = 1; i <= this.totalPages(); i++) {
                    numbers.push(i);
                 }
                // console.log(numbers)
             return numbers;
             }, this);

             
            this.previousPage = function() {
                if (this.currentPage() > 1) {
                 this.currentPage(this.currentPage() - 1);
                 }
             };
    
      
            this.nextPage = function() {
                if (this.currentPage() < this.totalPages()) {
                this.currentPage(this.currentPage() + 1);
                }
             };

             this.goToPage = function(pageNumber) {
                this.currentPage(pageNumber);
          
                };
    
             this.isActivePage = function(pageNumber) {
                return pageNumber === this.currentPage();
              };
              
    
    
    
    
    
    
        
    }
    ko.applyBindings(new viewModel());
})