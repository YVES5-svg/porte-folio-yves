document.addEventListener("DOMContentLoaded", function() {
  const form = document.querySelector("form");
  const emailInput = document.getElementById("email");
  const messageInput = document.getElementById("messageInput");

  form.addEventListener("submit", function(event) {
      event.preventDefault(); // Empêcher l'envoi du formulaire par défaut
      
      let isValid = true;

      // Vérification du champ email
      const emailValue = emailInput.value.trim();
      const emailFeedback = emailInput.nextElementSibling;
      if (!emailValue || !validateEmail(emailValue)) {
          emailFeedback.textContent = "Veuillez entrer une adresse e-mail valide.";
          emailFeedback.style.color = "red";
          emailInput.style.borderColor = "red";
          isValid = false;
      } else {
          emailFeedback.textContent = "Email valide ✔";
          emailFeedback.style.color = "green";
          emailInput.style.borderColor = "green";
      }

      // Vérification du champ message
      const messageValue = messageInput.value.trim();
      let messageFeedback = document.createElement("div");
      messageFeedback.classList.add("valid-feedback");
      if (!messageValue) {
          messageFeedback.textContent = "Veuillez entrer un message.";
          messageFeedback.style.color = "red";
          messageInput.style.borderColor = "red";
          messageInput.parentNode.appendChild(messageFeedback);
          isValid = false;
      } else {
          messageFeedback.textContent = "Message bien rempli ✔";
          messageFeedback.style.color = "green";
          messageInput.style.borderColor = "green";
          messageInput.parentNode.appendChild(messageFeedback);
      }

      // Soumettre le formulaire si tout est valide
      if (isValid) {
          alert("Formulaire soumis avec succès !");
          form.submit();
      }
  });

  // Fonction de validation d'email
  function validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
  }
});
