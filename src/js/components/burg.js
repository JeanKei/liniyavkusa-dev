document.querySelector('.header__btn').addEventListener('click', function () {
  document.querySelector('.nav').classList.remove('nav--close');
});
document.querySelector('.rightside-menu__close').addEventListener('click', function () {
  document.querySelector('.nav').classList.add('nav--close');
});


let bShow = document.querySelectorAll('.menu-item');

for (let i = 0; i < bShow.length; i++) {
  bShow[i].onclick = function() {
    document.querySelector('.nav').classList.add('nav--close');
  }
}
