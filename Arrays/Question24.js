var library= [
    { author: 'Bill Gates', title: 'The Road Ahead', libraryID:
    1254},
    { author: 'Steve Jobs', title: 'Walter Isaacson',
libraryID: 4264},
{ author: 'Suzanne Collins', title: 'Mockingjay: The Final Book of The Hunger Games', libraryID: 3245}
];
function sortByTitle(a,b){
    if(a.title<b.title){
        return -1;
    }
    if(a.title>b.title){
        return 1;
    }
    return 0;
}
library.sort(sortByTitle);
console.log(library);