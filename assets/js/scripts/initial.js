import Accordion from "./Accordion.js";
import { PrimaryCarousel, AgendaCarousel, ActionsCarousel } from './Carousel.js';

window.addEventListener('DOMContentLoaded', () => {
  /* Main Accordion */
  const main = new Accordion(
    '#main',
    '.section',
  );
  main.init();

  /* Agenda */
  const agendaCarousel = new AgendaCarousel(
    '.agenda__carousel',
    { loop: true },
    {
      prev: '#agenda .ctrl--prev',
      next: '#agenda .ctrl--next'
    }
  );
  agendaCarousel.init();

  const actionsCarousel = new ActionsCarousel(
    '.actions__carousel',
    { loop: true, axis: 'y' },
    {
      navItems: '.actions__item'
    }
  );
  actionsCarousel.init();

  const primaryContainers = document.querySelectorAll('.carousel');
  primaryContainers.forEach(container => {
    const parent = container.closest('.section');
    const prevButton = `#${parent.id} .ctrl--prev`;
    const nextButton = `#${parent.id} .ctrl--next`;

    new PrimaryCarousel(
      `#${parent.id} .carousel`,
      {
        loop: false,
        align: 'start'
      },
      {
        prev: prevButton,
        next: nextButton
      }
    ).init()
  })

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