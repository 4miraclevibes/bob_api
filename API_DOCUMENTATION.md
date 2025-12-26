# Bob Personal Assistant API Documentation

Base URL: `http://localhost:8000/api` (atau sesuai dengan konfigurasi server Anda)

## Response Format

Semua response menggunakan format JSON dengan struktur:

```json
{
  "success": true,
  "message": "Optional message",
  "data": {}
}
```

---

## 1. Cigarettes API

### Get All Cigarettes
```
GET /api/cigarettes
```

**Query Parameters:**
- `type` (optional): Filter by type (`purchase` atau `consume`)
- `start_date` (optional): Filter from date (format: YYYY-MM-DD)
- `end_date` (optional): Filter to date (format: YYYY-MM-DD)

**Example Request:**
```
GET /api/cigarettes?type=purchase&start_date=2024-01-01
```

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "type": "purchase",
      "brand": "Sampoerna",
      "quantity": 1,
      "price": 38000,
      "total_price": 38000,
      "notes": "Beli rokok pertama kali",
      "created_at": "2024-12-26T10:00:00.000000Z",
      "updated_at": "2024-12-26T10:00:00.000000Z"
    }
  ]
}
```

### Create Cigarette Record
```
POST /api/cigarettes
```

**Body (JSON):**
```json
{
  "type": "consume",
  "quantity": 1,
  "notes": "Ngerokok"
}
```

**Required Fields:**
- `type`: `purchase` atau `consume`
- `quantity`: integer (min: 1)

**Optional Fields:**
- `brand`: string
- `price`: decimal (untuk purchase)
- `total_price`: decimal (untuk purchase)
- `notes`: string

---

## 2. Foods API

### Get All Foods
```
GET /api/foods
```

**Query Parameters:**
- `category` (optional): Filter by category (`food`, `drink`, atau `snack`)
- `start_date` (optional): Filter from date
- `end_date` (optional): Filter to date

**Example Request:**
```
GET /api/foods?category=food
```

### Create Food Record
```
POST /api/foods
```

**Body (JSON):**
```json
{
  "category": "food",
  "item_name": "Nasi Goreng",
  "cost": 25000,
  "quantity": 1,
  "location": "Warung Makan Pak Budi",
  "notes": "Nasi goreng spesial"
}
```

**Required Fields:**
- `category`: `food`, `drink`, atau `snack`
- `item_name`: string
- `cost`: decimal (min: 0)

**Optional Fields:**
- `quantity`: integer (default: 1)
- `location`: string
- `notes`: string

---

## 3. Activities API

### Get All Activities
```
GET /api/activities
```

**Query Parameters:**
- `activity_type` (optional): Filter by type (`beli_makan`, `nongkrong`, `futsal`, `tidur`, `lainnya`)
- `location_status` (optional): Filter by status (`outside` atau `inside`)
- `is_active` (optional): Filter active activities (`true` atau `false`)
- `current` (optional): Get current active activity (`true`)

**Example Request:**
```
GET /api/activities?current=true
```

### Create Activity
```
POST /api/activities
```

**Body (JSON):**
```json
{
  "activity_type": "beli_makan",
  "description": "Beli makan siang",
  "location_status": "outside",
  "started_at": "2024-12-26 12:00:00",
  "is_active": true
}
```

### Return Home (Mark activity as returned)
```
POST /api/activities/return-home
```

**Example Response:**
```json
{
  "success": true,
  "message": "Activity marked as returned home",
  "data": {
    "id": 1,
    "location_status": "inside",
    "is_active": false,
    "ended_at": "2024-12-26T15:00:00.000000Z"
  }
}
```

---

## 4. Transport API

### Get All Transport Records
```
GET /api/transport
```

**Query Parameters:**
- `type` (optional): Filter by type (`fuel`, `service`, `maintenance`, `lainnya`)
- `vehicle_type` (optional): Filter by vehicle type
- `start_date` (optional): Filter from date
- `end_date` (optional): Filter to date

### Create Transport Record
```
POST /api/transport
```

**Body (JSON) - Fuel:**
```json
{
  "type": "fuel",
  "vehicle_type": "motor",
  "amount": 50000,
  "description": "Isi bahan bakar 3 liter"
}
```

**Body (JSON) - Service:**
```json
{
  "type": "service",
  "vehicle_type": "motor",
  "amount": 250000,
  "description": "Service motor rutin",
  "service_items": [
    {"item": "Oli mesin", "price": 50000},
    {"item": "Ban belakang", "price": 150000}
  ]
}
```

---

## 5. Biography API

### Get All Biography
```
GET /api/biography
```

**Query Parameters:**
- `category` (optional): Filter by category
- `public_only` (optional): Filter public only (`true`)
- `tag` (optional): Search by tag
- `search` (optional): Search in title or content

### Create Biography
```
POST /api/biography
```

**Body (JSON):**
```json
{
  "category": "personal_info",
  "title": "Tempat Lahir",
  "content": "Jakarta, Indonesia",
  "tags": ["lahir", "jakarta"],
  "is_public": true,
  "priority": 10
}
```

---

## 6. Location State API

### Get Current Location State
```
GET /api/location-state
```

### Update Location State
```
POST /api/location-state
PUT /api/location-state
```

**Body (JSON):**
```json
{
  "status": "outside",
  "last_activity": "beli makan",
  "current_location": "Warung Makan"
}
```

---

## 7. Pantry Ingredients API

### Get All Pantry Ingredients
```
GET /api/pantry-ingredients
```

**Query Parameters:**
- `category` (optional): Filter by category
- `active_only` (optional): Filter active only (`true`)
- `low_stock` (optional): Filter low stock (`true`)

### Create Pantry Ingredient
```
POST /api/pantry-ingredients
```

**Body (JSON):**
```json
{
  "ingredient_name": "beras",
  "category": "grain",
  "unit": "kg",
  "quantity": 5.0,
  "min_quantity": 1.0,
  "purchase_price": 15000
}
```

---

## 8. Recipes API

### Get All Recipes
```
GET /api/recipes
```

**Query Parameters:**
- `category` (optional): Filter by category
- `difficulty` (optional): Filter by difficulty (`easy`, `medium`, `hard`)
- `favorite_only` (optional): Filter favorites (`true`)
- `tag` (optional): Search by tag

### Get Recipe Recommendations
```
GET /api/recipes/recommendations
```

**Description:** Get recipes that can be made with available ingredients

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "recipe_name": "Nasi Goreng",
      "category": "rice",
      "ingredients": [...]
    }
  ],
  "count": 2
}
```

