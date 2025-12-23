<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# 📊 Catatan Penjualan – Laravel

Aplikasi **Catatan Penjualan** berbasis **Laravel** untuk mencatat transaksi penjualan **multi-item**, pembayaran bertahap (**cicilan**), serta **dashboard ringkasan penjualan**.

Project ini dibuat sebagai **tes kemampuan backend**, dengan fokus pada:

-   Logika bisnis
-   Relasi database
-   Konsistensi dan validasi data

---

## 🚀 Fitur Utama

### 🧾 Penjualan

-   Tambah penjualan dengan **multi item**
-   Qty, harga, subtotal, dan total dihitung otomatis
-   Edit penjualan (**selama belum lunas**)
-   Detail penjualan (item & riwayat pembayaran)
-   Status otomatis:
    -   `BELUM_DIBAYAR`
    -   `BELUM_DIBAYAR_SEPENUHNYA`
    -   `SUDAH_DIBAYAR`

---

### 💰 Pembayaran

-   Pembayaran bertahap (cicilan)
-   Validasi **pembayaran tidak boleh melebihi total penjualan**
-   Edit pembayaran dengan update status otomatis
-   Detail pembayaran

---

### 📈 Dashboard

-   Jumlah transaksi
-   Total penjualan
-   Total qty
-   Filter berdasarkan tanggal
-   Chart ringkasan penjualan

---

## 🛠️ Teknologi yang Digunakan

-   **Laravel**
-   **MySQL**
-   **Bootstrap 5**
-   **JavaScript (Vanilla)**
-   **Chart.js**

---

## 🗂️ Struktur Database (Ringkas)

### Tabel

-   `items`
-   `sales`
-   `sale_items`
-   `payments`

### Relasi Utama

-   `Sale` hasMany `SaleItem`
-   `Sale` hasMany `Payment`
-   `SaleItem` belongsTo `Item`

---

## 🧪 Alur Pengujian Aplikasi

### 1️⃣ Dashboard

-   Cek ringkasan (awal data masih 0)

### 2️⃣ Penjualan

-   Menu **Penjualan** → **Tambah Penjualan**
-   Pilih item, ubah qty, tambah item
-   Simpan penjualan

### 3️⃣ Pembayaran

-   Menu **Pembayaran** → **Tambah Pembayaran**
-   Lakukan pembayaran sebagian → status berubah
-   Lakukan pembayaran penuh → status menjadi `SUDAH_DIBAYAR`

### 4️⃣ Validasi

-   Pembayaran melebihi total → **ditolak**
-   Penjualan yang sudah lunas → **tidak bisa diedit / dihapus**

---

## 📌 Catatan

-   Fokus utama project ini adalah **logika backend dan konsistensi data**
-   Tidak menggunakan autentikasi user
-   UI dibuat sederhana menggunakan **Bootstrap**

---

## 👨‍💻 Author

**David Gholi Rahmadana**  
Backend Developer – Laravel
