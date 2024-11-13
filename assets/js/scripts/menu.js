window.addEventListener('DOMContentLoaded', () => {
  const menuDrawer = document.querySelector('#header-menu');
  const menuBtn = document.querySelector('.header-btn');
  if(menuBtn){
    menuBtn.addEventListener('click', () => {
      const state = menuBtn.getAttribute('aria-expanded') === 'true';
      menuBtn.setAttribute('aria-expanded', !state);
      menuDrawer.setAttribute('aria-hidden', state);
    })
  }
})
