let today=new Date();
const day=today.getDay();
const daylist=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
console.log("Today is:"+daylist[day]+".");
let hour=today.getHours();
let minutes=today.getMinutes();
let seconds=today.getSeconds();
let merd=(hour>=12)?"PM":"AM";
hour=(hour>=12)?hour-12:hour;
console.log("Current Time is:"+hour+ merd+":"+minutes+":"+seconds)