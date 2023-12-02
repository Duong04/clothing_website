let codPay = document.querySelector('.cod-pay');
let payBank = document.querySelector('.pay-bank');
let textPay = document.querySelector('.text-pay');
let infoBank = document.querySelector('.info-bank');
let i1 = document.getElementById('i1');
let i2 = document.getElementById('i2');

codPay.addEventListener('click', function() {
    textPay.style.display = 'block';
    infoBank.style.display = 'none';
    codPay.style.borderBottom = '2px solid #ccc';
    payBank.style.border = 'none';
    i1.className = "fa-solid fa-circle";
    i2.className = "fa-regular fa-circle";
});

payBank.addEventListener('click', function() {
    textPay.style.display = 'none';
    infoBank.style.display = 'block';
    payBank.style.borderBottom = '2px solid #ccc';
    i2.className = "fa-solid fa-circle";
    i1.className = "fa-regular fa-circle";
});

const showCart = document.querySelector('.show-cart');
const hideProduct = document.querySelector('.hide-product');
showCart.onclick = function() {
    hideProduct.classList.toggle('show-product');
};