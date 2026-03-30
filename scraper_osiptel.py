import sys
import json
import requests
import re

def run_scraper(dni):
    results = []
    # Usamos una sesión para persistir las cookies de la sesión de Osiptel
    session = requests.Session()
    
    url_base = "https://checatuslineas.osiptel.gob.pe/"
    
    # Headers que imitan a un navegador Chrome real
    headers = {
        "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
        "Accept-Language": "es-ES,es;q=0.9",
        "Connection": "keep-alive",
        "Host": "checatuslineas.osiptel.gob.pe",
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    }

    try:
        # 1. Cargamos la página inicial para obtener las cookies obligatorias (.AspNetCore.Antiforgery)
        first_res = session.get(url_base, headers=headers, timeout=10)
        
        # 2. Extraemos el Token de validación que Osiptel oculta en el HTML
        token_match = re.search(r'name="__RequestVerificationToken" type="hidden" value="(.*?)"', first_res.text)
        token = token_match.group(1) if token_match else ""

        # 3. Petición de búsqueda (POST es el método que usa su tabla interna)
        search_url = f"{url_base}Home/GetListarLineas"
        
        payload = {
            "__RequestVerificationToken": token,
            "IdTipoDoc": "1", # DNI
            "NumeroDocumento": dni
        }

        # Enviamos la consulta simulando el clic
        res = session.post(search_url, data=payload, headers=headers, timeout=15)
        
        # 4. Buscamos el patrón numérico 9xxxx****
        # Osiptel devuelve un JSON o un HTML con la tabla. Buscamos en ambos.
        matches = re.findall(r'(\d{5})\*{4}', res.text)
        
        if matches:
            results = list(set(matches))

    except Exception:
        pass
        
    return results

if __name__ == "__main__":
    if len(sys.argv) > 1:
        dni_arg = sys.argv[1]
        print(json.dumps(run_scraper(dni_arg)))
    else:
        print(json.dumps([]))