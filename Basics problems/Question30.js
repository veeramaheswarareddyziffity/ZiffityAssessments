let text="hellScripto world";
let check="Script";
if(text.substr(4,check.length)===check){
    let res=text.substring(0,4) + text.substring((4+check.length),text.length);
    console.log(res);
}
else{
    console.log(text);
}