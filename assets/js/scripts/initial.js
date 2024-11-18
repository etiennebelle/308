import Accordion from "./Accordion.js";
import Carousel, { AgendaCarousel } from './Carousel.js';

window.addEventListener('DOMContentLoaded', () => {
  /* Main Accordion */
  const main = new Accordion(
    '#main',
    '.section',
  );
  main.init();

  /* Agenda */
  const agendaCarousel = new AgendaCarousel(
    '.agenda',
    { loop: true },
    {
      prev: '#agenda .ctrl--prev',
      next: '#agenda .ctrl--next'
    }
  );
  agendaCarousel.init();

  const actionsCarousel = new Carousel(
    '.actions',
    { loop: true, axis: 'y' },
    {
      navItems: '.actions__nav__item'
    }
  );
  actionsCarousel.init();

  /* Header */
  const menuDrawer = document.querySelector('#header-menu');
  const menuBtn = document.querySelector('.header-btn');
  if(menuBtn){
    menuBtn.addEventListener('click', () => {
      const state = menuBtn.getAttribute('aria-expanded') === 'true';
      menuBtn.setAttribute('aria-expanded', !state);
      menuDrawer.setAttribute('aria-hidden', state);
    })
  }
});