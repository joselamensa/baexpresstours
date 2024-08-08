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
