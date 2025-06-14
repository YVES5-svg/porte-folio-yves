
  document.getElementById('m2').addEventListener('mouseover', function() {
    let bloc = document.getElementById('bloc');
    bloc.style.display="block";

    m2.style.color='red';
    m1.style.color='white';
    bloc1.style.display="none";
    m3.style.color='white';

  });
  document.getElementById('m1').addEventListener('mouseover', function() {
    let bloc = document.getElementById('bloc');
    bloc.style.display="none";
    m2.style.color='white';
   
    m1.style.color='red';
    bloc1.style.display="none";
  });
  
  document.getElementById('m3').addEventListener('mouseover', function() {
    let bloc1 = document.getElementById('bloc1');
    bloc1.style.display="block";
    bloc.style.display="none";
    m1.style.color='white';
    m2.style.color='white';
    m3.style.color='red';
  });

  document.getElementById('but').addEventListener('click', function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    window.location.href = 'https://wa.me/695730679'; // Redirige vers le compte WhatsApp
  });
  

  document.getElementById('nav').addEventListener('click', function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    window.location.href = 'https://wa.me/695730679'; // Redirige vers l'inbox WhatsApp
  });