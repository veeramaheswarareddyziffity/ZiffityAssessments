let int1=-20;
let int2=-10;
if(int1 != int2){
    int3=Math.abs(int1-100);
    int4=Math.abs(int2-100);

    if(int3<int4){
        console.log(int1 + " is the nearest to 100");
    }
    else if(int4<int3){
        console.log(int2+" is the nearest to 100")
    }
}
else{
    console.log("Both are same,So both are nearest to 100")
}