import './bootstrap';

// Esperamos a que el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
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
     * Aplica las clases de Tailwind v4 dinámicamente
     */
    const paintTabs = (tipo) => {
        const base = "tab-btn rounded-xl px-4 py-2 text-sm font-semibold transition select-none";
        const active = " bg-white text-[#4C1D95] shadow-sm";
        const inactive = " bg-transparent text-white/70 hover:text-white";

        tabDni.className = base + (tipo === "DNI" ? active : inactive);
        tabRuc.className = base + (tipo === "RUC" ? active : inactive);
    };

    /**
     * Cambia el estado del formulario entre DNI y RUC
     */
    const setActive = (tipo) => {
        paintTabs(tipo);
        tipoInput.value = tipo;

        // Reset de campos y errores
        input.value = "";
        if (errorBox) errorBox.classList.add("hidden");

        if (tipo === "DNI") {
            if (label) label.textContent = "Documento (DNI)";
            if (helper) helper.textContent = "Ingresa un DNI de 8 dígitos.";
            input.name = "documento"; // Es mejor usar un nombre genérico para el controlador
            input.placeholder = "Ej: 12345678";
            input.maxLength = 8;
        } else {
            if (label) label.textContent = "RUC";
            if (helper) helper.textContent = "Ingresa un RUC de 11 dígitos.";
            input.name = "documento"; 
            input.placeholder = "Ej: 20123456789";
            input.maxLength = 11;
        }

        input.focus();
    };

    // Filtro: Solo números
    input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, "");
    });

    // Validación antes de enviar
    form.addEventListener("submit", (e) => {
        const tipo = tipoInput.value;
        const v = input.value.trim();
        const ok = (tipo === "DNI" && v.length === 8) || (tipo === "RUC" && v.length === 11);

        if (!ok) {
            e.preventDefault();
            if (errorMsg) {
                errorMsg.textContent = tipo === "DNI"
                    ? "DNI inválido. Debe tener 8 dígitos."
                    : "RUC inválido. Debe tener 11 dígitos.";
            }
            if (errorBox) errorBox.classList.remove("hidden");
        }
    });

    // Eventos de click
    tabDni.addEventListener("click", () => setActive("DNI"));
    tabRuc.addEventListener("click", () => setActive("RUC"));

    // Inicialización
    setActive("DNI");
});