var arr1=[1,2,3];
var arr2=[100,2,1,10];
var newArray=[];
for(var i=0;i<arr1.length;i++){
    for(var j=0;j<arr2.length;j++){
        if(arr1[i]==arr2[j]){
            var index=arr2.indexOf(arr2[j]);
            arr2.splice(index,1);
        }
        
    }
    newArray.push(arr1[i]);
}
for(var i=0;i<arr2.length;i++){
    newArray.push(arr2[i]);
}
console.log(newArray);