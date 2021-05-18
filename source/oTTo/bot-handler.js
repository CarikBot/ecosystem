
function processMessage(Message, FromId, FromName){
  var result = ""
  if (Message.match(/ping|pung/img)) return "pong " + FromName
  if (Message.match(/halo|hai|pagi|siang|malam/img)) return "Halo juga"
  if (Message.match(/promo/img)) {
    result = "Promo Lebaran:"
    result += "\nDiscount 40% untuk semua pembelian di Toko Kami, untuk minimal pembelian Rp. 100.000."
    return result
  }

  // Your code here







  return result
}

function SendResponse(Messages, Code = 0){
  //----- response
  var outputAsArray = {
    "code": Code,
    "response": {
      "text": Messages
    }
  }
  var output = JSON.stringify(outputAsArray)
  return ContentService.createTextOutput(output).setMimeType(ContentService.MimeType.JSON)
}

function doPost(e){ 
  if (e == undefined){
    return ContentService.createTextOutput("{}")
  }
  postData = JSON.parse(e.postData.contents);

  var message = postData.message.text
  var fromId = postData.message.from.id
  var fromName = postData.message.from.name

  //var messageAsArray = message.toLowerCase().split(" ")
  //var commandToken = messageAsArray[0]     

  var replyAsArray = Array(processMessage(message, fromId, fromName))

  return SendResponse(replyAsArray);
}

function doGet(e){
  return ContentService.createTextOutput('{}')
}

/*
var reply = Array(processMessage("pUng", "id", "nama"))
var outputAsArray = {
  "code": 0,
  "text": reply
}
console.log(JSON.stringify(outputAsArray));
*/
