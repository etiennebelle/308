import EmblaCarousel from 'embla-carousel';

window.addEventListener('DOMContentLoaded', () => {
  function initAgendaCarousel (){
    const emblaNode = document.querySelector('.agenda');
    const options = {
      loop: true,
    };

    if(!emblaNode) return;
    const emblaApi = EmblaCarousel(emblaNode, options);
    const prev = document.querySelector('.ctrl--prev');
    prev.addEventListener('click', () => {
      emblaApi.scrollPrev();
    })

    const next = document.querySelector('.ctrl--next');
    next.addEventListener('click', () => {
      emblaApi.scrollNext();
    })
  }

  initAgendaCarousel();
})