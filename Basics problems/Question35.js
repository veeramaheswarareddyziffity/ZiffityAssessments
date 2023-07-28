let text="helloWorld";
let char="d";
let temp=0;
for(let i=0;i<=text.length;i++){
    if(text.charAt(i)===char && (i>=1 && i<=3)){
        temp=1;
        break;
    }
}
if(temp==1){
    console.log("true");

}
else{
    console.log("false");
}
