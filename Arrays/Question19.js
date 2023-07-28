var arr1=[1,0,2,3,4];
var arr2=[3,5,6,7,8,13];
var newArray=[];
var count=0;
var i=0;
while(count<arr1.length && count<arr2.length){
    newArray.push(arr1[count]+arr2[count]);
    count++;
}
if(count==arr1.length){
    for(i=count;i<arr2.length;i++){
        newArray.push(arr2[i])
    }
}
else{
    for(i=count;i<arr1.length;i++){
        newArray.push(arr1[i]);
    }
}
console.log(newArray);