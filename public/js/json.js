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
      let meal = document.createElement("section");
      meal.setAttribute("id", "item-" + (i + 1));
      meal.innerHTML =
        '<p class="name">' +
        data[i].Name +
        '</p><p class="price"><i class="fas fa-dollar-sign"></i> ' +
        data[i].Price +
        '</p> <input type="number" class="quantity" id="quant-' +
        (i + 1) +
        '" maxlength="2" value=0>';
      organiser.appendChild(meal);
    }
    let submit = document.createElement("button");
    let btntxt = document.createTextNode("Proceed");
    submit.className = "proceed";
    submit.setAttribute("id", "pickBtn");
    submit.appendChild(btntxt);
    organiser.appendChild(submit);

    submit.addEventListener(
      "click",
      function() {
        dataGet(data);
      },
      false
    );
  }
});

// Order list creation
function dataGet(data) {
  var order = [];

  for (let item = 0; item < data.length; item++) {
    let quantity = document.getElementById("quant-" + (item + 1)).value;
    if (quantity !== 0) {
      let obj = data[item].Name;
      let price = data[item].Price;

      let items = [];
      items.push(obj);
      items.push(price);
      items.push(quantity);
      order.push(items);
    }
  }
  console.log(order);
}
