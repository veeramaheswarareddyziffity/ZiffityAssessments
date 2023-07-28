function areaOfTraingle(){
    let a1=5;
    let b1=6;
    let c1=7;
    let res=((a1+b1+c1)/2);
    let area= Math.sqrt(res*((res-a1)*(res-b1)*(res-c1)));
    return area;
}
console.log(areaOfTraingle());