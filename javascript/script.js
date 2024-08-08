document.getElementById("language").addEventListener("change", function () {
  var selectedLanguage = this.value;
  switch (selectedLanguage) {
    case "es":
      window.location.href = "/html/contacto.html"; // Página en español
      break;
    case "en":
      window.location.href = "/html/contacto.html"; // Página en inglés
      break;
    case "pt":
      window.location.href = "/html/contacto.html"; // Página en portugués
      break;
    case "it":
      window.location.href = "/html/contacto.html"; // Página en italiano
      break;
    default:
      window.location.href = "/html/contacto.html"; // Página por defecto en español
  }
});
