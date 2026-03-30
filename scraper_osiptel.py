import sys
import json
import requests

def run_scraper(dni):
    url = "https://checatuslineas.osiptel.gob.pe/Home/GetListarLineas"
    
    # Estos headers son obligatorios para que Osiptel crea que vienes de su web
    headers = {
        "Accept": "*/*",
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        "X-Requested-With": "XMLHttpRequest",
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
        "Origin": "https://checatuslineas.osiptel.gob.pe",
        "Referer": "https://checatuslineas.osiptel.gob.pe/"
    }

    payload = {
        "IdTipoDoc": "1",
        "NumeroDocumento": dni
    }

    try:
        # Hacemos la petición directa al motor de la tabla
        response = requests.post(url, data=payload, headers=headers, timeout=10)
        
        # Osiptel devuelve un HTML parcial con los <td>
        html_response = response.text
        
        import re
        # Buscamos los números con formato 9xxxx****
        matches = re.findall(r'(\d{5})\*{4}', html_response)
        
        return list(set(matches))
    except:
        return []

if __name__ == "__main__":
    dni_arg = sys.argv[1] if len(sys.argv) > 1 else ""
    print(json.dumps(run_scraper(dni_arg)))