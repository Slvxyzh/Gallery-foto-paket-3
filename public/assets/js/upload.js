document.addEventListener('DOMContentLoaded', function() {
  const pick = document.getElementById('pick');
  const blah = document.querySelector('.blah');

  pick.addEventListener('change', function(evt) {
    const file = evt.target.files[0];
    console.log(file);
    if (file) {
      blah.src = URL.createObjectURL(file);
      blah.style.width = '100%';
    }
  });
});