export default class Accordion{
  constructor(parentClassName, childClassName) {
    this.parent = parentClassName;
    this.children = childClassName;
    this.accordion = null;
  }

  init(){
    if(!this.parent || !this.children) return;

    this.accordion = document.querySelector(this.parent);
    this.accordion.addEventListener('click', (e) => this.toggleActive(e.target.closest(this.children)));

    return this.accordion;
  }

  toggleActive(target){
    const allChildren = document.querySelectorAll(this.children);
    const activeClass = `${this.children.slice(1)}--active`;

    if(target.classList.contains(activeClass)) return;

    allChildren.forEach(child => child.classList.remove(activeClass));
    target.classList.add(activeClass);
  }
}