### Create Recipe
```
POST /api/recipes
```

**Body (JSON):**
```json
{
  "recipe_name": "Nasi Goreng",
  "category": "rice",
  "difficulty": "easy",
  "cooking_time": 15,
  "servings": 2,
  "ingredients": [
    {"ingredient_name": "beras", "quantity": 0.3, "unit": "kg"},
    {"ingredient_name": "minyak goreng", "quantity": 0.05, "unit": "liter"}
  ],
  "instructions": "1. Panaskan minyak...",
  "tags": ["cepat", "mudah"]
}
```

---

## 9. Teams Schedules API

### Get All Teams Schedules
```
GET /api/teams-schedules
```

**Query Parameters:**
- `status` (optional): Filter by status (`confirmed`, `tentative`, `cancelled`)
- `start_date` (optional): Filter from date
- `end_date` (optional): Filter to date
- `date` (optional): Get schedules for specific date

### Create Teams Schedule
```
POST /api/teams-schedules
```

**Body (JSON):**
```json
{
  "teams_event_id": "teams-001",
  "title": "Daily Standup",
  "description": "Daily standup meeting",
  "start_time": "2024-12-27 09:00:00",
  "end_time": "2024-12-27 09:30:00",
  "location": "Microsoft Teams",
  "status": "confirmed",
  "attendees": [
    {"name": "John Doe", "email": "john@example.com"}
  ],
  "meeting_link": "https://teams.microsoft.com/l/meetup-join/123"
}
```

