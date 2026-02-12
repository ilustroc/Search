export function initSearchForm() {
    const form = document.getElementById("form-buscar");
    const input = document.getElementById("busqueda-input");
    const errorBox = document.getElementById("error-box");
    const errorMsg = document.getElementById("error-msg");

    if (!form || !input) return;

    // Solo permitir números
    input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, "");
        if (errorBox) errorBox.classList.add("hidden");
    });

    form.addEventListener("submit", (e) => {
        const v = input.value.trim();
        
        // Validación local de 8 dígitos
        if (v.length !== 8) {
            e.preventDefault();
            if (errorMsg) {
                errorMsg.textContent = "⚠️ DNI inválido. Debe tener exactamente 8 dígitos.";
            }
            if (errorBox) {
                errorBox.classList.remove("hidden");
            } else {
                alert("DNI inválido. Debe tener 8 dígitos.");
            }
        }
    });
}