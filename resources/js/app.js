import './bootstrap';
import { initLayout } from './layout.js';
import { initResultado } from './resultado.js'; // Ajustado al nombre del export
import { initSearchForm } from './search-form.js';

document.addEventListener('DOMContentLoaded', () => {
    initLayout();
    initSearchForm();
    
    // Solo inicializar resultado si estamos en esa página
    if (document.querySelector('[data-tab-content]')) {
        initResultado();
    }
});