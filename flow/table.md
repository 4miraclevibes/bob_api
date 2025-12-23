# Analisis Struktur Database - Bob Personal Assistant API

## Overview
Database untuk mencatat aktivitas sehari-hari dan data personal yang akan digunakan oleh AI assistant Bob untuk menjawab pertanyaan via WhatsApp.

---

## 1. Tabel: cigarettes (Rokok)

### Deskripsi
Mencatat pembelian pack rokok dan konsumsi batang rokok.

### Field:
- `id` (bigint, primary key, auto increment)
- `type` (enum: 'purchase', 'consume') - jenis transaksi: beli atau konsumsi
- `brand` (string, nullable) - merek rokok (contoh: Sampoerna)
- `quantity` (integer) - jumlah pack (untuk purchase) atau jumlah batang (untuk consume)
- `price` (decimal, nullable) - harga per pack (untuk purchase)
- `total_price` (decimal, nullable) - total harga pembelian
- `notes` (text, nullable) - catatan tambahan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- Purchase: "bob saya beli rokok ya" → type='purchase', brand='Sampoerna', quantity=1, price=38000
- Consume: "bob saya ngerokok ya" → type='consume', quantity=1

---

## 2. Tabel: foods (Makanan & Minuman)

### Deskripsi
Mencatat pembelian makanan dan minuman beserta biaya dan detail item.

### Field:
- `id` (bigint, primary key, auto increment)
- `category` (enum: 'food', 'drink', 'snack') - kategori item
- `item_name` (string) - nama makanan/minuman yang dibeli
- `cost` (decimal) - biaya pembelian
- `quantity` (integer, default: 1) - jumlah item
- `location` (string, nullable) - lokasi pembelian (contoh: warung, restoran)
- `notes` (text, nullable) - catatan tambahan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- "bob saya beli makan dulu ya" → category='food', cost=25000, item_name='Nasi Goreng'

---

## 3. Tabel: activities (Aktivitas)

### Deskripsi
Mencatat log aktivitas sehari-hari dengan tracking lokasi (di luar/di dalam kost).

### Field:
- `id` (bigint, primary key, auto increment)
- `activity_type` (enum: 'beli_makan', 'nongkrong', 'futsal', 'tidur', 'lainnya') - jenis aktivitas
- `description` (text, nullable) - deskripsi aktivitas
- `location_status` (enum: 'outside', 'inside') - status lokasi: di luar atau di dalam kost
- `started_at` (timestamp) - waktu mulai aktivitas
- `ended_at` (timestamp, nullable) - waktu selesai aktivitas (diisi saat "saya pulang")
- `is_active` (boolean, default: true) - status aktivitas masih berlangsung atau tidak
- `notes` (text, nullable) - catatan tambahan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Logika:
- Saat "bob saya beli makan dulu ya" → activity_type='beli_makan', location_status='outside', is_active=true
- Saat "bob saya pulang" → update aktivitas terakhir dengan location_status='inside', is_active=false, ended_at=now()

---

## 4. Tabel: transport (Transportasi)

### Deskripsi
Mencatat pengeluaran transportasi seperti isi bahan bakar dan service kendaraan.

### Field:
- `id` (bigint, primary key, auto increment)
- `type` (enum: 'fuel', 'service', 'maintenance', 'lainnya') - jenis transaksi transport
- `vehicle_type` (string, nullable) - jenis kendaraan (contoh: motor, mobil)
- `amount` (decimal) - jumlah biaya
- `description` (text, nullable) - deskripsi detail
  - Untuk fuel: jumlah liter atau nominal
  - Untuk service: item yang diganti/diperbaiki
- `service_items` (json, nullable) - detail item service (untuk type='service')
  - Format: [{"item": "oli", "price": 50000}, {"item": "ban", "price": 200000}]
- `notes` (text, nullable) - catatan tambahan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- Fuel: "bob saya tadi isi bahan bakar 50k" → type='fuel', amount=50000
- Service: "bob tadi service motor habis segini, ini ini in yang diganti" → type='service', description='service motor', service_items=[...]

