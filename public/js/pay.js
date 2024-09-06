// var payButton = document.getElementById('payNowButton');
// payButton.addEventListener('click', function () {
//   // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
//   window.snap.pay('{{ $snapToken }}', {
//     onSuccess: function(result){
//       /* You may add your own implementation here */
//       //alert("payment success!"); 
//       window.location.href = '/payment-status/{{$booking->id}}';
//       console.log(result);
//     },
//     onPending: function(result){
//       /* You may add your own implementation here */
//       alert("wating your payment!"); console.log(result);
//     },
//     onError: function(result){
//       /* You may add your own implementation here */
//       alert("payment failed!"); console.log(result);
//     },
//     onClose: function(){
//       /* You may add your own implementation here */
//       alert('you closed the popup without finishing the payment');
//     }
//   })
// });

// function showModal(bookingId) {
//     // Lakukan permintaan AJAX ke server untuk mendapatkan snapToken
//     $.ajax({
//         url: "{{ route('process.payment') }}",
//         type: 'POST',
//         data: {
//             _token: '{{ csrf_token() }}',
//             booking_id: bookingId
//         },
//         success: function(response) {
//             // Simpan snapToken dan booking di variabel
//             var snapToken = response.snapToken;
//             var booking = response.booking;

//             // Tampilkan modal
//             document.getElementById("paymentModal").style.display = "flex";

//             // Trigger Snap popup
//             var payButton = document.getElementById('payNowButton');
//             payButton.addEventListener('click', function () {
//                 window.snap.pay(snapToken, {
//                     onSuccess: function(result){
//                         window.location.href = '/payment-status/' + booking.id;
//                         console.log(result);
//                     },
//                     onPending: function(result){
//                         alert("Menunggu pembayaran Anda!"); 
//                         console.log(result);
//                     },
//                     onError: function(result){
//                         alert("Pembayaran gagal!"); 
//                         console.log(result);
//                     },
//                     onClose: function(){
//                         alert('Anda menutup popup tanpa menyelesaikan pembayaran');
//                     }
//                 });
//             });
//         },
//         error: function(xhr, status, error) {
//             alert('Gagal memproses pembayaran. Silakan coba lagi.');
//         }
//     });
// }


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


// destinasi jika produk di klik
function goToPage() {
    window.location.href = 'produk-page.html';
}

// konfirmasi pesanan pop up
function showModal() {
    document.getElementById("paymentModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("paymentModal").style.display = "none";
}

window.onclick = function(event) {
    const modal = document.getElementById('paymentModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

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
