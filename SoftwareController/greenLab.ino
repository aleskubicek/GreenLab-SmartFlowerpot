// greenLab
// A.Kubicek  |  V.Kaniok  |  M.Bernat
// SSINFOTECH

#include <Wire.h>
#include <BH1750.h>
#include "SparkFunHTU21D.h"
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <Adafruit_NeoPixel.h>

#define PocetLED      11

Adafruit_NeoPixel pixels = Adafruit_NeoPixel(PocetLED, D6, NEO_GRB + NEO_KHZ800);


BH1750 senzorOsvetleni;
HTU21D senzorVlhkostiTeploty;
WiFiClient client;

//WiFi připojení
const char* ssid     = "BASTY";
const char* password = "basty1234567890";
const char* host = "greenlab.kaniok.com";
String line;
int oldR;
int oldG;
int oldB;

//funkce vyhledavání v textu
int find_text(String needle, String haystack,int from) {
  int foundpos = -1;
  if (haystack.length()<needle.length())
    return foundpos;
  for (int i = from; (i < haystack.length() - needle.length()); i++) {
    if (haystack.substring(i,needle.length()+i) == needle) {
      foundpos = i;
      return foundpos;
    }
  }
  return foundpos;
}


void setup(){
  pixels.begin(); 
  Serial.begin(9600);
  pinMode(D8, OUTPUT);
  senzorOsvetleni.begin();
  senzorVlhkostiTeploty.begin();
  WiFi.begin(ssid, password);
}


