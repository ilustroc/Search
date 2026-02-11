export function initLayout() {
    // Lógica para el buscador del header (limpiar caracteres no numéricos)
    const headerSearch = document.querySelector('.search-input-header');
    if (headerSearch) {
        headerSearch.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }
}