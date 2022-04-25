### Struktur API

Jika Anda akan menghubungkan **ecosystem** dengan data atau layanan pihak ketiga, anda perlu membuat **API** _(Application Programming Interface)_ sebagai jembatan penghubungnya. API bisa bebas dibuat dengan bahasa atau teknologi apapun, yang penting menghasilkan **output** yang sesuai dengan format yang dibutuhkan oleh platform ini. Transmisi informasi dari **platform** dikirimkan dalam method **POST**.

Format standar output API yang diharapan:

```json
{
  "code": 0,
  "text": "Text yang akan ditampilkan"
}
```

Dengan ketentuan:

| variabel | Deskripsi |
|---|---|
| code | error code.<br>0: sukses |
| text | konten yang akan dikirimkan kepada pengguna. |


## Parameter yang dilewatkan ke API

Tentunya anda ingin mendapatkan informasi siapa yang mengirimkan pesan untuk tujuan personalisasi data. Nah, dari API yang anda kembangkan, anda bisa mendapatkan beberapa informasi dari parameter ini.

| Parameter | Deskripsi |
|---|---|
| UserID | User ID pengguna. |
| ChatID | Jika [chatbot](t.me/carikBot) digunakan di dalam group, ChatID ini berisi id dari group tersebut. |
| FullName | Nama pengguna. |
| OriginalText | Isi pesan asli yang dikirimkan oleh pengguna kepada [chatbot](t.me/carikBot) sebelum dilakukan pemetaan oleh NLP [Carik](t.me/carikBot).  |
| ChannelId | Channel aplikasi yang digunakan, yaitu: telegram, facebook, line, whatsapp, dan sebagainya. |


## Contoh: API Echo

Contoh source sederhana bisa anda lihat dari [**API ECHO**](../source/services/tools/echo), yang memiliki fungsi mengembalikan respon sesuai kata/kalimat yang diketikkan oleh user.

**MindFlow** dari fitur ini bisa anda dari dokumen [mindmap](../data/other/Ecosystem/).

![API Echo](../source/services/tools/echo/echo-menu.png)


Dari ilustrasi di atas ini akan terbaca: terdapat pilihan menu "Contoh". Dan jika pengguna menuliskan kalimat `echo apapun teksnya`, platform akan mengirimkan informasi dan [parameter](#parameter-yang-dilewatkan-ke-api) ini ke api di url `{ecosystem_baseurl}/services/tools/echo/`.

`{ecosystem_baseurl}` ini maksudnya adalah url dari platform ekosistem Carik ini, isi variabelnya akan generic sesuai load server saat itu. 

URL di atas hanya bersifat contoh saja. Jika anda memiliki api eksternal sendiri, silakan disesuaikan, misal: `https://api.yourdomain.tld/endpoint/path/path`.


## Action Response

[Carik Bot](https://carik.id) mempunyai fitur untuk bisa memberikan jawaban yang bersifat **rich content**, seperti bentuk menu, tombol, bahkan dalam bentuk form/essay.

Struktur API-nya merupakan pengembangan dari struktur api default di atas. Hanya perlu menambahkan beberapa tag informasi saja, khususnya menambahkan tag `type` dengan nilai `action`.

```json
{
  "code": 0,
  "text": "Kalimat yang akan ditampilkan ke pengguna.",
  "type": "action",
  "action": {
    "type": "[action_type]",
    "url": "webhook_hanya_untuk_action_form",
    "data": [
    ]
  }
}
```

Dan keterangan dari isi tag action adalah:

| Parameter | Deskripsi |
|---|---|
| type | Tipe action yang akan dibuat, pilihannya: menu, buttton, form |
| url | Jika tipe action-nya adalah form, url ini merupakan webhook yang akan diakses ketika isian form selesai dilakukan. |
| data | Isi data dari masing2 action, dengan struktur tertentu. |

### Menu

Salah satu yang paling sering digunakan dalam chatbot adalah adanya fitur menu. User diminta memilih salah satu menu yang tersedia.

### Tombol

Pada beberapa platform pesan instan memberikan kemudahan dalam mengakses pilihan pesan dalam bentuk tombol/button. Pengguna tidak perlu menuliskan angka-angka memu, tetapi cukup dengan memilih tombol yang tersedia. Anda tidak perlu risau bagimana jika platform yang anda gunakan tidak mendukung adanya tombol. Jangan khawatir, karena platform [Carik Ecosystem](https://carik.id) akan otomatis mengubahnya menjadi `menu` pilihan biasa.

## Form

//todo:

## Arsitektur

Sebagai gambaran bagaimana proses dan alur platform ekosistem ini bisa dilihat dari ilustrasi berikut ini.

![arsitektur](../images/Carik-Integration.png)

