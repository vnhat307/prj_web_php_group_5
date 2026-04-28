// kich hoat nut tha tym
document.querySelectorAll(".heart-btn").forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    const icon = this.querySelector("i");
    const countSpan = this.querySelector(".count");
    let count = parseInt(countSpan.innerText);
    if (icon.classList.contains("bi-heart")) {
      icon.classList.replace("bi-heart", "bi-heart-fill");
      countSpan.innerText = count + 1;
    } else {
      icon.classList.replace("bi-heart-fill", "bi-heart");
      countSpan.innerText = count - 1;
    }
  });
});
