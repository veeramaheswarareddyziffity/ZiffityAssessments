let text="a";
if(text.length<=1){
    console.log(text);
}
else{
let text1=text.substring(1,text.length-1);
let res=(text.charAt(text.length-1)) +text1+text.charAt(0);
console.log(res);
}
