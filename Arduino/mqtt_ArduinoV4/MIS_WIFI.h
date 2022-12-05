#include <WiFi.h>
#include <PubSubClient.h>

//**************************************
//*********** MQTT CONFIG **************
//**************************************
const char *mqtt_server = "192.168.188.38";//"192.168.1.102";
const int mqtt_port = 1883;
const char *mqtt_user = "user";
const char *mqtt_pass = "pass";

/*
 * Modificar la variable root_topic_publish
 * con la siguiente forma
 * /salón
 */
const char *root_topic_subscribe = "/lab317p";
const char *root_topic_publish = "/lab317";

/*
 * Escaneo de redes:
 * Cuando se reinicia la ESP se hace un escaneo de las redes disponibles y se muestran
 * por el monitor serial, junto con la potencia de la señal de cada una.
 * 
 * Led de estado
 * Mientras se esté conectando a una red wifi, el led de la ESP32
 * parpadea 2 veces.
 * Si falló la conexión a mqtt el led parpadea 3 veces.
 * Cada que se envía un dato el led parpadea una vez.
 * 
 * Reconexión
 * La conexión a wifi se comprueba cada que se intenta enviar un dato por mqtt
 * si se pierde la conexión wifi, se intenta reconectar.
 * Después de 10 segundos si la esp no se pudo conectar se reinicia automáticamente.
 */

//**************************************
//*********** WIFICONFIG ***************
//**************************************
const char* ssid = "RED";//"LAPTOP-97AOTULK 4738";//"TP-LINK_5063C7";
const char* password = "12345678";//"09h;503S";//"025063C7";

//**************************************
//*********** GLOBALES   ***************
//**************************************
WiFiClient espClient;
PubSubClient client(espClient);
char msg[100];

//****************************
//***    FUNCIONES         ***
//****************************
void blink_led(unsigned int times, unsigned int duration);
void setup_wifi();
void scan_networks();
void setup_mqtt();
void sendData(char* rfid_code, char* lab, int count);
void reconnect();
void callback(char* topic, byte* payload, unsigned int length);

void blink_led(unsigned int times, unsigned int duration){
  for (int i = 0; i < times; i++) {
    digitalWrite(ledPin, HIGH);
    delay(duration);
    digitalWrite(ledPin, LOW); 
    delay(200);
  }
}

//*****************************
//***    CONEXION WIFI      ***
//*****************************
void setup_wifi(){
  delay(10);
  // Nos conectamos a nuestra red Wifi
  Serial.print("Conectando a ssid: ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  int c=0;
  while (WiFi.status() != WL_CONNECTED) {
    blink_led(2,200); //blink LED twice (for 200ms ON time) to indicate that wifi not connected
    delay(1000);
    Serial.print(".");
    c++;
    if (c>10) {
      Serial.println("\n Se ha alcanzado el máximo número de intentos. Reiniciando ESP \n"); 
      ESP.restart();
    }
  }

  Serial.println("");
  Serial.println("Conectado a red WiFi!");
  Serial.print("Dirección IP: ");
  Serial.println(WiFi.localIP());
  Serial.print("Direccion Mac: ");
  Serial.println(WiFi.macAddress());
}

void scan_networks(){
  // Set WiFi to station mode and disconnect from an AP if it was previously connected
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();
  delay(100);
  
  Serial.println("\nIniciando escaneo de redes");

  // WiFi.scanNetworks will return the number of networks found
  int n = WiFi.scanNetworks();
  Serial.println("Escaneo completo");
  if (n == 0) {
      Serial.println("No se encontraron redes.");
  } else {
    Serial.print(n);
    Serial.println(" Redes encontradas");
    for (int i = 0; i < n; ++i) {
      // Print SSID and RSSI (Received Signal Strength Indicator) for each network found
      Serial.print(i + 1);
      Serial.print(": ");
      Serial.print(WiFi.SSID(i));
      Serial.print(" (");
      Serial.print(WiFi.RSSI(i));
      Serial.print(")");
      Serial.println((WiFi.encryptionType(i) == WIFI_AUTH_OPEN)?" ":"*");
      delay(10);
    }
  }
  Serial.println("");
}

//*****************************
//***    CONEXION MQTT      ***
//*****************************

void setup_mqtt(){
  client.setServer(mqtt_server, mqtt_port);
  client.setCallback(callback);
}

void sendData(char* rfid_code, char* lab, int count, String mov){
  String str = "{ \"lab\": \"" + String(lab) + "\", \"rfid\": \"" + String(rfid_code) + "\", \"mov\": \"" + mov + "\", \"count\": " + String(count) + "}";
  str.toCharArray(msg,100);
  client.publish(root_topic_publish,msg);
  blink_led(1, 100);
  Serial.print("\n Enviando: "); Serial.print(str);
}

void reconnect() {

  while (!client.connected()) {
     //first check if connected to wifi
    if(WiFi.status() != WL_CONNECTED){
      //if not connected, then first connect to wifi
      setup_wifi();
    }
        
    Serial.print("Intentando conexión Mqtt...");
    // Creamos un cliente ID
    String clientId = "Protocolos_av_";
    clientId += String(random(0xffff), HEX);
    // Intentamos conectar
    if (client.connect(clientId.c_str(),mqtt_user,mqtt_pass)) {
      Serial.println("Conectado!");
      // Nos suscribimos
      if(client.subscribe(root_topic_subscribe)){
        Serial.println("Suscripcion ok");
      }else{
        Serial.println("fallo Suscripciión");
      }
    } else {
      Serial.print("falló :( con error -> ");
      Serial.print(client.state());
      Serial.println(" Intentamos de nuevo en 2 segundos");
      blink_led(3,200); //blink LED three times (200ms on duration) to show that MQTT server connection attempt failed
      delay(2000);
    }
  }
}


//*****************************
//***       CALLBACK        ***
//*****************************

void callback(char* topic, byte* payload, unsigned int length){
  String incoming = "";
  Serial.print("Mensaje recibido desde -> ");
  Serial.print(topic);
  Serial.println("");
  for (int i = 0; i < length; i++) {
    incoming += (char)payload[i];
  }
  incoming.trim();
  Serial.println("Mensaje -> " + incoming);
  deserializeJson(access_control, incoming);
}
