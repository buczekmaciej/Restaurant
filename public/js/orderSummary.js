if (!localStorage.getItem("address")) window.location = "/order";
if (!localStorage.getItem("list")) window.location = "/order/pick";

let address = localStorage.getItem("address");
let list = JSON.parse(localStorage.getItem("list"));
let org = document.getElementsByClassName("summary-org")[0];

let add = document.createElement("p");
add.classList.add("address-sum");
add.innerHTML = `<b>Address:</b> ${address}`;

let total = 0;

let listing = document.createElement("div");
listing.classList.add("list-sum");

Array.from(list).forEach((el) => {
  let line = document.createElement("p");
  line.classList.add("line-list");
  line.innerHTML = `<span>${el.name}</span><span>$${el.price}</span><span>x ${
    el.quant
  } = </span><span>$${el.quant * el.price}</span>`;
  listing.appendChild(line);
  total += el.quant * el.price;
});

let tot = document.createElement("p");
tot.classList.add("total-sum");
tot.innerHTML = `<b>Total:</b> $${total}`;

let placeOrder = document.createElement("button");
placeOrder.classList.add("submit-sum");
placeOrder.innerText = "Finish";

placeOrder.onclick = () => {
  let xhr = new XMLHttpRequest();
  let fd = new FormData();
  fd.append("order", JSON.stringify({ address: address, list: list }));
  xhr.open("POST", "/order/place");
  xhr.onerror = (err) => console.log(err);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4)
      if (xhr.status == 200)
        window.location = `/order-monitor?id=${xhr.response}`;
  };
  xhr.send(fd);
};

org.appendChild(add);
org.appendChild(listing);
org.appendChild(tot);
org.appendChild(placeOrder);
