function removeArray(array,n){
    var index=array.indexOf(n);
    if(index>-1){
        array.splice(index,1);
    }
    return array;
}
var array=[2,5,6,8];
var n=5;
console.log(removeArray(array,n));