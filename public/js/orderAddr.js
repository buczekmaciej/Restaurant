let addrInp = document.getElementsByClassName("address-input")[0];
let addrBtn = document.getElementsByClassName("submit-address")[0];

addrInp.onkeyup = () => {
  if (addrInp.value != "") {
    addrBtn.removeAttribute("disabled");
    addrBtn.onclick = () => {
      localStorage.setItem("address", addrInp.value);
      window.location = "/order/pick";
    };
  } else addrBtn.setAttribute("disabled", true);
};
