// resources/js/tabs.js
export function initTabs() {
    window.showTab = function (tabName, btn) {
        // Ocultar todos los contenidos
        document.querySelectorAll("[data-tab-content]").forEach((el) => {
            el.classList.add("hidden");
        });

        // Mostrar el seleccionado
        const target = document.getElementById(`tab-${tabName}`);
        if (target) target.classList.remove("hidden");

        // Estilo de botones (Diseño Claro)
        document.querySelectorAll(".tab-btn").forEach((b) => {
            b.classList.remove("bg-white", "text-ig-dark", "shadow-sm");
            b.classList.add("text-slate-500", "hover:text-slate-800");
        });

        if (btn) {
            btn.classList.add("bg-white", "text-ig-dark", "shadow-sm");
            btn.classList.remove("text-slate-500");
        }
    };
}