void loop() {
  //proměnné určeny pro rozseparování stringu z webu
  String hum = "";
String lig ="";
String lux = "";
String red = "";
String gre = "";
String blu = "";

  HTTPClient httpKlient;
//výpis hodnot z senzoru do konzole
  uint16_t luxy = senzorOsvetleni.readLightLevel();
  int vlh_okoli = senzorVlhkostiTeploty.readHumidity()*10;
  int tepl_okoli = (senzorVlhkostiTeploty.readTemperature())*10;
  float vlh_pudy = analogRead(A0);
  vlh_pudy = (vlh_pudy-1023)/(420-1023)*100;
Serial.print("Time:");
    Serial.print(millis());
    Serial.print(" Temperature:");
    Serial.print(tepl_okoli, 1);
    Serial.print("C");
    Serial.print(" Humidity:");
    Serial.print(vlh_okoli, 1);
    Serial.print("%");
    Serial.println();
    Serial.print("Light: ");
    Serial.print(luxy);
    Serial.println();
    Serial.print("Puda: ");
    Serial.print(vlh_pudy);
    Serial.println(" %");
  //odesílání hodnot ze senzoru na web
  if (vlh_okoli < 500 && tepl_okoli < 500 && luxy < 50000) {
    //
    String odkaz = "http://greenlab.kaniok.com/php/data_fromPLC.php?";
    odkaz += "temp=";
    odkaz += tepl_okoli;
    odkaz +="&hum_in=";
    odkaz += vlh_okoli;
    odkaz +="&hum_out=";
    odkaz +=vlh_pudy;
    odkaz +="&lux=";
    odkaz +=luxy;

    //odeslání požadavku  
    httpKlient.begin(odkaz);
    int kodHttp = httpKlient.GET();
    httpKlient.end();
    
    delay(1000);
    

    
  }
  //odesílání notifikací
  if(tepl_okoli > 250)
  {
      httpKlient.begin(http://greenlab.kaniok.com/php/notify_temp.php);
    int kodHttp = httpKlient.GET();
    httpKlient.end();
  }
   if(vlh_okoli > 500)
  {
      httpKlient.begin(http://greenlab.kaniok.com/php/notify_humOut.php);
    int kodHttp = httpKlient.GET();
    httpKlient.end();
  }
   if(vlh_okoli < 30)
  {
      httpKlient.begin(http://greenlab.kaniok.com/php/notify_humIn.php);
    int kodHttp = httpKlient.GET();
    httpKlient.end();
  }
  //získávání nastavených parametru z webu (procenta udržování vlhkosti, luxy automatického osvětlení, barva osvětlení)
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
   
  }
  String url = "/php/data_toPLC.php";
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  delay(500);
  
  // rozseparování stringu line na jednotlive hodnoty
  while(client.available()){
   line = client.readStringUntil('\r');
   int start_loc = find_text("<hum>", line, 0);
   int end_loc = find_text("<lig>", line, 0);
   for (int i=start_loc+5;i<end_loc;i++)
  {
    hum += line[i];
  }
  int start_loc2= find_text("<lig>",line,end_loc);
  int end_loc2=find_text("<lux>",line,end_loc+1);
  for (int i=start_loc2+5;i<end_loc2;i++)
  {
    lig += line[i];
  }
  int start_loc3= find_text("<lux>",line,end_loc2);
  int end_loc3=find_text("<red>",line,end_loc2+1);
  for (int i=start_loc3+5;i<end_loc3;i++)
  {
    lux += line[i];
  }
  int start_loc4= find_text("<red>",line,end_loc3);
  int end_loc4=find_text("<gre>",line,end_loc3+1);
  for (int i=start_loc4+5;i<end_loc4;i++)
  {
    red += line[i];
  }
   int start_loc5= find_text("<gre>",line,end_loc4);
  int end_loc5=find_text("<blu>",line,end_loc4+1);
  for (int i=start_loc5+5;i<end_loc5;i++)
  {
    gre += line[i];
  }
     int start_loc6= find_text("<blu>",line,end_loc5);
  int end_loc6=find_text("</",line,end_loc5+1);
  for (int i=start_loc6+5;i<end_loc6;i++)
  {
    blu += line[i];
  }
  
  

   

}
//parsování hodnot
int humidityFromWeb = hum.toInt();
bool lightFromWeb = lig.toInt();
int luxFromWeb = lux.toInt();
int redFromWeb = red.toInt();
int greenFromWeb = gre.toInt();
int blueFromWeb = blu.toInt();
//přepis barev led diod při změně barvy, zapnutí osvětlení nebo poklesu luxu
if(lightFromWeb == 1 && luxFromWeb > luxy &&( oldR != redFromWeb || oldG != greenFromWeb || oldB != blueFromWeb)){
  //zapis starych barev do proměnných
  oldR = redFromWeb;
  oldG = greenFromWeb;
  oldB = blueFromWeb;
  Serial.println("sviti");
     pixels.setPixelColor(0, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(1, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(2, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(3, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(4, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(5, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(6, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(7, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(8, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(9, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
     pixels.setPixelColor(10, pixels.Color(redFromWeb,greenFromWeb,blueFromWeb));
    pixels.show(); 
  
}
//vypínáni světla
else if(lightFromWeb == 0 || luxFromWeb < luxy){
  oldR = 0;
  oldG = 0;
  oldB = 0;
  Serial.println("nesviti");
   pixels.setPixelColor(0, pixels.Color(0,0,0));
    pixels.setPixelColor(1, pixels.Color(0,0,0));
    pixels.setPixelColor(2, pixels.Color(0,0,0));
    pixels.setPixelColor(3, pixels.Color(0,0,0));
    pixels.setPixelColor(4, pixels.Color(0,0,0));
    pixels.setPixelColor(5, pixels.Color(0,0,0));
    pixels.setPixelColor(6, pixels.Color(0,0,0));
    pixels.setPixelColor(7, pixels.Color(0,0,0));
    pixels.setPixelColor(8, pixels.Color(0,0,0));
    pixels.setPixelColor(9, pixels.Color(0,0,0));
    pixels.setPixelColor(10, pixels.Color(0,0,0));
    pixels.show();
  }
  
    
//zalévání a logování času zalévání na webu
if(humidityFromWeb > vlh_pudy && vlh_pudy > 20)
  {
  httpKlient.begin(http://greenlab.kaniok.com/php/watering_log.php);
    int kodHttp = httpKlient.GET();
    httpKlient.end();
    
  delay(500);
    analogWrite(D8, 800)  ;
    delay(3000);
    analogWrite(D8, 0)  ;
    delay(10000);
    
  }

}
