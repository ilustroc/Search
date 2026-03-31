import sys
import json
import requests
import re

def run_scraper(dni):
    results = []
    # Usamos una sesión para mantener las cookies activas
    session = requests.Session()
    
    url_base = "https://checatuslineas.osiptel.gob.pe/"
    url_post = "https://checatuslineas.osiptel.gob.pe/Home/GetListarLineas"
    
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36",
        "Accept": "*/*",
        "X-Requested-With": "XMLHttpRequest",
        "Referer": url_base,
        "Origin": "https://checatuslineas.osiptel.gob.pe"
    }

    try:
        # 1. Cargamos la home para obtener el Token de Seguridad invisible (__RequestVerificationToken)
        response_home = session.get(url_base, headers=headers, timeout=10)
        
        # Extraemos el token del HTML usando Regex
        token_match = re.search(r'name="__RequestVerificationToken" type="hidden" value="(.*?)"', response_home.text)
        token = token_match.group(1) if token_match else ""

        # 2. Preparamos la consulta simulando el botón del formulario
        payload = {
            "__RequestVerificationToken": token,
            "IdTipoDoc": "1", # DNI
            "NumeroDocumento": dni
        }

        # Enviamos la petición POST que es la que llena la tabla
        response_data = session.post(url_post, data=payload, headers=headers, timeout=15)
        
        # 3. Osiptel responde con HTML de la tabla. Buscamos el patrón 9xxxx****
        # Buscamos números de 5 dígitos seguidos de 4 asteriscos
        matches = re.findall(r'(\d{5})\*{4}', response_data.text)
        
        if matches:
            results = list(set(matches)) # Quitamos duplicados

    except Exception:
        pass
        
    return results

if __name__ == "__main__":
    dni_input = sys.argv[1] if len(sys.argv) > 1 else ""
    # Imprimimos el JSON para que Laravel lo atrape
    print(json.dumps(run_scraper(dni_input)))