---

## 5. Tabel: biography (Biografi)

### Deskripsi
Menyimpan data personal dan cerita keseharian untuk menjawab pertanyaan via WhatsApp.

### Field:
- `id` (bigint, primary key, auto increment)
- `category` (enum: 'personal_info', 'education', 'daily_story', 'preference', 'lainnya') - kategori informasi
- `title` (string) - judul informasi
- `content` (text) - isi informasi/biografi
- `tags` (json, nullable) - tag untuk pencarian (contoh: ["lahir", "sekolah", "kampus"])
- `is_public` (boolean, default: true) - apakah informasi ini boleh dijawab ke WhatsApp
- `priority` (integer, default: 0) - prioritas informasi (untuk sorting)
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- Personal: category='personal_info', title='Tempat Lahir', content='Jakarta'
- Education: category='education', title='Kampus', content='Universitas X'
- Daily Story: category='daily_story', title='Hobi', content='Futsal dan nongkrong'

---

## 6. Tabel: location_states (State Lokasi)

### Deskripsi
Mencatat state lokasi saat ini untuk tracking posisi (opsional, bisa juga pakai activities terakhir).

### Field:
- `id` (bigint, primary key, auto increment)
- `status` (enum: 'inside', 'outside') - status lokasi saat ini
- `last_activity` (string, nullable) - aktivitas terakhir yang dilakukan
- `current_location` (string, nullable) - lokasi saat ini (jika di luar)
- `updated_at` (timestamp)

### Catatan:
- Tabel ini bisa digunakan untuk quick lookup status lokasi saat ini
- Atau bisa diambil dari activities terakhir dengan is_active=true

---

## 7. Tabel: pantry_ingredients (Stok Bahan Dapur)

### Deskripsi
Mencatat stok bahan dapur yang tersedia untuk memasak. Stok akan berkurang saat digunakan untuk memasak.

### Field:
- `id` (bigint, primary key, auto increment)
- `ingredient_name` (string) - nama bahan dapur (contoh: beras, minyak, garam, bawang merah)
- `category` (enum: 'grain', 'spice', 'vegetable', 'meat', 'dairy', 'oil', 'sauce', 'lainnya') - kategori bahan
- `unit` (string) - satuan (contoh: kg, gram, liter, pcs, bungkus)
- `quantity` (decimal) - jumlah stok yang tersedia
- `min_quantity` (decimal, nullable) - jumlah minimum untuk alert stok habis
- `expiry_date` (date, nullable) - tanggal kadaluarsa (jika ada)
- `purchase_date` (date, nullable) - tanggal pembelian terakhir
- `purchase_price` (decimal, nullable) - harga pembelian terakhir
- `notes` (text, nullable) - catatan tambahan
- `is_active` (boolean, default: true) - apakah bahan masih aktif digunakan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- "bob saya beli beras 5kg" → ingredient_name='beras', category='grain', unit='kg', quantity=5
- "bob saya pakai minyak 1 liter" → update quantity minyak dikurangi 1 liter

### Logika:
- Saat membeli bahan → tambah atau update quantity
- Saat memasak → kurangi quantity sesuai yang digunakan
- Query stok saat ini → ambil semua dengan quantity > 0 dan is_active=true

---

## 8. Tabel: recipes (Resep Masakan)

### Deskripsi
Menyimpan resep masakan beserta bahan-bahan yang dibutuhkan. Digunakan untuk rekomendasi masakan berdasarkan stok yang ada.

### Field:
- `id` (bigint, primary key, auto increment)
- `recipe_name` (string) - nama masakan (contoh: Nasi Goreng, Mie Goreng, Capcay)
- `category` (enum: 'rice', 'noodle', 'soup', 'fried', 'boiled', 'lainnya') - kategori masakan
- `difficulty` (enum: 'easy', 'medium', 'hard') - tingkat kesulitan
- `cooking_time` (integer, nullable) - waktu memasak dalam menit
- `servings` (integer, nullable) - jumlah porsi
- `ingredients` (json) - daftar bahan yang dibutuhkan
  - Format: [{"ingredient_name": "beras", "quantity": 0.5, "unit": "kg"}, {"ingredient_name": "minyak", "quantity": 0.1, "unit": "liter"}]
