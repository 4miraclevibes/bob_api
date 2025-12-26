# Panduan Import Postman Collection

## Cara Import Collection ke Postman

1. **Buka Postman**
2. **Klik "Import"** di pojok kiri atas
3. **Pilih "File"** tab
4. **Pilih file** `bob_api.postman_collection.json`
5. **Klik "Import"**

## Setup Environment Variable

Setelah import, collection akan menggunakan variable `{{base_url}}` yang sudah di-set default ke `http://localhost:8000/api`.

Jika server Anda berjalan di port atau URL yang berbeda:

1. Klik pada collection "Bob API"
2. Klik tab "Variables"
3. Edit value `base_url` sesuai dengan URL server Anda
4. Contoh: `http://127.0.0.1:8000/api` atau `http://localhost:8000/api`

## Test Endpoints

### Endpoint yang Direkomendasikan untuk Test Pertama:

1. **GET /api/cigarettes** - Test GET semua data
2. **GET /api/foods** - Test GET dengan filter
3. **GET /api/activities?current=true** - Test GET current activity
4. **GET /api/recipes/recommendations** - Test rekomendasi masakan
5. **GET /api/daily-learning-questions/today** - Test pertanyaan hari ini
6. **GET /api/schedules/by-date?date=2024-12-27** - Test schedule by date

### Test Create (POST):

1. **POST /api/cigarettes** - Create cigarette record
2. **POST /api/foods** - Create food record
3. **POST /api/activities** - Create activity
4. **POST /api/activities/return-home** - Test return home

## Catatan

- Pastikan server Laravel sudah running (`php artisan serve`)
- Pastikan database sudah di-migrate dan di-seed
- Semua endpoint menggunakan format JSON
- Response akan mengembalikan format:
  ```json
  {
    "success": true,
    "data": {...}
  }
  ```

## Troubleshooting

Jika ada error:
1. Cek apakah server sudah running
2. Cek apakah base_url sudah benar
3. Cek apakah database sudah di-migrate dan di-seed
4. Cek console Laravel untuk error detail

