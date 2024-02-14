
# Webhook

Webhook merupakan sebuah cara di [Carik][https://carik.id] untuk memungkinkan aplikasi berkomunikasi secara real-time, memperbarui atau mengirim data secara otomatis antara satu sama lain tanpa perlu intervensi manusia. Dengan webhook, aplikasi Anda dapat langsung menerima pemberitahuan tentang peristiwa tertentu, seperti saat transaksi pembayaran berhasil, sebuah formulir online diisi, atau saat sebuah file diunggah ke server. Hal ini memungkinkan sistem untuk segera merespons peristiwa tersebut, misalnya dengan mengupdate database, mengirim email konfirmasi, atau memicu proses lainnya yang relevan. Ini menghemat waktu dan sumber daya yang sebelumnya mungkin dihabiskan untuk polling atau pengecekan manual terhadap perubahan data.

Dengan webhook, developer dapat dengan mudah menghubungkan aplikasi mereka dengan layanan [Carik](https://carik.id) tanpa harus mengembangkan antarmuka khusus untuk setiap layanan. Ini memungkinkan pembuatan ekosistem aplikasi yang saling terhubung, di mana data dapat mengalir secara lancar antar platform tanpa perlu pengembangan integrasi yang kompleks dan memakan waktu. Dalam dunia bisnis yang dinamis, kemampuan untuk dengan cepat mengintegrasikan dan otomatisasi alur kerja merupakan keunggulan kompetitif. Webhook, dengan kemampuannya untuk memfasilitasi komunikasi _real-time_ antara aplikasi, memainkan peran penting dalam menciptakan proses bisnis yang lebih efisien dan responsif terhadap kebutuhan pasar.


## Webhook Format


```json
{
  "event": "[event source]",
  "data": {

  }
}
```

| Note | Description |
|---|---|
| event | The source that causes this event:<br>`device/message/module/payment/etc` |
| data | varied meta data |


### Payload Example

Berikut adalah beberapa contoh payload yang dikirimkan ketika suatu event terjadi. Isi data payload bervariasi tergantung pada jenis kejadiannya.

Message event:

```json
{
  "event": "message",
  "platform": "whatsapp",
  "data": {
    "queue_id": "1234567890",
    "message_id": "abcdefghijklmnopqrstuvwxyz1234567890",
    "phone": "621234567890",
    "status": "read"
  }
}
```

Device event:

```json
{
  "event": "device",
  "data": {
    "device_id": "ABCDEF",
    "status": "disconnected"
  }
}
```

Payment event:

```json
{
  "event": "payment",
  "vendor_id": "[vendor_id]",
  "channel_id": "[channel_id]",
  "data": {
    "transaction_id": "ABCDEF",
    .
    .
    .
  }
}
```

