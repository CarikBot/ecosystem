### Struktur API

Jika Anda akan menghubungkan **ecosystem** dengan data atau layanan pihak ketiga, anda perlu membuat **API** _(Application Programming Interface)_ sebagai jembatan penghubungnya. API bisa bebas dibuat dengan bahasa atau teknologi apapun, yang penting menghasilkan **output** yang sesuai dengan format yang dibutuhkan oleh platform ini. Transmisi informasi dari **platform** dikirimkan dalam method **POST**.

Format standar output API yang diharapan:

```json
{
  "code": 0,
  "text": "Text yang akan ditampilkan"
}
```

Isi dari variabel `text` adalah konten yang akan dikirimkan kepada pengguna.


## Parameter yang dilewatkan ke API

Tentunya anda ingin mendapatkan informasi siapa yang mengirimkan pesan untuk tujuan personalisasi data. Nah, dari API yang anda kembangkan, anda bisa mendapatkan beberapa informasi dari parameter ini.

| Parameter | Deskripsi |
|---|---|
| UserID | User ID pengguna. |
| ChatID | Jika [chatbot](t.me/carikBot) digunakan di dalam group, ChatID ini berisi id dari group tersebut. |
| FullName | Nama pengguna. |
| OriginalText | Isi pesan asli yang dikirimkan oleh pengguna kepada [chatbot](t.me/carikBot) sebelum dilakukan pemetaan oleh NLP [Carik](t.me/carikBot).  |
| ChannelId | Channel aplikasi yang digunakan, yaitu: telegram, facebook, line, whatsapp, dan sebagainya. |


