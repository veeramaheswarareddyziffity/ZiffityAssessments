function leapYear(start,end){
    var years=[];
    for(var i=start;i<=end;i++){
        years.push(i);
    }
    var leap_year=[];
    for(var i=0;i<years.length;i++){
        if((years[i]%4==0&&years[i]%100!=0)||(years[i]%100==0&&years[i]%400==0)){
            leap_year.push(years[i]);
        }
        
    }
    console.log(leap_year);
}
leapYear(2000,2012);