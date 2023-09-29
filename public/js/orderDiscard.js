const cancel = document.querySelector("#cancel-btn"),
    container = document.querySelector("#discard"),
    cancelOrder = document.querySelector("#cancel");

cancel.addEventListener("click", () => {
    container.classList.replace("flex", "hidden");
});

cancelOrder.addEventListener("click", () => {
    container.classList.replace("hidden", "flex");
});
