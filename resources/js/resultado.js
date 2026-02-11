// resources/js/resultado.js

export function initResultado() {
    window.showTab = function (tabName, btn) {
        // 1. Ocultar todos los contenidos
        document.querySelectorAll("[data-tab-content]").forEach(el => el.classList.add("hidden"));

        // 2. Mostrar el seleccionado
        const target = document.getElementById(`tab-${tabName}`);
        if (target) target.classList.remove("hidden");

        // 3. Resetear todos los botones a estado "Apagado"
        document.querySelectorAll(".tab-btn").forEach(b => {
            b.classList.remove("bg-white", "text-[#4C1D95]", "shadow-md", "ring-1", "ring-slate-200");
            b.classList.add("text-slate-500");
            b.setAttribute('aria-selected', 'false');
        });

        // 4. Encender el botón actual
        if (btn) {
            btn.classList.add("bg-white", "text-[#4C1D95]", "shadow-md", "ring-1", "ring-slate-200");
            btn.classList.remove("text-slate-500");
            btn.setAttribute('aria-selected', 'true');
        }
    };

    // --- ESTO ES LO QUE FALTA: Autoejecución al cargar ---
    const defaultBtn = document.querySelector('.tab-btn[data-tab="principal"]');
    if (defaultBtn) {
        window.showTab('principal', defaultBtn);
    }
}