- `instructions` (text, nullable) - langkah-langkah memasak
- `tags` (json, nullable) - tag untuk pencarian (contoh: ["cepat", "mudah", "favorit"])
- `is_favorite` (boolean, default: false) - apakah resep favorit
- `last_cooked_at` (timestamp, nullable) - terakhir kali dimasak
- `cook_count` (integer, default: 0) - jumlah kali dimasak
- `notes` (text, nullable) - catatan tambahan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- recipe_name='Nasi Goreng', ingredients=[{"ingredient_name": "beras", "quantity": 0.3, "unit": "kg"}, {"ingredient_name": "minyak", "quantity": 0.05, "unit": "liter"}, {"ingredient_name": "bawang merah", "quantity": 3, "unit": "pcs"}]

### Logika Rekomendasi:
- Query: "bob dengan stok kita sekarang, hari ini bagus nya masak apa ya"
  1. Ambil semua stok aktif dari pantry_ingredients (quantity > 0)
  2. Ambil semua resep dari recipes
  3. Untuk setiap resep, cek apakah semua bahan di ingredients tersedia di stok dengan quantity cukup
  4. Filter resep yang bisa dibuat (semua bahan tersedia)
  5. Pilih secara acak dari resep yang bisa dibuat
  6. Return rekomendasi masakan

---

## 9. Tabel: teams_schedules (Schedule dari Microsoft Teams)

### Deskripsi
Menyimpan schedule yang di-sync dari Microsoft Teams. Tabel ini akan di-update secara otomatis melalui integrasi dengan Microsoft Teams API.

### Field:
- `id` (bigint, primary key, auto increment)
- `teams_event_id` (string, unique) - ID event dari Microsoft Teams
- `title` (string) - judul/jenis kegiatan dari Teams
- `description` (text, nullable) - deskripsi kegiatan
- `start_time` (datetime) - waktu mulai kegiatan
- `end_time` (datetime) - waktu selesai kegiatan
- `location` (string, nullable) - lokasi kegiatan (jika ada di Teams)
- `attendees` (json, nullable) - daftar peserta (jika ada)
  - Format: [{"name": "John Doe", "email": "john@example.com"}]
- `meeting_link` (string, nullable) - link meeting Teams (jika ada)
- `is_all_day` (boolean, default: false) - apakah kegiatan seharian penuh
- `recurrence` (json, nullable) - informasi recurring event (jika ada)
- `status` (enum: 'confirmed', 'tentative', 'cancelled') - status event
- `last_synced_at` (timestamp) - waktu terakhir di-sync dari Teams
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Catatan:
- Data akan di-sync secara berkala dari Microsoft Teams API
- Jika event dihapus di Teams, bisa di-mark sebagai cancelled atau dihapus
- teams_event_id digunakan untuk tracking perubahan event di Teams

---

## 10. Tabel: personal_schedules (Schedule Manual)

### Deskripsi
Menyimpan schedule yang di-set manual oleh user melalui perintah suara/chat.

### Field:
- `id` (bigint, primary key, auto increment)
- `title` (string) - judul/jenis kegiatan
- `description` (text, nullable) - deskripsi kegiatan
- `schedule_date` (date) - tanggal kegiatan
- `start_time` (time, nullable) - waktu mulai (nullable jika all_day)
- `end_time` (time, nullable) - waktu selesai (nullable jika all_day)
- `location` (string, nullable) - lokasi kegiatan
- `activity_type` (enum: 'minisoccer', 'futsal', 'nongkrong', 'belanja', 'lainnya') - jenis aktivitas
- `is_all_day` (boolean, default: false) - apakah kegiatan seharian penuh
- `reminder_before` (integer, nullable) - reminder berapa menit sebelum kegiatan (nullable jika tidak ada reminder)
- `status` (enum: 'scheduled', 'completed', 'cancelled') - status kegiatan
- `notes` (text, nullable) - catatan tambahan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- "bob tgl 25 jam 19:00 hari senin saya mau minisoccer"
  → schedule_date='2024-01-25', start_time='19:00', activity_type='minisoccer', title='Minisoccer'

