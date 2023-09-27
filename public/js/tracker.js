const form = document.querySelector("#tracker-form"),
    input = document.querySelector("#tracker-input");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    form.action = form.action + "/" + input.value;

    form.submit();
});
