function binarySearch(arr,key){
    var index=-1;
    var l=0;
    var h=arr.length-1;
    while(l<=h){
     var mid=Math.floor((l+h)/2);
     if(arr[mid]==key){
         index=mid;
         break;
     }
     else if(arr[mid]>key ){
         h=mid-1;
     }
     else if(arr[mid]<key){
         l=mid+1;
     }
    }
    return index;
 }
console.log(binarySearch([1,2,3,4,5,7,8,9],5));