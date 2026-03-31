import sys
import json
import time
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def run_scraper(dni):
    # --- RUTAS DE HOSTINGER ---
    CHROME_PATH = "/home/u480021566/domains/consorcioabogadosperu.com/public_html/search/bin/chrome-linux64/chrome-linux64/chrome"
    DRIVER_PATH = "/home/u480021566/domains/consorcioabogadosperu.com/public_html/search/bin/chromedriver-linux64/chromedriver"

    chrome_options = Options()
    chrome_options.binary_location = CHROME_PATH
    chrome_options.add_argument("--headless")
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--disable-dev-shm-usage")
    chrome_options.add_argument("--window-size=1920,1080")
    chrome_options.add_argument("--log-level=3")
    chrome_options.add_argument("--silent")
    
    # User agent para evitar bloqueos
    chrome_options.add_argument("user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36")
    chrome_options.add_experimental_option('excludeSwitches', ['enable-logging'])
    
    # Inicialización del servicio
    service = Service(DRIVER_PATH)
    
    results = []
    driver = None

    try:
        driver = webdriver.Chrome(service=service, options=chrome_options)
        driver.get("https://checatuslineas.osiptel.gob.pe/")
        wait = WebDriverWait(driver, 15)
        
        # 1. Seleccionar DNI
        doc_select = wait.until(EC.element_to_be_clickable((By.ID, "IdTipoDoc")))
        for option in doc_select.find_elements(By.TAG_NAME, "option"):
            if option.text == "DNI":
                option.click()
                break
        
        # 2. Ingresar número
        input_box = driver.find_element(By.ID, "NumeroDocumento")
        input_box.clear()
        input_box.send_keys(dni)
        
        # 3. Click Buscar
        btn_buscar = driver.find_element(By.ID, "btnBuscar")
        driver.execute_script("arguments[0].click();", btn_buscar)
        
        # 4. Pausa para carga de tabla dinámica
        time.sleep(4) 
        
        rows = driver.find_elements(By.CSS_SELECTOR, "#GridConsulta tbody tr")
        
        for row in rows:
            cells = row.find_elements(By.TAG_NAME, "td")
            if len(cells) >= 2:
                texto_numero = cells[1].text.strip()
                if "*" in texto_numero:
                    # Extraer los 5 dígitos: "93049****" -> "93049"
                    prefix = texto_numero.replace("*", "")
                    if prefix:
                        results.append(prefix)
                    
    except Exception as e:
        # En producción puedes comentar esto para no ensuciar el JSON de salida
        # sys.stderr.write(f"Error: {str(e)}\n")
        pass 
    finally:
        if driver:
            driver.quit()
        
    return list(set(results))

if __name__ == "__main__":
    if len(sys.argv) > 1:
        dni_arg = sys.argv[1]
        print(json.dumps(run_scraper(dni_arg)))
    else:
        print(json.dumps([]))