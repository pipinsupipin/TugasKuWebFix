
document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");

    menuItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua menu item
            menuItems.forEach((menu) => menu.classList.remove("active"));

            // Tambahkan class 'active' ke menu yang diklik
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll(".categoryL");

    categoryItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua kategori
            categoryItems.forEach((category) =>
                category.classList.remove("active")
            );

            // Tambahkan class 'active' ke kategori yang diklik
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll(".categoryL");

    categoryItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua kategori
            categoryItems.forEach((category) =>
                category.classList.remove("active")
            );

            // Tambahkan class 'active' ke kategori yang diklik
            this.classList.add("active");
        });
    });
});

document.querySelectorAll(".box-list").forEach((item) => {
    item.addEventListener("click", () => {
        item.classList.toggle("strike");
    });
});