---

## 10. Personal Schedules API

### Get All Personal Schedules
```
GET /api/personal-schedules
```

**Query Parameters:**
- `activity_type` (optional): Filter by activity type
- `status` (optional): Filter by status (`scheduled`, `completed`, `cancelled`)
- `start_date` (optional): Filter from date
- `end_date` (optional): Filter to date
- `date` (optional): Get schedules for specific date

### Get Schedules by Date (Combines Teams + Personal)
```
GET /api/schedules/by-date?date=2024-12-27
```

**Example Response:**
```json
{
  "success": true,
  "data": {
    "teams_schedules": [...],
    "personal_schedules": [...],
    "total": 3,
    "is_free": false
  }
}
```

### Create Personal Schedule
```
POST /api/personal-schedules
```

**Body (JSON):**
```json
{
  "title": "Minisoccer",
  "description": "Minisoccer dengan teman",
  "schedule_date": "2024-12-28",
  "start_time": "19:00",
  "end_time": "21:00",
  "location": "Lapangan Futsal",
  "activity_type": "minisoccer",
  "reminder_before": 30,
  "status": "scheduled"
}
```

---

## 11. Daily Learning Questions API

### Get All Questions
```
GET /api/daily-learning-questions
```

**Query Parameters:**
- `category` (optional): Filter by category
- `difficulty` (optional): Filter by difficulty
- `is_answered` (optional): Filter answered (`true` atau `false`)
- `search` (optional): Search in question, answer, tags, or keywords

### Get Today's Question
```
GET /api/daily-learning-questions/today
```

**Description:** Get or assign a new question for today (won't repeat within 30 days)

**Example Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "question": "Apa perbedaan antara Promise.all() dan Promise.allSettled()?",
    "category": "best_practice",
    "difficulty": "intermediate",
    "tags": ["javascript", "async", "promise"],
    "given_date": "2024-12-26"
  }
}
```

### Search Topic
```
GET /api/daily-learning-questions/search-topic?topic=promise
```

**Description:** Search if a topic has been discussed before

**Example Response:**
```json
{
  "success": true,
  "found": true,
  "message": "Pernah bahas tentang promise",
  "data": [
    {
      "id": 1,
      "question": "...",
      "given_date": "2024-12-20",
      "answer": "..."
    }
  ]
}
```

### Create Question
```
POST /api/daily-learning-questions
```

**Body (JSON):**
```json
{
  "question": "Apa itu Design Pattern Singleton?",
  "category": "design_pattern",
  "difficulty": "intermediate",
  "tags": ["design_pattern", "singleton", "oop"],
  "keywords": ["singleton", "design pattern"],
  "source": "Design Patterns Book"
}
```

---

## Error Responses

Semua error mengembalikan format:

```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

**HTTP Status Codes:**
- `200` - Success
- `201` - Created
- `400` - Bad Request (Validation Error)
- `404` - Not Found
- `500` - Server Error

---

## Testing dengan Postman

1. **Import Collection:**
   - Buat collection baru di Postman
   - Tambahkan semua endpoint di atas

2. **Base URL:**
   - Set base URL: `http://localhost:8000/api`

3. **Headers:**
   - `Content-Type: application/json`
   - `Accept: application/json`

4. **Example Request Body:**
   - Gunakan contoh JSON di atas untuk setiap endpoint

5. **Test Endpoints:**
   - Mulai dengan GET endpoints untuk melihat data
   - Lalu test POST untuk create data
   - Test PUT/PATCH untuk update
   - Test DELETE untuk hapus data

---

## Notes

- Semua endpoint menggunakan RESTful API standard
- Semua date format: `YYYY-MM-DD` atau `YYYY-MM-DD HH:mm:ss`
- Time format: `HH:mm` (24-hour format)
- Decimal values menggunakan titik (.) sebagai separator
- Array dalam JSON menggunakan format standar JSON array

