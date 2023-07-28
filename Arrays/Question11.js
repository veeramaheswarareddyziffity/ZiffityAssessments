
function sumOfSquares(array){
    var sum=0;
    for(var i=0;i<array.length;i++){
        sum+=Math.pow(array[i],2);
    }
    return sum;
}
var array=[0,1,2,3,4];
console.log(sumOfSquares(array));