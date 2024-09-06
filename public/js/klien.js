//toogle class active
const navbarNav = document.querySelector(".navbar-nav");
//ketika furniture menu di klik
document.querySelector("#furniture-menu").onclick = () => {
    navbarNav.classList.toggle("active");
};

//toogle class active untuk cart
const shoppingCart = document.querySelector(".shopping-cart");
document.querySelector("#shopping-cart-button").onclick = () => {
    shoppingCart.classList.toggle("active");
    e.preventDefault();
};

//toogle profil admin
document.addEventListener("DOMContentLoaded", function() {
    const profilePic = document.getElementById("profilePic");
    const dropdownMenu = document.getElementById("dropdownMenu");

    profilePic.addEventListener("click", function() {
        dropdownMenu.classList.toggle("show");
    });

    // Close the dropdown if the user clicks outside of it
    window.addEventListener("click", function(event) {
        if (event.target !== profilePic && !profilePic.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove("show");
        }
    });
});

//toogle class active search form
const searchForm = document.querySelector(".search-form");
const searchBox = document.querySelector("#search-box");

document.querySelector("#search-button").onclick = (e) => {
    searchForm.classList.toggle("active");
    searchBox.focus();
    e.preventDefault();
};

// Klik luar luar elemen
const furniture = document.querySelector("#furniture-menu");
const sb = document.querySelector("#search-button");
const sc = document.querySelector("#shopping-cart-button");

document.addEventListener("click", function (e) {
    if (!furniture.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove("active");
    }
    if (!sb.contains(e.target) && !searchForm.contains(e.target)) {
        searchForm.classList.remove("active");
    }
    if (!sc.contains(e.target) && !shoppingCart.contains(e.target)) {
        shoppingCart.classList.remove("active");
    }
});

//modal box
const itemDetailModal = document.querySelector("#item-detail-modal");
const itemDetailButtons = document.querySelectorAll(".item-detail-button");

itemDetailButtons.forEach((btn) => {
    btn.onclick = (e) => {
        itemDetailModal.style.display = "flex";
        e.preventDefault();
    };
});

//klim close
document.querySelector(".modal .close-icon").onclick = (e) => {
    itemDetailModal.style.display = "none";
    e.preventDefault();
};

//klik luar modal
window.onclick = (e) => {
    if (e.target === itemDetailModal) {
        itemDetailModal.style.display = "none";
    }
};

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.remove-from-cart').forEach(function (button) {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            var url = `/remove-cart/${id}`;
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show notification
                    var notification = document.getElementById('notification');
                    notification.textContent = data.message;
                    notification.classList.add('success');
                    notification.style.display = 'block';

                    // Remove item from DOM
                    button.closest('.cart-item').remove();

                    // Hide notification after 3 seconds
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 3000);
                } else {
                    alert('Error removing item from cart');
                }
            });
        });
    });
});

 document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.quantity-change').forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var action = this.getAttribute('data-action');
                    var url = `/update-cart/${id}`;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ action: action })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update quantity in the DOM
                            var item = document.querySelector(`.cart-item[data-id="${id}"]`);
                            var quantityElement = item.querySelector('.item-quantity span');
                            quantityElement.textContent = data.newQuantity;
                        } else {
                            alert('Error updating item quantity');
                        }
                    });
                });
            });

            document.querySelectorAll('.remove-from-cart').forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var url = `/remove-cart/${id}`;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show notification
                            var notification = document.getElementById('notification');
                            notification.textContent = data.message;
                            notification.classList.add('success');
                            notification.style.display = 'block';

                            // Remove item from DOM
                            button.closest('.cart-item').remove();

                            // Hide notification after 3 seconds
                            setTimeout(() => {
                                notification.style.display = 'none';
                            }, 3000);
                        } else {
                            alert('Error removing item from cart');
                        }
                    });
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.quantity-change').forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var action = this.getAttribute('data-action');
                    var url = `/update-cart/${id}`;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ action: action })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update quantity in the DOM
                            var item = document.querySelector(`.cart-item[data-id="${id}"]`);
                            var quantityElement = item.querySelector('.item-quantity span');
                            quantityElement.textContent = data.newQuantity;
                        } else {
                            alert('Error updating item quantity');
                        }
                    });
                });
            });

            document.querySelectorAll('.remove-from-cart').forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var url = `/remove-cart/${id}`;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show notification
                            var notification = document.getElementById('notification');
                            notification.textContent = data.message;
                            notification.classList.add('success');
                            notification.style.display = 'block';

                            // Remove item from DOM
                            button.closest('.cart-item').remove();

                            // Hide notification after 3 seconds
                            setTimeout(() => {
                                notification.style.display = 'none';
                            }, 3000);
                        } else {
                            alert('Error removing item from cart');
                        }
                    });
                });
            });
        });