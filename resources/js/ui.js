// static/js/ui.js
function toggleAccordion(element) {
  const parent = element.closest(".accordion-item") || element.parentElement;
  if (!parent) return;
  parent.classList.toggle("open");
}
