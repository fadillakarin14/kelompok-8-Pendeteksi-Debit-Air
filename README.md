# Smart Water Monitoring System berbasis ESP32

Sistem IoT untuk pemantauan volume dan tinggi air pada tangki secara real-time. Sistem ini menggunakan mikrokontroler ESP32 dan sensor ultrasonik untuk mendeteksi ketinggian air, kemudian mengirimkan datanya ke server web lokal agar dapat dipantau dengan mudah melalui berbagai perangkat.

## Fitur Utama

* **Real-time Dashboard:** Menampilkan informasi volume air (mL), tinggi air (cm), jarak sensor ke permukaan air (cm), serta status koneksi sensor secara langsung.
* **Indikator Status & Otomasi:** Menyediakan sistem peringatan berbasis warna untuk status air:
    * 🔴 **HAMPIR HABIS:** Tangki kosong / kritis.
    * 🟡 **SEDANG:** Kapasitas air dalam batas aman/menengah.
    * 🟢 **PENUH:** Air terisi penuh (kapasitas maksimum tangki diatur pada 565 mL).
* **Riwayat Data (Data Logging):** Menyimpan histori data pemantauan yang dilengkapi dengan fitur pencarian/filter serta ekspor data ke format **CSV** dan **PDF**.
* **Grafik Monitoring:** Visualisasi tren perubahan volume dan tinggi air secara interaktif yang diperbarui otomatis setiap 3 detik menggunakan Chart.js.
* **Responsive Design & Tema:** Antarmuka modern yang mendukung mode **Light** dan **Dark Mode** untuk kenyamanan pengguna.

## Komponen & Teknologi yang Digunakan

### Komponen Perangkat Keras (Hardware)
* **ESP32:** Mikrokontroler utama yang mengolah data dan mengendalikan konektivitas Wi-Fi.
* **Sensor Ultrasonik HC-SR04:** Mengukur jarak objek/permukaan air ke sensor.
* **Power Supply:** Sumber daya listrik utama untuk menyuplai ESP32.
* **Wi-Fi:** Koneksi jaringan lokal untuk mentransmisikan data ke server.

### Teknologi Perangkat Lunak (Software)
* **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript (Fetch API), Chart.js
* **Backend & Server:** PHP (Native / OOP), HTTP POST Request, Laragon/XAMPP (Web Server)
* **Database:** MySQL


## Cara Kerja Sistem

1.  **Pengukuran:** Sensor ultrasonik HC-SR04 yang terhubung pada ESP32 mengukur jarak dari sensor ke permukaan air di dalam tangki.
2.  **Pengiriman Data:** ESP32 memproses hasil pengukuran dan mengirimkan data tersebut ke server melalui protokol **HTTP POST**.
3.  **Penyimpanan:** Server PHP menerima request tersebut dan langsung menyimpannya ke dalam database **MySQL**.
4.  **Visualisasi:** Antarmuka web (Dashboard, Riwayat Data, Grafik) melakukan pembacaan dari database secara berkala untuk menampilkan kondisi air terkini kepada pengguna.

## Anggota Tim

* **Nama Anggota 1** Rizky Surya Diputra NPM 23552011390 — Hardware & ESP32
* **Nama Anggota 2**  Karina NurFadilla NPM 23552011012 — Backend PHP
* **Nama Anggota 3**  Liesna Nur'aeni Aprliani NPM 23552011394 — Frontend & UI
