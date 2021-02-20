# Carik Bot Microservices Ecosystem

**Carik Bot Microservices Ecosystem** adalah suatu sistem yang berisi kumpulan _microservice_ yang menjadi pendukung dari layanan _chatbot_ [Carik](https://carik.id).

Ilustrasi ini menggambarkan _service-service_ yang terhubung di dalam **Platform Carik Bot**, masing-masing terhubung dalam baik untuk mode _conversational_ maupun _menu-based_.
 
![Ecosystem](images/Carik-Bot-Microservices-Ecosystem.png)

Platform Carik Bot memberikan kesempatan kepada para developer untuk menghubungkan layanan-nya ke dalam ChatBot, khususnya untuk _menu-based chatbot_. Sangat mudah, bahkan nyaris **tanpa _coding_**. Cukup dengan membuat desain dan struktur _mind flow_-nya dengan aplikasi _mind mapper_, selanjutnya biarkan Carik yang bekerja.

Silakan berkontribusi di dalam repositori ini, di branch development, selanjutnya Carik akan segera melakukan distribusi secara otomatis setelah melalui approval.


## Alur Kerja

**Chatbot** yang menggunakan [Carik Engine](https://carik.id) dalam menjalankan sistemnya mempunyai alur seperti ilustrasi di bawah ini.

![Arsitektur](images/Carik-Integration.png)

//TODO: deskripsi

## Desain

Bagaimana cara mendesain **Mind Flow** dari ekosistem ini? Dan apa itu *Mind Flow*? **Mind Flow** di Carik adalah suatu alur interaksi antar pengguna dengan chatbot, khususnya dalam mode _menu-based_ .

Ada beberapa cara dalam membuat _Mind Flow_ ini:

1. Membuat data berformat .json
2. Menggambar desain melalui aplikasi _mind mapper_ seperti [XMind](https://www.xmind.net/) atau [Freemind](https://sourceforge.net/projects/freemind/).<br>Disarankan untuk menggunakan Freemind atau aplikasi yang bisa _export_ ke format Freemind.

Untuk informasi selengkapnya bisa pelajari panduan tentang [struktur file .json](#) dan [struktur file mindmapper](#) ini.

## API (Application Programming Interface)

Jika Anda akan menghubungkan **ecosystem** dengan data atau layanan pihak ketiga, ada perlu membuat **API** _(Application Programming Interface)_ sebagai jembatannya. API bisa bebas dibuat dengan bahasa atau teknologi apapun, yang penting menghasilkan _output_ yang sesuai dengan format yang dibutuhkan oleh platform ini.

Untuk informasi selengkapnya bisa pelajari panduan tentang [struktur API](#) di platform ini.

## Deployment

**Ecosystem Deployment** dilakukan secara otomatis oleh platform setelah melalui approval.


--

**Catatan:**
Sebagian kode sumber _microservice_ yang ada saat ini, dan yang berlisensi terbuka, akan mulai didistribusikan ke repositori ini.


