var arr1=[10,20,10,40,50,60,70];
var indexes=[];
for(var i=0;i<arr1.length;i++){
    
    for(var j=i+1;j<arr1.length;j++){
        if(arr1[i]+arr1[j]===50){
            indexes.push(i);
            indexes.push(j);
            
        }
    }
}
console.log(indexes)