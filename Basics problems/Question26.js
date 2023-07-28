let text="hel";
if(text.length<3){
    console.log(text);
}
else{
    let text1=text.substr(-3);
    let res=text1 + text + text1;
    // let str=text.substring(text.length-3,text.length);
    // let res=str + text + str;
    
    console.log(res);
}