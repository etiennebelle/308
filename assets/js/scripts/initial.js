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
    sections.forEach((s) => s.classList.remove('section--active'));
    target.classList.add('section--active');
  }
})
