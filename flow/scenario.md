# Skenario Bob Personal Assistant API

## Overview
Bob adalah AI assistant personal untuk mencatat aktivitas sehari-hari di kostan. AI menggunakan Ollama di program terpisah, sedangkan repository ini khusus untuk API-nya.

---

## Fitur Utama

### 1. Tracking Rokok
- **Pembelian Rokok**: Mencatat pembelian pack rokok dengan merek dan harga
  - Contoh: "bob saya beli rokok ya" → beli 1 pack Sampoerna, harga Rp 38.000
- **Konsumsi Rokok**: Mencatat setiap batang rokok yang dihisap
  - Contoh: "bob saya ngerokok ya" → konsumsi 1 batang, tercatat dengan timestamp

### 2. Tracking Makanan & Minuman
- Mencatat pembelian makanan/minuman dengan biaya dan detail item
- Contoh: "bob saya beli makan dulu ya" → tercatat sebagai aktivitas beli makan dengan cost

### 3. Tracking Aktivitas & Lokasi
- Mencatat semua aktivitas sehari-hari:
  - Beli makan
  - Keluar nongkrong
  - Futsal
  - Tidur
  - Aktivitas lainnya
- **State Lokasi**: 
  - Saat "bob saya beli makan dulu ya" → status: di luar (outside)
  - Saat "bob saya pulang" → status: di dalam (inside)
  - State tetap "di luar" sampai ada perintah "saya pulang"

### 4. Tracking Transportasi
- **Isi Bahan Bakar**: Mencatat pengeluaran bahan bakar
  - Contoh: "bob saya tadi isi bahan bakar 50k" → tercatat di tabel transport
- **Service Kendaraan**: Mencatat service motor dengan detail item yang diganti
  - Contoh: "bob tadi service motor habis segini, ini ini in yang diganti" → tercatat dengan detail item

### 5. Tracking Bahan Dapur & Resep Masakan
- **Stok Bahan Dapur**: Mencatat stok bahan dapur yang tersedia
  - Contoh: "bob saya beli beras 5kg" → tercatat di tabel pantry_ingredients
  - Stok akan berkurang saat digunakan untuk memasak
  - Contoh: "bob saya pakai minyak 1 liter" → kurangi stok minyak
- **Resep Masakan**: Menyimpan resep masakan beserta bahan-bahan yang dibutuhkan
  - Setiap resep berisi daftar bahan dengan jumlah yang diperlukan
  - Resep bisa ditandai sebagai favorit
  - Mencatat kapan terakhir dimasak dan berapa kali sudah dimasak
- **Rekomendasi Masakan**: 
  - Query: "bob dengan stok kita sekarang, hari ini bagus nya masak apa ya"
  - Bob akan:
    1. Cek stok bahan dapur yang tersedia
    2. Cari resep yang bisa dibuat dengan stok yang ada (semua bahan tersedia)
    3. Rekomendasikan secara acak dari resep yang bisa dibuat

### 6. Tracking Schedule (Jadwal)
- **Schedule dari Microsoft Teams**: 
  - Terhubung langsung dengan Microsoft Teams
  - Schedule dari Teams akan di-sync secara otomatis ke database
  - Menyimpan detail meeting, waktu, lokasi, peserta, dan link meeting
- **Schedule Manual**: 
  - Schedule yang di-set sendiri oleh user
  - Contoh: "bob tgl 25 jam 19:00 hari senin saya mau minisoccer"
  - Tercatat dengan detail tanggal, waktu, jenis aktivitas, dan lokasi
- **Query Schedule via WhatsApp**:
  - Pertanyaan: "bob bos lu tgl 25 januari ada kegiatan apa ya atau free ga"
  - Bob akan:
    1. Cek schedule dari Microsoft Teams pada tanggal tersebut
    2. Cek schedule manual pada tanggal tersebut
    3. Gabungkan hasil dari kedua sumber
    4. Jika ada schedule → jawab detail kegiatan
    5. Jika tidak ada → jawab "free" atau "tidak ada kegiatan"

### 7. Daily Learning Questions (1% Lebih Baik)
- **Pertanyaan Software Engineering Harian**: 
  - Setiap hari akan diberikan pertanyaan baru untuk mengasah kemampuan software engineer
  - Pertanyaan tidak akan berulang dalam 1 bulan yang sama
  - Kategori: algorithm, data structure, design pattern, architecture, database, security, performance, testing, best practice
