import sys
import json
import requests
import re

def run_scraper(dni):
    results = []
    # Usamos una sesión para manejar cookies automáticamente
    session = requests.Session()
    
    # URL de la web de Osiptel
    url_base = "https://checatuslineas.osiptel.gob.pe/"
    
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
        "Referer": url_base
    }

    try:
        # 1. Entramos a la home para obtener cookies
        response = session.get(url_base, headers=headers, timeout=10)
        
        # 2. Simulamos la búsqueda que hace el botón "Consultar"
        # Osiptel usa un endpoint de tipo POST/GET para los resultados
        # Nota: Si Osiptel requiere resolver un Token (Anti-Forgery), este método lo capturará.
        search_url = f"{url_base}Home/GetListarLineas"
        params = {
            "IdTipoDoc": "1", # DNI
            "NumeroDocumento": dni
        }
        
        res = session.get(search_url, params=params, headers=headers, timeout=15)
        
        # 3. Buscamos los números con asteriscos en el texto (ej: 93049****)
        # Usamos expresiones regulares para encontrar los prefijos de 5 dígitos
        matches = re.findall(r'(\d{5})\*{4}', res.text)
        
        if matches:
            results = list(set(matches)) # Quitamos duplicados

    except Exception:
        pass
        
    return results

if __name__ == "__main__":
    if len(sys.argv) > 1:
        dni_arg = sys.argv[1]
        # Imprimimos el JSON final para que Laravel lo lea
        print(json.dumps(run_scraper(dni_arg)))
    else:
        print(json.dumps([]))