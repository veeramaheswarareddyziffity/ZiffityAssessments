$(document).ready(function(){
    // $('#container').hide();
    var count=0;
    var basket=0;
    $("#add").prop("disabled", true);
    $("#basket").on("click",function(){
      
        // $("#container").fadeIn(3000);
        $('#container').css({"visibility": "visible"});
        $("#container").empty();
        basket+=1;

        count=0;
        console.log("Basket:"+basket+"\n");
        $("#add").prop("disabled", false);

    })
      $("#add").on("click",function(){

        $("#container").append(`<span class="ball-in"></span>`);

    const arr=['red', 'blue', 'skyblue','darkgrey','brown','yellow',
     'lightgrey', 'darkorchid', 'black', 'orange', 'deeppink', 'green',
      'purple', 'saddlebrown', 'lightseagreen', 'deepskyblue', 'firebrick' ,'crimson'];
      const colorNum=Math.floor((Math.random() * arr.length));
      const ballcolor=arr[colorNum];
    //   console.log(ballcolor);
    
     const ball=$("span").eq(count);
      count+=1;
    
      ball.css({"background-color": ballcolor});
      console.log(count +":"+ballcolor);
      if(count==40){
        alert("Basket is Full");
        $("#add").prop("disabled", true);
        // $("#container").empty();
        // $("span").stop();
      }
  });

});