### Logika Query:
- Query: "bob bos lu tgl 25 januari ada kegiatan apa ya atau free ga"
  1. Cek di teams_schedules: cari event pada tanggal tersebut
  2. Cek di personal_schedules: cari schedule pada tanggal tersebut
  3. Gabungkan hasil dari kedua tabel
  4. Jika ada schedule → jawab detail kegiatan
  5. Jika tidak ada → jawab "free" atau "tidak ada kegiatan"

---

## 11. Tabel: daily_learning_questions (Pertanyaan 1% Lebih Baik)

### Deskripsi
Menyimpan pertanyaan software engineering untuk pembelajaran harian "1% lebih baik". Setiap hari akan diberikan pertanyaan baru yang tidak berulang dalam 1 bulan yang sama. Digunakan untuk mengasah kemampuan dan sharing knowledge untuk konten media sosial.

### Field:
- `id` (bigint, primary key, auto increment)
- `question` (text) - pertanyaan software engineering
- `answer` (text, nullable) - jawaban/discussion tentang pertanyaan tersebut
- `category` (enum: 'algorithm', 'data_structure', 'design_pattern', 'architecture', 'database', 'security', 'performance', 'testing', 'best_practice', 'lainnya') - kategori pertanyaan
- `difficulty` (enum: 'beginner', 'intermediate', 'advanced') - tingkat kesulitan
- `tags` (json) - tag untuk pencarian (contoh: ["javascript", "async", "promise", "performance"])
  - Format: ["tag1", "tag2", "tag3"]
- `keywords` (json, nullable) - kata kunci untuk pencarian topik (contoh: ["async", "promise", "callback"])
  - Digunakan untuk query "bob kita pernah bahas tentang ini ga sih"
- `given_date` (date, nullable) - tanggal ketika pertanyaan ini diberikan ke user
- `discussed_at` (timestamp, nullable) - waktu ketika pertanyaan dibahas/dijawab
- `is_answered` (boolean, default: false) - apakah pertanyaan sudah dijawab/dibahas
- `source` (string, nullable) - sumber pertanyaan (contoh: "LeetCode", "System Design", "Interview Prep")
- `related_resources` (json, nullable) - link atau referensi terkait
  - Format: [{"title": "Documentation", "url": "https://..."}, {"title": "Article", "url": "https://..."}]
- `content_shared` (boolean, default: false) - apakah sudah di-share sebagai konten media sosial
- `notes` (text, nullable) - catatan tambahan
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Contoh Data:
- question='Apa perbedaan antara Promise.all() dan Promise.allSettled()?', category='best_practice', difficulty='intermediate', tags=['javascript', 'async', 'promise'], keywords=['promise', 'async', 'javascript']

### Logika Query:

#### Query 1: "bob pertanyaan hari ini"
1. Cek apakah sudah ada pertanyaan untuk hari ini (given_date = today)
2. Jika belum ada:
   - Ambil semua pertanyaan yang belum pernah diberikan dalam 30 hari terakhir
   - Filter berdasarkan kategori yang belum banyak dibahas (opsional, untuk variasi)
   - Pilih secara acak dari pool pertanyaan yang tersedia
   - Update given_date = today, is_answered = false
   - Return pertanyaan tersebut
3. Jika sudah ada:
   - Return pertanyaan yang sudah diberikan hari ini

