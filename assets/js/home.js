const tabs = document.querySelectorAll('.tab-item');
const pane = document.querySelectorAll('.tab-pane-product');

const tabActive = document.querySelector('.tab-item.active');
const line = document.querySelector('.line');
line.style.left = tabActive.offsetLeft + 'px';
line.style.width = tabActive.offsetWidth + 'px';

tabs.forEach((tabArr, index) => {
    tabArr.onclick = function(){
        document.querySelector('.tab-item.active').classList.remove('active');
        document.querySelector('.tab-pane-product.active').classList.remove('active');
        line.style.left = this.offsetLeft + 'px';
        line.style.width = this.offsetWidth + 'px';
        this.classList.add('active');
        pane[index].classList.add('active');
    }
});