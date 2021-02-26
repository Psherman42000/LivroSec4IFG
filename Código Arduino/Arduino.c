// bibliotecas
#include "Arduino.h"
#include "ESP8266.h"
#include "RFID.h"
#include "PiezoSpeaker.h"
#include "ESP8266WiFi.h"          
#include "MySQL_Connection.h"
#include "MySQL_Cursor.h"
#include <Ethernet.h>
#include <SPI.h>

// definições de pinos
#define WIFI_PIN_TX	3
#define WIFI_PIN_RX	10
#define RFID_PIN_RST	2
#define RFID_PIN_SDA	4
#define THINSPEAKER_PIN_POS	5

// ====================================================================
// ---------------------------DADOS DE LOGIN---------------------------
IPAddress server_addr(46, 252, 181, 108); // O IP DO SERVIDOR DA CLEVER CLOUD
int porta = 3306;
char user[] = "ui8uwuxvmzk1vdfa"; // Usuario banco de dados
char password[] = "TX5MB6aD4zGy2hldfaAd"; //   Senha banco de dados
const char wf[]  = ""; // nome do wifi
const char senha[] = "" ; // senha do wifi
char INSERE_TAG[] = "INSERT INTO bmawg2lmbs58mxjxnxgd.tagsLidas(tag) VALUES ('%s');"; //query de envio da tag
char ATUALIZA_STATUS[] = " UPDATE solicitacao SET ler = 0 WHERE id = 1;"; //query de reset da solicitação de leitura
char VERIFICA_STATUS[] = " SELECT ler FROM solicitacao WHERE id = 1;"; //query de verificação da solicitação de leitura
char VERIFICA_STATUS_LIVRO[] = " SELECT alugado FROM livro WHERE tag = '%s';"; //query de verificação do aluguel do livro
// =====================================================================

char* const host = "bmawg2lmbs58mxjxnxgd-mysql.services.clever-cloud.com";
unsigned int thinSpeakerHoorayLength          = 6;                                                      // quantidade de notas na melodia 
unsigned int thinSpeakerHoorayMelody[]        = {NOTE_C4, NOTE_E4, NOTE_G4, NOTE_C5, NOTE_G4, NOTE_C5}; // lista de notas
unsigned int thinSpeakerHoorayNoteDurations[] = {8      , 8      , 8      , 4      , 8      , 4      }; // duração das notas

// inicializando os objetos
ESP8266 wifi(WIFI_PIN_RX,WIFI_PIN_TX);
RFID rfid(RFID_PIN_SDA,RFID_PIN_RST);
PiezoSpeaker thinSpeaker(THINSPEAKER_PIN_POS);
WiFiClient client;             
MySQL_Connection conn(&client);
MySQL_Cursor* cursor;

void TocaAlarme(){
    // tocara a melodia da musica Hooray de Boney M.
    thinSpeaker.playMelody(thinSpeakerHoorayLength, thinSpeakerHoorayMelody, thinSpeakerHoorayNoteDurations); 
    delay(500);   
}

void VerificaWiFi() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("Sem conexão"); 
    WiFi.disconnect();
    delay(1000);
    WiFi.begin(ef, senha);
    Serial.println();Serial.println("Conectando ao WiFi."); 
    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
    }
    serial.println();Serial.println("Conectado a rede!"); 
  }
}

void LerTag(){
    char query[128];
    char rfidtag[] = rfid.readTag();
    delay(2000);
    if (conn.connect(server_addr, 3306, user, password)) {
        delay(1000);
        MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
        sprintf(query, INSERE_TAG, rfidtag);
        cur_mem->execute(query);
        delete cur_mem;
        delay(1000);
        MySQL_Cursor *cur_mem2 = new MySQL_Cursor(&conn);
        cur_mem2->execute(ATUALIZA_STATUS);
        delete cur_mem2;
        Serial.println(); Serial.println("DADOS GRAVADOS"); 
    }
    else
        Serial.println(); Serial.println("FALHA NA CONEXÃO"); 
    conn.close();
}



void VerificaSolicitacao(){// verifica se há solicitação de leitura no banco de dados
    VerificaWiFi();
    if (conn.connect(server_addr, 3306, user, password)) {
        delay(1000);
        row_values * row = null;
        MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
        cur_mem->execute(VERIFICA_STATUS);
        delay(1500);
        row = cur_mem->get_next_row();
        int solicita = atol( row->values[0] );
        delete cur_mem;
        if(solicita == 1){
            LerTag();
        }
    }
    else
        Serial.println(); Serial.println("FALHA NA CONEXÃO"); //
    conn.close();
    delay(500);
}

void VerificaSituacao(){// verifica se os livros que passam por ele estão alugados
    char query[128];
    char rfidtag[] = rfid.readTag();
    VerificaWiFi();
    if (conn.connect(server_addr, 3306, user, password)) {
        delay(1000);
        row_values * row = null;
        MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
        sprintf(query, VERIFICA_STATUS_LIVRO, rfidtag);
        cur_mem->execute(query);
        delay(1500);
        row = cur_mem->get_next_row();
        int alugado = atol( row->values[0] );
        if(alugado != 1){
            TocaAlarme();
        }
        delete cur_mem;
    }
    else{
        Serial.println(); Serial.println("FALHA NA CONEXÃO"); //
    }
    conn.close();
    delay(500);
}

void setup() {
    Serial.begin(9600);
    while (!Serial) ;
    Serial.println("iniciar");
    wifi.init(wf, senha);
    rfid.init();
    
}

void loop() {
    VerificaSolicitacao();
    VerificaSituacao();
}