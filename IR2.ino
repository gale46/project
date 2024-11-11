#include <Arduino.h>
#include "PinDefinitionsAndMore.h"  // Define macros for input and output pin etc.
#include <IRremote.hpp>
#define IR_RECEIVE_PIN 7
#define LED_REC 2
#define LED_SEN 8

unsigned long lastReceiveTime = 0;
unsigned long receiveTimeout = 3000;
bool receiveMode = false;
int numIRCodes;  //計算儲存成功個數
int count = 1;   //計算loop次數
//儲存型態
struct IRCode {
  uint16_t address;
  uint8_t command;
  uint8_t repeats;
};
IRCode irCodes[10];
void setup() {
  Serial.begin(9600);
  IrReceiver.begin(IR_RECEIVE_PIN, ENABLE_LED_FEEDBACK);
  IrSender.begin();           // 開始發送IR
  if (ENABLE_LED_FEEDBACK) {  //紅外線接收成功亮燈
    pinMode(LED_REC, OUTPUT);
  }
}


//接收IR
void receive_ir_data() {
  digitalWrite(LED_REC, HIGH);//開始接收亮燈
  //IR解碼
  if (IrReceiver.decode()) {
    char ir_data[10];
    sprintf(ir_data, "%d:%d", IrReceiver.decodedIRData.address, IrReceiver.decodedIRData.command); //透過serial port 傳回python
    Serial.println(ir_data);
    IrReceiver.resume();  // 清空buffer
    digitalWrite(LED_REC, LOW);//接收完畢暗燈
    receiveMode = false;
    
  }
}

void loop() {
  if (Serial.available()) {  //看是否有輸入
    String input = Serial.readString();  // 讀取string
    //如果接收到receive_ir_data
    if(input == "receive_ir_data"){
      //reciveMode為了讓arduino處在接收ir code的狀態下
      receiveMode = true;
      while(receiveMode){
        receive_ir_data();
      }
      Serial.println("complete");//透過serial port return "complete"後結束接收
      
    }else{
      size_t index = input.indexOf(":");//從database取出ir code
      uint16_t address = input.substring(0, index).toInt();
      uint8_t command = input.substring(index + 1).toInt();
      uint8_t repeats = 1;
      Serial.print(address, HEX);
      Serial.print(command,HEX);
      IrSender.sendNEC(address, command, repeats);//發射紅外線
      Serial.flush();
    }
  }
}


