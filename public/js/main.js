document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".btn-tab button, .btn-page button");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            buttons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slide");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");

    let index = 0;

    function showSlide(i) {
        if (i >= slides.length) index = 0;
        if (i < 0) index = slides.length - 1;
        slider.style.transform = `translateX(${-index * 100}%)`;
    }

    nextBtn.addEventListener("click", () => {
        index++;
        showSlide(index);
    });

    prevBtn.addEventListener("click", () => {
        index--;
        showSlide(index);
    });


    setInterval(() => {
        index++;
        showSlide(index);
    }, 4000);
});

document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".hot-items");
    const products = document.querySelectorAll(".hot-product");
    const prevBtn = document.querySelector(".hotProduct-controls .prev");
    const nextBtn = document.querySelector(".hotProduct-controls .next");

    if (!slider || products.length <= 4) return;

    let currentIndex = 0;
    const visibleCount = 4;
    const productWidth = products[0].offsetWidth + 20; // 20 là gap
    const maxIndex = products.length - visibleCount;

    function updateSlider() {
        const offset = -(currentIndex * productWidth);
        slider.style.transform = `translateX(${offset}px)`;
    }

    nextBtn.addEventListener("click", () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSlider();
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlider();
        }
    });

    // setInterval(() => {
    //     if (currentIndex < maxIndex) {
    //         currentIndex++;
    //     } else {
    //         currentIndex = 0;
    //     }
    //     updateSlider();
    // }, 4000);
});


function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    quantityInput.value = parseInt(quantityInput.value) + 1;
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
}

