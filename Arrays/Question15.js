var color = ["Blue ", "Green", "Red", "Orange", "Violet", "Indigo", "Yellow"];
const o = ["th", "st", "nd", "rd"];

function displayColors() {
  for (let i = 0; i < color.length; i++) {
    let choice = (i + 1) + o[i + 1] || o[0];
    console.log(`${choice} choice is ${color[i]}.`);
  }
}
displayColors();
