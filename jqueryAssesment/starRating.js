$(document).ready(function(){
    $('#Comment-table').hide();

    $("input").focus(function(){
      $(this).css("background-color", "gainsboro");
    });
    $("input").blur(function(){
      $(this).css("background-color", "white");
    });

    $("#submitbtn").on({
        mousedown:function(){
      $(this).css({"background-color": "white"})
        },
       mouseup :function(){
        $(this).css({"background-color": "pink"})

     } 
  });
    

    var currentRating=0;
    $("#star-rating .star").on('click',function(){
        // currentRating = $(this).data("rating");
        currentRating = $(this).attr("id");
        $(this).addClass('active');
        $(this).prevAll('.star').addClass('active');
        $(this).nextAll('.star').removeClass('active');
    });
   
    $("#submitbtn").click(function(){
        
        $('#Comment-table').show();
       var comment=$("#comment").val();
        var name=$("#name").val();
       if (currentRating === 0) {
        alert('Please select a rating!');
        return;
      }
      if (name === '') {
        alert('Please enter a name!');
        return;
      }
  
      if (comment === '') {
        alert('Please enter a comment!');
        return;
      }
    //   $('#Comment-table').show();

      
      var newRow = "<tr><td>"+ name+"</td><td>" + currentRating + "</td><td>" + comment + "</td></tr>";
      $('#Comment-table tbody').append(newRow);

      currentRating=0;
      $('.star').removeClass('active');
      $('#name').val('');
      $('#comment').val('');
      
      applyPagination();
      applySearch();
      
    });

    
   

    var rowsPerPage = 4;
    var currentPage = 1;
  
    function applyPagination() {
      var totalRows = $('#Comment-table tbody tr').length;
      var numPages = Math.ceil(totalRows / rowsPerPage);
  
      var paginationLinks = '';
      for (var i = 1; i <= numPages; i++) {
        paginationLinks += '<a href="#" class="pagination-links" id="' + i + '">' + i + '</a> ';
      }
      $('#pagination').html(paginationLinks);
  
      
      showPage(currentPage);
    }
  
    
    function showPage(pageNum) {
      var start = (pageNum - 1) * rowsPerPage;
      var end = start + rowsPerPage;
  
      $('#Comment-table tbody tr').hide();
      $('#Comment-table tbody tr').slice(start, end).show();

      currentPage = pageNum;
    }
    
    $('#pagination').on('click',"a", function() {
      var pageNum = $(this).attr('id');
      showPage(pageNum);
    });
    
    function applySearch() {
      $('#searchInput').keyup(function() {
        var searchText = $(this).val().toLowerCase();
  
        // $('#Comment-table tbody tr').filter(function() {
        //   var commentText = $(this).text().toLowerCase();
        //   return $(this).toggle(commentText.indexOf(searchText) !== -1);
        // });

       

        $("#Comment-table tbody tr").filter(function(){
          var commentText = $(this).text().toLowerCase();
           if(commentText.indexOf(searchText) > -1){
            return $(this).show();
           }
           else{
            return $(this).hide();
           }
        });
      });

    
    
    }
  
    

});