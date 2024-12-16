import Accordion from "./Accordion.js";
import { StandardCarousel, ExpandableCarousel, ActionsCarousel } from './Carousel.js';

window.addEventListener('DOMContentLoaded', () => {
  /* Main Accordion */
  const main = new Accordion(
    '#main',
    '.section',
  );
  main.init();

  /* Agenda */
  const agendaCarousel = new ExpandableCarousel(
    '.agenda__carousel',
    { loop: true },
    {
      prev: '#agenda .ctrl--prev svg',
      next: '#agenda .ctrl--next svg'
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

  const containers = document.querySelectorAll('.carousel');
  containers.forEach(container => {
    const parent = container.closest('.section');
    const prevButton = `#${parent.id} .ctrl--prev`;
    const nextButton = `#${parent.id} .ctrl--next`;

    new StandardCarousel(
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
  });
});