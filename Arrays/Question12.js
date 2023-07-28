
function sumOfSquaresProduct(array){
    var sum=0;
    var product=1;
    for(var i=0;i<array.length;i++){
        sum+=array[i];
        product*=array[i];
    }
    return sum+"\n"+product;
}
var array=[1,2,3,4,5];
console.log(sumOfSquaresProduct(array));