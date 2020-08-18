if (!localStorage.getItem("address")) window.location = "/order";

let meals = document.querySelectorAll(".meal");
let btn = document.getElementsByClassName("pick-btn")[0];

btn.onclick = () => {
  let list = [];
  Array.from(meals).forEach((meal, index) => {
    if (meal.children[2].value != 0) {
      let o = new Object();
      o.id = meal.getAttribute("data-id");
      o.quant = meal.children[2].value;
      o.name = meal.children[0].innerHTML.replace(/[\n\t]+/gm, "");
      o.price = parseInt(meal.children[1].innerHTML.substr(7));
      list.push(o);
    }
  });

  if (list.length > 0) {
    localStorage.setItem("list", JSON.stringify(list));
    window.location = "/order/summary";
  } else alert("You need to pick something");
};
