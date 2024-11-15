window.addEventListener('DOMContentLoaded', () => {
  /* Accordion */
  const accordion = document.querySelector('#main');
  accordion.addEventListener('click', (e) => {
    const section = e.target.closest('.section');
    if(!section) return;
    toggleActive(section);
  })

  function toggleActive(target){
    const sections = document.querySelectorAll('.section');
    if(target.classList.contains('section--active')) return;

    sections.forEach((s) => s.classList.remove('section--active'));
    target.classList.add('section--active');
  }

  /* Agenda Expand on Mobile */
  const expandButtons = document.querySelectorAll('.mobile-expand');
  expandButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      const item = e.target.closest('.agenda__item');
      const wrapper = item.querySelector('.agenda__item__infos');
      toggleExpanded(button, wrapper);
    })
  })

  function toggleExpanded(button, wrapper){
    if(!wrapper || !button) return;
    const className = 'agenda__item__infos--expanded';
    if(wrapper.classList.contains(className)){
      wrapper.classList.remove(className);
      button.setAttribute('aria-expanded', true);
    } else {
      wrapper.classList.add(className);
      button.setAttribute('aria-expanded', false);
    }
  }
})
