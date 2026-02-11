// static/js/tabs.js
(function () {
  const ACTIVE_ON = ["bg-white/10", "text-white", "shadow-sm", "ring-1", "ring-white/10"];
  const ACTIVE_OFF = ["bg-white/10", "text-white", "shadow-sm", "ring-1", "ring-white/10"];

  function getTargetId(tabName) {
    // tus ids reales
    if (tabName === "principal") return "tab-principal";
    if (tabName === "financiera") return "tab-financiera";
    return `tab-${tabName}`;
  }

  window.showTab = function (tabName, btn) {
    // 1) Ocultar todos los contenidos
    document.querySelectorAll("[data-tab-content]").forEach((el) => {
      el.classList.add("hidden");
      // por si antes usaste style="display:none"
      el.style.display = "";
    });

    // 2) Mostrar el contenido objetivo
    const target = document.getElementById(getTargetId(tabName));
    if (target) target.classList.remove("hidden");

    // 3) Apagar todos los botones
    document.querySelectorAll(".tab-btn[data-tab]").forEach((b) => {
      b.setAttribute("aria-selected", "false");
      ACTIVE_OFF.forEach((c) => b.classList.remove(c));
      b.classList.add("text-white/70");
    });

    // 4) Encender el botón activo
    const activeBtn = btn || document.querySelector(`.tab-btn[data-tab="${tabName}"]`);
    if (activeBtn) {
      activeBtn.setAttribute("aria-selected", "true");
      activeBtn.classList.remove("text-white/70");
      ACTIVE_ON.forEach((c) => activeBtn.classList.add(c));
    }
  };

  // Estado inicial consistente
  document.addEventListener("DOMContentLoaded", () => {
    const preselected = document.querySelector('.tab-btn[data-tab][aria-selected="true"]');
    const tab = preselected?.dataset?.tab || "principal";
    window.showTab(tab, preselected || undefined);
  });
})();