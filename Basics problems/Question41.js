let int1=20;
let int2=30;
let int3=3;
if(int1===int2 && int2===int3 && int1===int3){
    console.log("30");
}
else if(int1===int2 || int2===int3 || int1===int3){
    console.log("20")
}
else{
    console.log("40");
}