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
    # --- RUTAS CORREGIDAS SEGÚN TU TREE ---
    CHROME_PATH = "/home/u480021566/domains/consorcioabogadosperu.com/public_html/search/bin/chrome-linux64/chrome-linux64/chrome"
    DRIVER_PATH = "/home/u480021566/domains/consorcioabogadosperu.com/public_html/search/bin/chromedriver-linux64/chromedriver"

    chrome_options = Options()
    chrome_options.binary_location = CHROME_PATH
    chrome_options.add_argument("--headless=new") # Nueva sintaxis de headless
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--disable-dev-shm-usage")
    chrome_options.add_argument("--disable-gpu")
    chrome_options.add_argument("--single-process") # Crítico para servidores limitados
    chrome_options.add_argument("--window-size=1920,1080")
    
    chrome_options.add_argument("user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36")
    
    results = []
    driver = None

    try:
        service = Service(DRIVER_PATH)
        driver = webdriver.Chrome(service=service, options=chrome_options)
        
        driver.get("https://checatuslineas.osiptel.gob.pe/")
        
        # Espera hasta que el input sea visible
        wait = WebDriverWait(driver, 10)
        
        # 1. Seleccionar DNI
        doc_select = wait.until(EC.presence_of_element_located((By.ID, "IdTipoDoc")))
        for option in doc_select.find_elements(By.TAG_NAME, "option"):
            if option.text.strip() == "DNI":
                option.click()
                break
        
        # 2. Ingresar número
        input_box = driver.find_element(By.ID, "NumeroDocumento")
        input_box.send_keys(dni)
        
        # 3. Click Buscar usando JS para mayor seguridad
        btn_buscar = driver.find_element(By.ID, "btnBuscar")
        driver.execute_script("arguments[0].click();", btn_buscar)
        
        # 4. Espera a que la tabla se refresque
        time.sleep(5) 
        
        rows = driver.find_elements(By.CSS_SELECTOR, "#GridConsulta tbody tr")
        
        for row in rows:
            cells = row.find_elements(By.TAG_NAME, "td")
            if len(cells) >= 2:
                texto_numero = cells[1].text.strip()
                if "*" in texto_numero:
                    prefix = texto_numero.replace("*", "").strip()
                    if prefix:
                        results.append(prefix)
                    
    except Exception as e:
        # Descomenta la línea de abajo solo para ver el error en la terminal
        # sys.stderr.write(f"DEBUG ERROR: {str(e)}\n")
        pass 
    finally:
        if driver:
            driver.quit()
        
    return list(set(results))

if __name__ == "__main__":
    dni_arg = sys.argv[1] if len(sys.argv) > 1 else ""
    print(json.dumps(run_scraper(dni_arg)))