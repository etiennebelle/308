
import EmblaCarousel from "embla-carousel";

class Carousel {
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
    return this.emblaApi;
  }
}

export class PrimaryCarousel extends Carousel{
  constructor(selector, options = {}, controllers = {}) {
    super(selector, options);
    this.controllers = controllers;
    this.prevButton = null;
    this.nextButton = null;
  }

  init(){
    super.init();
    this.setupNavButtons();
    return this.emblaApi;
  }

  setupNavButtons(){
    const { prev, next } = this.controllers;

    if (prev) {
      this.prevButton = document.querySelector(prev);
      if (this.prevButton) {
        this.prevButton.addEventListener('click', () => this.emblaApi.scrollPrev());
      }
    }

    if (next) {
      this.nextButton = document.querySelector(next);
      if (this.nextButton) {
        this.nextButton.addEventListener('click', () => this.emblaApi.scrollNext());
      }
    }
  }
}

export class AgendaCarousel extends PrimaryCarousel {
  constructor(selector, options = {}, controllers = {}) {
    super(selector, options, controllers);
    this.expandedClass = 'agenda__slide__infos--expanded';
    this.expandButtons = new Set();
  }

  init() {
    super.init();
    this.initExpandButtons();
    return this.emblaApi;
  }

  initExpandButtons() {
    const buttons = this.emblaNode.querySelectorAll('.mobile-expand');
    buttons.forEach(button => {
      if (!button) return;

      const handleClick = () => {
        const item = button.closest('.agenda__slide');
        if (!item) return;

        const wrapper = item.querySelector('.agenda__slide__infos');
        const details = wrapper?.querySelector('.agenda__slide__details');

        this.toggleExpansion(wrapper, details, button);
      };

      button.addEventListener('click', handleClick);
      this.expandButtons.add(button);
    });
  }

  toggleExpansion(wrapper, details, button) {
    if (!wrapper || !details || !button) return;

    const isExpanded = wrapper.classList.contains(this.expandedClass);
    wrapper.classList.toggle(this.expandedClass);
    button.setAttribute('aria-expanded', !isExpanded);
    details.setAttribute('aria-hidden', isExpanded);
  }
}

export class ActionsCarousel extends PrimaryCarousel {
  constructor(selector, options = {}, controllers = {}) {
    super(selector, options, controllers);
    this.navItems = new Map();
  }

  init() {
    super.init();
    this.setupNavItems();
    return this.emblaApi;
  }

  setupNavItems() {
    const { navItems } = this.controllers;
    if (!navItems) return;

    const buttons = document.querySelectorAll(navItems);
    buttons.forEach(button => {
      const { key } = button.dataset;
      if (key) {
        this.navItems.set(key, button);
        button.addEventListener('click', () => this.scrollToKey(key));
      }
    });
  }

  scrollToKey(key) {
    if (!this.emblaApi || !key) return;

    const index = this.findSlideIndex(key);
    if (index !== -1) {
      this.emblaApi.scrollTo(index);
      this.updateActiveNavItem(key);
    }
  }

  findSlideIndex(key) {
    return this.emblaApi.slideNodes().findIndex(slide => slide.dataset.key === key);
  }

  updateActiveNavItem(activeKey) {
    this.navItems.forEach((button, key) => {
      button.classList.toggle('active', key === activeKey);
      button.setAttribute('aria-current', key === activeKey ? 'true' : 'false');
    });
  }
}