#### Query 2: "bob kita pernah bahas tentang ini ga sih" (dengan topik/kata kunci)
1. Extract kata kunci dari query user (misal: "promise", "async", "javascript")
2. Cari di daily_learning_questions:
   - Match berdasarkan keywords (case-insensitive)
   - Match berdasarkan tags (case-insensitive)
   - Match berdasarkan question atau answer (full-text search)
3. Jika ditemukan:
   - Return: "Pernah, tanggal [given_date]. [Question]. [Answer jika ada]"
   - Tampilkan detail pertanyaan dan jawaban jika sudah dibahas
4. Jika tidak ditemukan:
   - Return: "Belum pernah bahas tentang [topik]"

### Catatan:
- Pertanyaan tidak akan berulang dalam 30 hari terakhir (bisa diubah ke 1 bulan penuh)
- Setiap pertanyaan bisa digunakan untuk konten media sosial setelah dibahas
- Keywords dan tags membantu pencarian topik yang pernah dibahas
- Bisa di-generate otomatis atau di-input manual ke database

---

- Semua tabel independen (tidak ada foreign key)
- Semua menggunakan timestamp untuk tracking waktu
- Activities bisa dihubungkan dengan foods jika aktivitasnya "beli makan"
- Recipes menggunakan ingredient_name untuk matching dengan pantry_ingredients (bukan foreign key, tapi matching by name)
- Saat memasak, update pantry_ingredients untuk mengurangi stok bahan yang digunakan

---

## Index yang Disarankan

- `cigarettes`: index pada `type`, `created_at`
- `foods`: index pada `category`, `created_at`
- `activities`: index pada `activity_type`, `location_status`, `is_active`, `created_at`
- `transport`: index pada `type`, `created_at`
- `biography`: index pada `category`, `is_public`, `tags` (untuk full-text search)
- `pantry_ingredients`: index pada `ingredient_name`, `category`, `is_active`, `quantity`
- `recipes`: index pada `recipe_name`, `category`, `is_favorite`, `tags` (untuk full-text search)
- `teams_schedules`: index pada `teams_event_id`, `start_time`, `end_time`, `status`
- `personal_schedules`: index pada `schedule_date`, `start_time`, `status`, `activity_type`
- `daily_learning_questions`: index pada `given_date`, `category`, `is_answered`, `tags` (untuk full-text search), `keywords` (untuk full-text search)

---

## Catatan Implementasi

1. Semua timestamp menggunakan timezone Asia/Jakarta
2. Untuk query "bos lu dimana?", ambil dari activities terakhir dengan is_active=true atau location_states
3. Untuk biografi, gunakan full-text search atau tag matching untuk mencari informasi yang relevan
4. Semua field nullable yang tidak wajib untuk fleksibilitas input
5. Untuk rekomendasi masakan:
   - Matching bahan antara recipes.ingredients dan pantry_ingredients berdasarkan ingredient_name
   - Pastikan quantity di stok >= quantity yang dibutuhkan resep
   - Bisa tambahkan prioritas berdasarkan is_favorite atau cook_count untuk sorting sebelum random
6. Saat memasak, kurangi stok di pantry_ingredients sesuai bahan yang digunakan
7. Update last_cooked_at dan cook_count di recipes saat masakan dibuat
8. Untuk query schedule:
   - Gabungkan hasil dari teams_schedules dan personal_schedules berdasarkan tanggal
   - Cek overlap waktu jika perlu menentukan apakah "free" atau tidak
   - Teams schedules di-sync secara berkala melalui Microsoft Teams API
9. Personal schedules dibuat melalui perintah user dan bisa di-update/dihapus manual
10. Untuk daily learning questions:
    - Query "pertanyaan hari ini" akan memberikan pertanyaan baru yang belum pernah diberikan dalam 30 hari terakhir
    - Query "kita pernah bahas tentang ini ga sih" akan mencari berdasarkan keywords, tags, atau full-text search
    - Pertanyaan bisa digunakan untuk konten media sosial setelah dibahas
    - Pastikan tidak ada duplikasi pertanyaan dalam periode 30 hari

