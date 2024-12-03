document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form');
  const emailInput = form.querySelector('input[name="email"]');
  const idInput = form.querySelector('input[name="post_id"]');
  const message = document.querySelector('.form-message');

  const { ajaxUrl } = wpApiSettings;

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const email = emailInput.value.trim();
    const postId = idInput.value;

    if(!email) return;

    message.style.display = 'none';
    message.innerHTML = '';

    const formData = new FormData();
    formData.append('action', 'subscribe_to_newsletter');
    formData.append('email', email);
    formData.append('post_id', postId);

    await fetch(ajaxUrl, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(result => {
        if(result.success){
          emailInput.value = result.data.message;
        } else {
          message.innerHTML = `<p class="body body-md">${result.data.message}</p>`;
          message.style.display = 'block';
          emailInput.value = '';
        }
      })
      .catch(err => {
        console.log(err);
      })
  })
})