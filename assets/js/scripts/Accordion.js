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
  }

  toggleActive(target) {
    const allChildren = document.querySelectorAll(this.childSelector);

    if (target.classList.contains(this.activeClass)) return;

    allChildren.forEach(child => child.classList.remove(this.activeClass));

    target.classList.add(this.activeClass);
  }

}