- **Query Pertanyaan Hari Ini**:
  - Pertanyaan: "bob pertanyaan hari ini"
  - Bob akan memberikan pertanyaan baru yang belum pernah diberikan dalam 30 hari terakhir
  - Setiap pertanyaan memiliki kategori, tingkat kesulitan, dan tags
- **Query Pencarian Topik**:
  - Pertanyaan: "bob kita pernah bahas tentang ini ga sih" (dengan topik tertentu)
  - Bob akan mencari di database pertanyaan yang pernah dibahas
  - Jika pernah: jawab "Pernah, tanggal [tanggal]. [Pertanyaan]. [Jawaban jika ada]"
  - Jika belum: jawab "Belum pernah bahas tentang [topik]"
- **Sharing Knowledge untuk Konten**:
  - Setiap pertanyaan yang sudah dibahas bisa digunakan untuk konten media sosial
  - Menyimpan jawaban dan referensi terkait untuk memudahkan pembuatan konten

### 8. Database Biografi
- Menyimpan informasi personal dan cerita keseharian
- Digunakan untuk menjawab pertanyaan via WhatsApp
- Contoh informasi:
  - Tempat lahir
  - Sekolah/kampus
  - Hobi dan preferensi
  - Cerita keseharian
- Konten akan di-inject langsung ke database dengan batasan tertentu

---

## Integrasi WhatsApp

### Fungsi Query via WhatsApp
- Pertanyaan: "bob bos lu dimana?"
- Bob akan menjawab berdasarkan log aktivitas terakhir:
  - Jika ada aktivitas aktif dengan status "di luar" → jawab sesuai aktivitas (beli makan, nongkrong, futsal, dll)
  - Jika status "di dalam" → jawab sesuai aktivitas terakhir (mungkin tidur atau di kost)

### Fungsi Query Biografi
- Pertanyaan tentang informasi personal akan dijawab dari tabel biography
- Contoh: "bob bos lu sekolah dimana?" → jawab dari data education di biography

### Fungsi Query Masakan
- Pertanyaan: "bob dengan stok kita sekarang, hari ini bagus nya masak apa ya"
- Bob akan mencari resep yang bisa dibuat berdasarkan stok bahan yang tersedia
- Rekomendasi diberikan secara acak dari resep yang memenuhi syarat

### Fungsi Query Schedule
- Pertanyaan: "bob bos lu tgl 25 januari ada kegiatan apa ya atau free ga"
- Bob akan cek schedule dari Microsoft Teams dan schedule manual
- Jawab detail kegiatan jika ada, atau "free" jika tidak ada kegiatan

### Fungsi Query Learning
- Pertanyaan: "bob pertanyaan hari ini"
- Bob akan memberikan pertanyaan software engineering baru yang belum pernah diberikan dalam 30 hari terakhir
- Pertanyaan: "bob kita pernah bahas tentang [topik] ga sih"
- Bob akan mencari di database berdasarkan keywords, tags, atau full-text search
- Jawab dengan detail tanggal dan isi pembahasan jika pernah, atau "belum pernah" jika tidak

---

## Struktur Database

- Setiap kategori aktivitas menggunakan tabel terpisah:
  - Tabel `cigarettes` untuk rokok
  - Tabel `foods` untuk makanan/minuman
  - Tabel `activities` untuk aktivitas dan lokasi
  - Tabel `transport` untuk transportasi
  - Tabel `pantry_ingredients` untuk stok bahan dapur
  - Tabel `recipes` untuk resep masakan
  - Tabel `teams_schedules` untuk schedule dari Microsoft Teams
  - Tabel `personal_schedules` untuk schedule manual
  - Tabel `daily_learning_questions` untuk pertanyaan 1% lebih baik setiap hari
  - Tabel `biography` untuk biografi

---

## Catatan Teknis

- Semua aktivitas tercatat dengan timestamp
- State lokasi ditrack melalui tabel activities
- Database biografi akan di-inject manual dengan konten yang sudah dibatasi
- Stok bahan dapur akan otomatis berkurang saat digunakan untuk memasak
- Rekomendasi masakan menggunakan matching antara stok bahan dan bahan yang dibutuhkan resep
- Schedule dari Microsoft Teams di-sync secara berkala melalui Microsoft Teams API
- Query schedule menggabungkan hasil dari teams_schedules dan personal_schedules
- Daily learning questions tidak akan berulang dalam 30 hari terakhir untuk variasi pembelajaran
- Pencarian topik menggunakan keywords, tags, dan full-text search untuk akurasi hasil
- API ini fokus pada data management, AI processing dilakukan di program terpisah dengan Ollama
