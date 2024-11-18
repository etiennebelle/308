
import EmblaCarousel from "embla-carousel";

export default class Carousel {
  constructor(selector, options = {}, controllers = {}){
    this.emblaNode = document.querySelector(selector);
    this.options = {
      loop: false,
      ...options
    };
    this.controllers = controllers;
    this.emblaApi = null;
  }

  init(){
    this.emblaApi = EmblaCarousel(this.emblaNode, this.options);
    this.setupNav();
    return this.emblaApi;
  }

  setupNav(){
    const { prev, next, navItems } = this.controllers;

    if(prev){
      const prevButton = document.querySelector(prev);
      if(prevButton){
        prevButton.addEventListener('click', () => this.emblaApi.scrollPrev());
      }
    }

    if(next){
      const nextButton = document.querySelector(next);
      if(nextButton){
        nextButton.addEventListener('click', () => this.emblaApi.scrollNext());
      }
    }

    if(navItems){
      const navButtons = document.querySelectorAll(navItems);
      navButtons.forEach((button) => {
        const { key } = button.dataset;
        button.addEventListener('click', () => {
          this.findSlide(key);
        });
      })
    }
  }

  findSlide(key){
    return this.emblaApi.scrollTo(this.emblaApi.slideNodes().findIndex(s => s.dataset.key === key));
  }
}

export class AgendaCarousel extends Carousel {
  constructor(selector, options = {}, controllers = {}) {
    super(selector, options, controllers);
    this.expandedClass = 'agenda__slide__infos--expanded';
  }

  init() {
    super.init();
    this.initExpandButtons();
  }

  initExpandButtons() {
    document.querySelectorAll('.mobile-expand').forEach(this.initExpandButton.bind(this));
  }

  initExpandButton(button) {
    button.addEventListener('click', () => {
      const item = button.closest('.agenda__slide');
      if (!item) return;

      const wrapper = item.querySelector('.agenda__slide__infos');
      const details = wrapper.querySelector('.agenda__slide__details');

      this.toggleExpansion(item, wrapper, details, button);
    });
  }

  toggleExpansion(item, wrapper, details, button) {
    if (!wrapper || !button) return;

    const isExpanded = wrapper.classList.contains(this.expandedClass);

    wrapper.classList.toggle(this.expandedClass, !isExpanded);
    button.setAttribute('aria-expanded', !isExpanded);
    details.setAttribute('aria-hidden', isExpanded);
  }
}