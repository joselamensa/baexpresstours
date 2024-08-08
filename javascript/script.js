document.getElementById("language").addEventListener("change", function () {
  const selectedLanguage = this.value;
  changeLanguage(selectedLanguage);
});

document.addEventListener("DOMContentLoaded", function () {
  const defaultLanguage = "es";
  document.getElementById("language").value = defaultLanguage;
  changeLanguage(defaultLanguage);
});

function changeLanguage(language) {
  document.querySelectorAll("[data-es]").forEach((element) => {
    element.textContent = element.getAttribute(`data-${language}`);
  });
}
