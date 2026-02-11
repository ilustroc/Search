export function initSearchForm() {
    const tabDni = document.getElementById("tab-dni");
    const tabRuc = document.getElementById("tab-ruc");
    const tipoInput = document.getElementById("tipo-input");
    const input = document.getElementById("busqueda-input");
    const label = document.getElementById("label-busqueda");
    const helper = document.getElementById("helper");
    const form = document.getElementById("form-buscar");
    const errorBox = document.getElementById("error-box");
    const errorMsg = document.getElementById("error-msg");

    if (!tabDni || !tabRuc || !tipoInput || !input || !form) return;

    /**
     * Estilos para el diseño Light Mode
     */
    const paintTabs = (tipo) => {
        const base = "tab-btn rounded-xl px-4 py-2.5 text-sm font-bold transition-all select-none";
        const active = " bg-white text-[#4C1D95] shadow-md shadow-slate-200";
        const inactive = " text-slate-500 hover:text-slate-700";

        tabDni.className = base + (tipo === "DNI" ? active : inactive);
        tabRuc.className = base + (tipo === "RUC" ? active : inactive);
    };

    const setActive = (tipo) => {
        paintTabs(tipo);
        tipoInput.value = tipo;
        input.value = "";
        if (errorBox) errorBox.classList.add("hidden");

        if (tipo === "DNI") {
            if (label) label.textContent = "Número de DNI";
            if (helper) helper.textContent = "Ingresa un DNI válido de 8 dígitos.";
            input.placeholder = "Ej: 12345678";
            input.maxLength = 8;
        } else {
            if (label) label.textContent = "Número de RUC";
            if (helper) helper.textContent = "Ingresa un RUC válido de 11 dígitos.";
            input.placeholder = "Ej: 20123456789";
            input.maxLength = 11;
        }
        input.focus();
    };

    // Filtros y Validaciones
    input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, "");
    });

    form.addEventListener("submit", (e) => {
        const tipo = tipoInput.value;
        const v = input.value.trim();
        const ok = (tipo === "DNI" && v.length === 8) || (tipo === "RUC" && v.length === 11);

        if (!ok) {
            e.preventDefault();
            if (errorMsg) {
                errorMsg.textContent = `⚠️ ${tipo} inválido. Debe tener ${tipo === "DNI" ? '8' : '11'} dígitos.`;
            }
            if (errorBox) errorBox.classList.remove("hidden");
        }
    });

    tabDni.addEventListener("click", () => setActive("DNI"));
    tabRuc.addEventListener("click", () => setActive("RUC"));

    // Inicialización por defecto
    setActive("DNI");
}