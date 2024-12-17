import Accordion from "./Accordion.js";
import { GridCarousel, ExpandableCarousel, ActionsCarousel } from './Carousel.js';

window.addEventListener('DOMContentLoaded', () => {
  /* Main Accordion */
  const main = new Accordion(
    '#main',
    '.section',
  );
  main.init();

  /* Agenda */
  const agendaCarousel = new ExpandableCarousel(
    '#agenda .u-carousel',
    { loop: true },
    {
      prev: '#agenda .ctrl--prev svg',
      next: '#agenda .ctrl--next svg'
    }
  );
  agendaCarousel.init();

  const actionsCarouselMobile = new ExpandableCarousel(
    '#actions .u-carousel',
    { loop: true },
    {
      prev: '#actions .ctrl--prev svg',
      next: '#actions .ctrl--next svg'
    }
  )
  actionsCarouselMobile.init();

  const actionsCarouselDesktop = new ActionsCarousel(
    '#actions .a-carousel',
    { loop: true, axis: 'y' },
    {
      navItems: '.a-item'
    }
  )
  actionsCarouselDesktop.init();

  const containers = document.querySelectorAll('.g-carousel');
  containers.forEach(container => {
    const parent = container.closest('.section');
    const prevButton = `#${parent.id} .ctrl--prev`;
    const nextButton = `#${parent.id} .ctrl--next`;

    new GridCarousel(
      `#${parent.id} .g-carousel`,
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