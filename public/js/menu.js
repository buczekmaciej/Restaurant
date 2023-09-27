const topScroll = document.querySelector("#top-scroll");

topScroll.addEventListener("click", () => window.scrollTo(0, 0));

window.addEventListener("scroll", () => {
    if (this.scrollY > 200) topScroll.classList.replace("hidden", "block");
    else topScroll.classList.replace("block", "hidden");
});
