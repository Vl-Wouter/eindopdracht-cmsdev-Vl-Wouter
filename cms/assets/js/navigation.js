const url = window.location.href.split('/');
const navLinks = document.querySelector('.nav__link');

if(url[3] === "admin" && url[4]) {
    const pageType = url[4];
    document.querySelector(`#${pageType}`).classList.add('-active');
} else if (url[3] === 'admin') {
    document.querySelector('#overview').classList.add('-active');
}