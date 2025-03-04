import { gsap } from 'gsap';
import EmblaCarousel from "embla-carousel";

class Carousel {
  constructor(selector, options = {}, controllers = {}){
    this.selector = selector
    this.emblaNode = document.querySelector(selector);
    this.options = {
      loop: false,
      ...options
    };
    this.controllers = controllers;
    this.emblaApi = null;
  }

  init(){
    if(!this.emblaNode) return
    this.emblaApi = EmblaCarousel(this.emblaNode, this.options);
    if(this.emblaApi.slideNodes().length <= 1){
      this.handleEmptyCarousel();
    }
    this.setupNavButtons();
    return this.emblaApi;
  }

  handleEmptyCarousel(){
    const wrapper = document.querySelector(this.selector);
    const className = `${wrapper.className}--void`;
    wrapper.classList.add(className);
    const header = wrapper.closest('.section').querySelector('.section__heading');
    header.querySelectorAll('.section__heading__control').forEach((el) => {
      el.classList.add('hidden');
    })
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

export class GridCarousel extends Carousel{
  constructor(selector, options = {}, controllers = {}) {
    super(selector, options);
    this.controllers = controllers;
    this.prevButton = null;
    this.nextButton = null;
  }

  init(){
    super.init();
    this.setupControlVisibility();
    return this.emblaApi;
  }

  setupControlVisibility() {
    const updateButtonVisibility = (button, canScroll) => {
      button.style.visibility = canScroll ? "visible" : "hidden";
    };

    updateButtonVisibility(this.prevButton, false);

    this.emblaApi.on('select', () => {
      updateButtonVisibility(this.prevButton, this.emblaApi.canScrollPrev());
      updateButtonVisibility(this.nextButton, this.emblaApi.canScrollNext());
    });
  }
}

export class ExpandableCarousel extends Carousel {
  constructor(selector, options = {}, controllers = {}) {
    super(selector, options, controllers);
    this.expandedClass = 'u-carousel__infos--expanded';
    this.expandButtons = new Set();
  }

  init() {
    super.init();
    this.initExpandButtons();
    return this.emblaApi;
  }

  initExpandButtons() {
    if(!this.emblaApi) return
    this.emblaApi.slideNodes().forEach(slide => {
      const button = slide.querySelector('.btn-expand');
      if (!button) return;

      const handleClick = () => {
        const wrapper = slide.querySelector('.u-carousel__infos');
        const details = wrapper?.querySelector('.u-carousel__details');
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

    gsap.to(wrapper, {
      duration: 0.5,
      height: isExpanded ? 'auto' : details.offsetHeight,
      ease: 'power2.out'
    });
  }
}

export class ActionsCarousel extends Carousel {
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