const inputs = document.querySelectorAll("input[type='number']"),
    form = document.querySelector("form");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    let isValid = false;

    Array.from(inputs).forEach((input) => {
        let val = input.value;
        if (val !== "" && parseInt(val) > 0 && parseInt(val) < 1000)
            isValid = true;
    });

    if (isValid) form.submit();
    else alert("You need to order at least 1 meal");
});
