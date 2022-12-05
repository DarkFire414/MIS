#include <ArduinoJson.h>
// https://arduinojson.org

int count = 0;                            // Conteo total de personas dentro del lugar
String mov = "";                          // Tipo de movimiento actual (entrada/salida)
bool dataFlag = false;                    // Indicador de que ha ocurrido la interrupción
DynamicJsonDocument access_control(1024); // Contenedor para el JSON de permisos (Necesario para que funcione MIS_WIFI.h)
char* rfid_code = "12345678";             // Código rfdi actual
char* lab = "422";                        // Identificador del laboratorio

#define ledPin 2 // Led indicador
#include "MIS_WIFI.h"

/* Manejo de interrupciones externas ESP32 
   Todos los pines GPIO pueden ser configurados para interrupciones
   https://lastminuteengineers.com/handling-esp32-gpio-interrupts-tutorial/
*/

struct Button {
  const uint8_t PIN;
  int numberKeyPresses;
  bool pressed;
};

Button entrada = {32, 0, false};
Button salida = {33,0, false};

//variables to keep track of the timing of recent interrupts
unsigned long button_time_in = 0;  
unsigned long last_button_time_in = 0; 

void IRAM_ATTR isr1() { 
  button_time_in = millis();
  if (button_time_in - last_button_time_in > 300)
  {
    Serial.println("\nInt. Entrada");   
    /////////
    mov = "entrada";
    /////////
    dataFlag = true;
    last_button_time_in = button_time_in;
  }
}

//variables to keep track of the timing of recent interrupts
unsigned long button_time_out = 0;  
unsigned long last_button_time_out = 0; 

void IRAM_ATTR isr2() {
  button_time_out = millis();
  if (button_time_out - last_button_time_out > 300)
  {
    Serial.println("\nInt. Salida");  
    dataFlag = true;
    /////////
    mov = "salida";
    /////////
    last_button_time_out = button_time_out;
  }
}

void setup() {
  Serial.begin(115200);

  pinMode(ledPin, OUTPUT);

  pinMode(entrada.PIN, INPUT_PULLUP);
  pinMode(salida.PIN, INPUT_PULLUP);

  /* Funcion para generar interrupciones
   *  attachInterrupt(digitalPinToInterrupt(interruptPin, functiontocall, MODE)
   */
  attachInterrupt(digitalPinToInterrupt(entrada.PIN), isr1, FALLING);
  attachInterrupt(digitalPinToInterrupt(salida.PIN), isr2, FALLING);
  
  scan_networks();
  
  setup_wifi();
  
  setup_mqtt();

  reconnect();
}

void loop() {

  if (dataFlag){
    Serial.print("\n Solicitud de acceso para " + String(rfid_code)); 
    if (!client.connected()) {
      reconnect();
    }
    if (client.connected()){
      if (rfid_access(rfid_code, access_control)){
        Serial.println(" -> Permitido");
        if (mov == "entrada"){
          count++;
        }
        else{
          if (count>0) count--;
        }
        sendData(rfid_code, lab, count, mov);   
      }
      else{
        Serial.println(" -> Denegado");
      }
      dataFlag = false;
    }
  }
  client.loop();
}

bool rfid_access(char* rfid_code, DynamicJsonDocument access_control){
  const char* stat = access_control[rfid_code];
  if (stat) {
    //Serial.println(stat);
    return true;
  }
  return false;
}
