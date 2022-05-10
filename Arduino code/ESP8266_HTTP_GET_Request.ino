#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>

#include <ESP8266WiFiMulti.h>
ESP8266WiFiMulti WiFiMulti;

#include <WiFiUdp.h>

#include <WakeOnLan.h>

WiFiUDP UDP;
WakeOnLan WOL(UDP);

const char *ssid = "WIFI name";
const char *password = "password";

// Your IP address or domain name with URL path
const char *serverName = "http://site/esp-outputs-action.php?action=outputs_state&id=0";    // don't work on https 

// Update interval time set to 5 seconds
const long interval = 60000;
unsigned long previousMillis = 0;

String outputsState;

void wakeMyPC(const char *macAddress)
{
    // EXAMPLE MAC address:  "00-00-00-D0-00-DD";
    WOL.sendMagicPacket(macAddress); // Send Wake On Lan packet with the above MAC address. Default to port 9.
    // WOL.sendMagicPacket(MACAddress, 7); // Change the port number
}

void setup()
{
    Serial.begin(115200);

    pinMode(LED_BUILTIN, OUTPUT);
    digitalWrite(LED_BUILTIN, HIGH);

    WOL.setRepeat(3, 100); // Optional, repeat the packet three times with 100ms between. WARNING delay() is used between send packet function.

    WiFi.mode(WIFI_STA);
    Serial.print("Connecting to ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print(".");
    }
    Serial.println("Connected to WiFi");

    WOL.calculateBroadcastAddress(WiFi.localIP(), WiFi.subnetMask()); // Optional  => To calculate the broadcast address, otherwise 255.255.255.255 is used (which is denied in some networks).
}

void loop()
{

    delay(10000);

    unsigned long currentMillis = millis();

    if (currentMillis - previousMillis >= interval)
    {
        // Check WiFi connection status
        if ((WiFiMulti.run() == WL_CONNECTED))
        {
            outputsState = httpGETRequest(serverName);
            Serial.println(outputsState);
            JSONVar myObject = JSON.parse(outputsState);

            // JSON.typeof(jsonVar) can be used to get the type of the var
            if (JSON.typeof(myObject) == "undefined")
            {
                Serial.println("Parsing input failed!");
                return;
            }

            Serial.print("JSON object = ");
            Serial.println(myObject);

            // myObject.keys() can be used to get an array of all the keys in the object
            JSONVar keys = myObject.keys();

            for (int i = 0; i < keys.length(); i++)
            {
                JSONVar value = myObject[keys[i]];
                Serial.print("MAC: ");
                Serial.print(keys[i]);
                Serial.print(" - SET to: ");
                Serial.println(value);
                if (atoi(value))
                {
                    Serial.print("Power on the pc :  ");
                    Serial.print(keys[i]);
                    const char *string = keys[i];
                    wakeMyPC(string);
                }
            }
            previousMillis = currentMillis;
        }
        else
        {
            Serial.println("WiFi Disconnected");
        }
    }
}

String httpGETRequest(const char *serverName)
{
    WiFiClient client;
    HTTPClient http;

    // Your IP address with path or Domain name with URL path
    http.begin(client, serverName);
    // Send HTTP POST request
    int httpResponseCode = http.GET();

    String payload = "{}";

    if (httpResponseCode > 0)
    {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        payload = http.getString();
    }
    else
    {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();

    return payload;
}
