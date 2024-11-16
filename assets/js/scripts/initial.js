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
  document.querySelectorAll('.mobile-expand').forEach(initExpandButton);

  function initExpandButton(button) {
    button.addEventListener('click', () => {
      const item = button.closest('.agenda__item');
      if (!item) return;

      const wrapper = item.querySelector('.agenda__item__infos');
      const details = wrapper?.querySelector('.agenda__item__details');

      toggleExpansion(item, wrapper, details, button);
    });
  }

  /**
   * @param {HTMLElement} item
   * @param {HTMLElement} wrapper
   * @param {HTMLElement} details
   * @param {HTMLElement} button
   */
  function toggleExpansion(item, wrapper, details, button) {
    if (!wrapper || !button) return;

    const expandedClass = 'agenda__item__infos--expanded';
    const isExpanded = wrapper.classList.contains(expandedClass);

    wrapper.classList.toggle(expandedClass, !isExpanded);
    button.setAttribute('aria-expanded', !isExpanded);
    details?.setAttribute('aria-hidden', isExpanded);

    item.dispatchEvent(new CustomEvent('agendaItemToggled', {
      detail: { isExpanded, item, wrapper, details },
      bubbles: true
    }));
  }
})
