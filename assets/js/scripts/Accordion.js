import { gsap } from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(ScrollToPlugin);
export default class Accordion{
  constructor(parentSelector, childSelector, options = {}) {
    this.parentSelector = parentSelector;
    this.childSelector = childSelector;
    this.activeClass = options.activeClass || `${childSelector.slice(1)}--active`;

    this.accordion = null;
  }

  init(){
    this.accordion = document.querySelector(this.parentSelector);

    this.accordion.addEventListener('click', this.handleClick.bind(this));

    return this.accordion;
  }

  handleClick(event) {
    const target = event.target.closest(this.childSelector);
    if (!target) return;

    this.toggleActive(target);
    this.scrollIntoActiveSection(target);
  }

  toggleActive(target) {
    const allChildren = document.querySelectorAll(this.childSelector);

    if (target.classList.contains(this.activeClass)) return;

    allChildren.forEach(child => child.classList.remove(this.activeClass));

    target.classList.add(this.activeClass);
  }

  scrollIntoActiveSection(target) {
    const headerHeight = target.querySelector('.section__heading').getBoundingClientRect().height;
    const index = parseInt(target.getAttribute('data-index'));

    const scrollOffset = index * headerHeight - headerHeight;

    gsap.to(window, {
      duration: 1,
      scrollTo: scrollOffset,
      ease: "power2.out"
    });
  }
}