// JSON request
var getJSON = function(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", url, true);
  xhr.responseType = "json";
  xhr.onload = function() {
    var status = xhr.status;
    if (status === 200) {
      callback(null, xhr.response);
    } else {
      callback(status, xhr.response);
    }
  };
  xhr.send();
};

getJSON("/order/pick/json", function(err, data) {
  if (err !== null) {
    alert("Something went wrong: " + err);
    window.location.href = "/";
  } else {
    data = JSON.parse(data);
    const organiser = document.getElementById("pick");
    for (let i = 0; i < data.length; i++) {
      // Meal container
      let meal = document.createElement("section");
      meal.setAttribute("id", "item-" + (i + 1));
      organiser.appendChild(meal);

      // Name of meal
      let name = document.createElement("p");
      name.className = "name";
      let nametxt = document.createTextNode(data[i].Name);
      name.appendChild(nametxt);
      meal.appendChild(name);

      // Price of meal
      let price = document.createElement("p");
      price.className = "price";
      let pricetxt = document.createTextNode(data[i].Price);
      let fas = document.createElement("i");
      fas.className = "fas fa-dollar-sign";
      price.appendChild(fas);
      price.appendChild(pricetxt);
      meal.appendChild(price);

      // Quantity of meal
      let counter = document.createElement("span");
      counter.className = "counter";

      var inp = document.createElement("input");
      inp.type = "number";
      inp.className = "quantity-" + (i + 1);
      inp.min = 0;
      inp.max = 99;
      inp.setAttribute("id", "quant-" + (i + 1));
      inp.setAttribute("placeholder", 0);
      counter.appendChild(inp);
      meal.appendChild(counter);
    }
    // Submit button
    let submit = document.createElement("button");
    let btntxt = document.createTextNode("Proceed");
    submit.className = "proceed";
    submit.setAttribute("id", "pickBtn");
    submit.appendChild(btntxt);
    organiser.appendChild(submit);

    submit.addEventListener("click", function() {
      if (confirm("Are you sure thats it?")) {
        pickResult(data);
      }
    });
  }
});

// Order list creation
function pickResult(data) {
  var list = [];

  for (let item = 0; item < data.length; item++) {
    let quantity = document.getElementById("quant-" + (item + 1)).value;
    if (quantity != 0 && quantity != null) {
      let obj = data[item].Name;
      let price = data[item].Price;
      let sum = price * quantity;

      let items = [];
      items.push(obj);
      items.push(price);
      items.push(quantity);
      items.push(sum);
      list.push(items);
    }
  }

  if (list != null) {
    $.ajax({
      type: "POST",
      url: "/order/summary",
      data: { json: list },
      contentType: "application/json",
      success: function() {
        window.location = "/order/summary";
      },
      error: function(request, status, error) {
        alert(status);
      }
    });
  }
}
