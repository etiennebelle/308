document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form');
  const input = form.querySelector('input[name="email"]');

  const { ajaxUrl } = wpApiSettings;

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const email = input.value.trim();
    if(!email) return;

    const formData = new FormData();
    formData.append('action', 'subscribe_to_newsletter');
    formData.append('email', email);

    await fetch(ajaxUrl, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(result => {
        if(result.success){
          input.value = 'Merci!';
        } else {
          console.log('Error');
        }
      })
      .catch(err => {
        console.log(err);
      })
  })
})