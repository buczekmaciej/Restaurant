const place = document.querySelector("#place"),
    listContainer = document.querySelector("#list"),
    lastVisit = document.querySelector("#last-visit"),
    pendingList = document.querySelector("#pending-list");

Array.from(pendingList.children).forEach((entry) => {
    entry.children[0].addEventListener("click", () => {
        entry.classList.toggle("unfold");
    });
});

const generateNotice = () => {
    const notice = document.createElement("p");
    notice.classList.add(
        "border-2",
        "border-solid",
        "border-blue-500",
        "bg-blue-500",
        "bg-opacity-5",
        "text-blue-500",
        "rounded-md",
        "p-3",
        "text-lg"
    );
    notice.textContent = "New orders are ready to prepare!";

    listContainer.prepend(notice);
};

const checkNewOrdersInterval = setInterval(() => {
    fetch(
        `/api/orders/check?date=${lastVisit.value}&place=${place.dataset.place}`,
        {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-Token":
                    document.querySelector("input[name=_token]").value,
            },
        }
    )
        .then((res) => res.json())
        .then((data) => {
            if (data) {
                generateNotice();
                clearInterval(checkNewOrdersInterval);
            } else console.log(data);
        })
        .catch((error) => alert(error));
}, 90000);

checkNewOrdersInterval;
