// resources/js/resultado.js

export function initResultado() {
    // --- LÓGICA DE PESTAÑAS (Igual) ---
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

    // --- LÓGICA DE VERIFICACIÓN REAL ---
    const rows = document.querySelectorAll('tr[data-phone]');
    
    rows.forEach(async (row) => {
        const phone = row.getAttribute('data-phone');
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
                btn.title = "Número no registrado en WhatsApp";
            }
        } catch (error) {
            if (dots) dots.textContent = "!";
        }

        // CONTROL DE CLIC PARA WHATSAPP
        btn.addEventListener('click', (e) => {
            if (btn.dataset.active === "false") {
                e.preventDefault();
                alert(`El número +51 ${phone} no está en WhatsApp.`);
            }
        });
    });
}