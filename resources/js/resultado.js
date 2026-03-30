// resources/js/resultado.js

export function initResultado() {
    // --- LÓGICA DE PESTAÑAS ---
    window.showTab = function (tabName, btn) {
        document.querySelectorAll("[data-tab-content]").forEach(el => el.classList.add("hidden"));
        const target = document.getElementById(`tab-${tabName}`);
        if (target) target.classList.remove("hidden");
        document.querySelectorAll(".tab-btn").forEach(b => {
            b.classList.remove("bg-white", "text-[#4C1D95]", "shadow-md", "ring-1", "ring-slate-200");
            b.classList.add("text-slate-500");
        });
        if (btn) btn.classList.add("bg-white", "text-[#4C1D95]", "shadow-md", "ring-1", "ring-slate-200");
    };

    const defaultBtn = document.querySelector('.tab-btn[data-tab="principal"]');
    if (defaultBtn) window.showTab('principal', defaultBtn);

    // --- SELECCIÓN DE FILAS ---
    const rows = document.querySelectorAll('tr[data-phone]');
    if (rows.length === 0) return;

    // --- 1. VALIDACIÓN ASÍNCRONA DE OSIPTEL (UNA VEZ POR DNI) ---
    const dni = rows[0].getAttribute('data-dni');
    if (dni) {
        consultarOsiptel(dni, rows);
    }

    // --- 2. VALIDACIÓN ASÍNCRONA DE WHATSAPP (FILA POR FILA) ---
    rows.forEach(async (row) => {
        const phone = row.getAttribute('data-phone');
        validarWhatsapp(phone, row);
    });
}

/**
 * Consulta la titularidad en Osiptel vía AJAX
 */
async function consultarOsiptel(dni, rows) {
    try {
        const response = await fetch(`/api/consultar-osiptel/${dni}`);
        const verificados = await response.json(); // Se espera un array de prefijos ["93049", ...]

        rows.forEach(row => {
            const phone = row.getAttribute('data-phone');
            const prefijo = phone.substring(0, 5);
            const statusContainer = row.querySelector('.status-osiptel');
            const operadorText = row.querySelector('.operador-text');
            const typeBadge = row.querySelector('.type-badge');

            if (verificados && verificados.includes(prefijo)) {
                // MARCADO COMO VERIFICADO
                statusContainer.innerHTML = `
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20 uppercase">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                        Verificado
                    </span>`;
                
                // Actualización visual de operador y tipo
                if (prefijo.startsWith('930')) operadorText.innerText = 'MOVISTAR';
                if (typeBadge) typeBadge.innerText = 'POSTPAGO';
            } else {
                // MARCADO COMO NO ENCONTRADO
                statusContainer.innerHTML = `<span class="text-[10px] text-slate-300 italic lowercase">sin validar</span>`;
            }
        });
    } catch (error) {
        console.error("Error Osiptel:", error);
        document.querySelectorAll('.status-osiptel').forEach(el => el.innerHTML = `<span class="text-[9px] text-red-400">Error</span>`);
    }
}

/**
 * Consulta el estado de WhatsApp vía AJAX
 */
async function validarWhatsapp(phone, row) {
    const btn = row.querySelector('.whatsapp-btn');
    if (!btn) return;

    const dots = btn.querySelector('.status-dots');
    const icon = btn.querySelector('.whatsapp-icon');

    try {
        const response = await fetch(`/api/validar-whatsapp/${phone}`);
        const data = await response.json();

        if (dots) dots.classList.add("hidden");
        if (icon) icon.classList.remove("hidden");
        btn.classList.remove("opacity-50", "cursor-wait", "bg-slate-100", "text-slate-400");

        if (data.exists) {
            btn.classList.add("bg-emerald-100", "text-emerald-600", "hover:bg-emerald-600", "hover:text-white");
            btn.dataset.active = "true";
        } else {
            btn.classList.add("bg-slate-100", "text-slate-300");
            btn.dataset.active = "false";
            btn.style.opacity = "0.5";
            btn.title = "No registrado";
        }
    } catch (error) {
        if (dots) dots.textContent = "!";
    }

    // Control de clic
    btn.addEventListener('click', (e) => {
        if (btn.dataset.active === "false") {
            e.preventDefault();
            alert(`El número +51 ${phone} no está en WhatsApp.`);
        }
    });
}