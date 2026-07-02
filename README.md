# Secure Access Log System berbasis ESP32 & Web Monitoring

Proyek ini adalah sistem IoT terintegrasi yang dirancang untuk memantau, mencatat, dan mengamankan log aktivitas perangkat secara real-time. Sistem menggunakan mikrokontroler ESP32 sebagai *end-device* untuk mengirimkan data log status melalui protokol jaringan aman ke server backend berbasis PHP dan database MySQL.


## 📝 Deskripsi Proyek

Sistem **Secure Access Log** ini memecahkan masalah pemantauan aset dan validasi aktivitas perangkat jarak jauh. Dengan memanfaatkan ESP32, setiap perubahan status sensor terkirim secara instan melalui HTTP POST Request. Di sisi server, data divalidasi, dikategorikan berdasarkan tingkat urgensi status (HAMPIR HABIS, SEDANG, PENUH), dan diarsipkan ke dalam sistem manajemen database (DBMS) yang aman dari manipulasi lokal.

---

## ✨ Fitur Sistem

* **Real-Time Log Dashboard:** Menampilkan metrik volume (mL), jarak (cm), tinggi objek (cm), serta indikator detak jantung koneksi (*Status Sensor: Online*).
* **Automated Status Grading:** Log diklasifikasikan secara otomatis menggunakan sistem sensorik ke dalam 3 tingkatan status visual (Kritis/Merah, Normal/Kuning, Aman/Hijau).
* **Secure Data Logging (Riwayat Data):** Halaman komprehensif yang menampilkan seluruh data masuk lengkap dengan stempel waktu (*timestamp*) presisi hingga satuan detik serta fitur ekspor data ke format **CSV** dan **PDF**.
* **Dynamic Analytics Graph:** Visualisasi data menggunakan *line chart* interaktif yang diperbarui secara otomatis setiap 3 detik menggunakan Chart.js.
* **Dual Theme Interface:** Desain antarmuka adaptif yang mendukung *Light Mode* dan *Dark Mode*.

---

## 🛠️ Spesifikasi Komponen & Modul Fisik

Berdasarkan arsitektur perangkat pada gambar `image_c5fb9e.jpg`, berikut adalah komponen yang digunakan:

1. **ESP32 D1 R32 Uno Form Factor:** Mikrokontroler utama berbasis ESP32 dengan layout pin fisik menyerupai Arduino Uno. Memiliki modul Wi-Fi internal untuk mentransmisikan data log ke server.
2. **Sensor Ultrasonik HC-SR04:** Sensor pembaca jarak permukaan air menggunakan pantulan gelombang ultrasonik.
3. **Breadboard (Papan Prototipe):** Digunakan untuk merakit dan meletakkan komponen pendukung sirkuit tanpa perlu disolder.
4. **Resistor (Pembalas Tegangan/Logic Level Converter):** Digunakan sebagai pembagi tegangan (*voltage divider*) pada pin Echo HC-SR04 ke pin GPIO ESP32 untuk menurunkan logika 5V menjadi aman bagi level tegangan input ESP32 (3.3V).
5. **Kabel Jumper (Male-to-Male & Male-to-Female):** Kabel interkoneksi jalur data dan daya antar modul.
6. **Kabel USB Data:** Penghubung daya dan media pemrograman dari PC/Laptop ke ESP32 D1 R32.

---

## 🔌 Skema Wiring & Demonstrasi Alat

### Alur Sambungan Pin (Wiring Diagram)
* **HC-SR04 VCC** ──> ESP32 **5V**
* **HC-SR04 Trig** ──> ESP32 **GPIO Digital Pin**
* **HC-SR04 Echo** ──> melalui Rangkaian Pembagi Resistor ──> ESP32 **GPIO Digital Pin** (Aman pada level 3.3V)
* **HC-SR04 GND** ──> ESP32 **GND**

### Foto Implementasi Alat (Hardware Setup)
<img width="530" height="720" alt="image" src="https://github.com/user-attachments/assets/9dcf8915-aa1d-41a9-9aca-58bd3162813b" />

### Hasil wiring alat-alat

https://github.com/user-attachments/assets/6b937233-c0dc-4f69-9d4a-7419e6d94d2a

---

## 📺 Demonstrasi Sistem Web Monitoring

Pengujian sistem monitoring dilakukan secara lokal melalui antarmuka web yang terintegrasi penuh dengan database server:

### 1. Halaman Utama / Dashboard Real-Time
Dashboard menampilkan visualisasi widget status air, volume tanki, dan deteksi jarak sensor secara langsung dari pembacaan alat hardware.

### 2. Log Riwayat Data & Fitur Ekspor Dokumen
Halaman riwayat data merekam jejak aktivitas parameter air lengkap dengan stempel waktu harian. Tersedia tombol aksi untuk melakukan ekspor data secara instan menjadi berkas laporan `.csv` ataupun berkas `.pdf`.

### 3. Grafik Analitik Dinamis
Menu grafik menyajikan visualisasi fluktuasi garis gelombang volume dan tinggi air yang diperbarui (*refresh otomatis*) secara berkala setiap 3 detik mengikuti pergerakan air di tangki fisik.

https://github.com/user-attachments/assets/f3e48690-aff9-429d-9402-362a2379f68b

---

## 🗃️ Struktur Database

Sistem ini merekam data log ke dalam database dengan struktur kolom utama sebagai berikut:

| Nama Kolom | Tipe Data | Deskripsi |
| :--- | :--- | :--- |
| `id` / `no` | INT (Auto Increment) | Primary Key untuk identitas unik setiap baris log. |
| `waktu` | TIMESTAMP | Tanggal dan jam presisi saat data diterima server. |
| `volume` | INT | Volume air yang terhitung dalam satuan mL. |
| `tinggi` | FLOAT | Kedinggian air dari dasar tangki (cm). |
| `jarak` | FLOAT | Jarak permukaan air ke posisi sensor (cm). |
| `status` | VARCHAR | Klasifikasi kondisi (HAMPIR HABIS, SEDANG, PENUH). |

---

## Anggota Tim

* **Nama Anggota 1** Rizky Surya Diputra NPM 23552011390
* **Nama Anggota 2**  Karina NurFadilla NPM 23552011012
* **Nama Anggota 3**  Liesna Nur'aeni Aprliani NPM 23552011394
