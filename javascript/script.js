document.addEventListener("DOMContentLoaded", function () {
  const languageSelect = document.getElementById("language");
  if (languageSelect) {
    languageSelect.addEventListener("change", function () {
      const selectedLanguage = this.value;
      localStorage.setItem("language", selectedLanguage);
      changeLanguage(selectedLanguage);
    });
  }

  const storedLanguage = localStorage.getItem("language") || "es"; // Obtener el idioma guardado o 'es' por defecto
  if (languageSelect) {
    languageSelect.value = storedLanguage;
  }
  applyTranslations(storedLanguage);
  updateLinks(storedLanguage);
});

function applyTranslations(language) {
  document.querySelectorAll(`[data-${language}]`).forEach((element) => {
    element.innerHTML = element.getAttribute(`data-${language}`);
  });
}

function updateLinks(language) {
  document.querySelectorAll("a[href]").forEach((link) => {
    const href = new URL(link.getAttribute("href"), window.location.href);
    href.searchParams.set("lang", language);
    link.setAttribute("href", href.toString());
  });
}

function changeLanguage(language) {
  const url = new URL(window.location.href);
  url.searchParams.set("lang", language);
  window.location.href = url.href;
}



function initializeForm() {
  const form = document.getElementById('traslados-form');
  const formMessage = document.createElement('div');
  formMessage.id = 'form-message';
  form.appendChild(formMessage);

  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      // Mostrar un indicador de carga inmediatamente en el idioma seleccionado
      const language = document.getElementById('language').value;
      const loadingMessages = {
        'es': 'Enviando...',
        'en': 'Sending...',
        'pt': 'Enviando...',
        'it': 'Inviando...'
      };
      formMessage.textContent = loadingMessages[language] || loadingMessages['es'];
      formMessage.className = 'loading';
      formMessage.style.color = 'blue'; // Cambiar el color del texto a azul

      const formData = new FormData(this);

      fetch('./contacto.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
      })
      .then(text => {
        let data;
        try {
          data = JSON.parse(text);
        } catch (e) {
          console.error('Error al parsear JSON:', text);
          throw new Error('La respuesta del servidor no es JSON válido');
        }
        
        if (data.success) {
          // Ocultar el formulario
          form.style.display = 'none';
          
          // Mostrar mensaje de agradecimiento
          const thankYouMessage = document.createElement('div');
          thankYouMessage.className = 'thank-you-message';
          thankYouMessage.textContent = getThankYouMessage();
          form.parentNode.insertBefore(thankYouMessage, form);
        } else {
          formMessage.textContent = data.message;
          formMessage.className = 'error';
        }
      })
      .catch(error => {
        console.error('Hubo un problema con la operación fetch:', error);
        formMessage.textContent = 'Ocurrió un error al enviar el formulario: ' + error.message;
        formMessage.className = 'error';
      });
    });
  }
}

function getThankYouMessage() {
  const language = document.getElementById('language').value;
  const messages = {
    'es': 'Gracias por su contacto, nos pondremos en contacto breve.',
    'en': 'Thank you for your contact, we will get in touch shortly.',
    'pt': 'Obrigado pelo seu contato, entraremos em contato em breve.',
    'it': 'Grazie per il vostro contatto, vi contatteremo a breve.'
  };
  return messages[language] || messages['es'];
}

// Asegúrate de llamar a la función cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initializeForm);