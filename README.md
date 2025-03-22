
```markdown
# 🏟️ Sports Arena API (Laravel 11)

This API manages sports arena bookings, allowing **owners** to create arenas and **customers** to reserve time slots.

## 🚀 Features
- ✅ **User Authentication** (Laravel Sanctum)
- ✅ **Owners Create Arenas**
- ✅ **Time Slot Management**
- ✅ **Booking System with Expiration Handling**
- ✅ **Concurrency Handling with Database Locking**
- ✅ **Postman Collection Included**
- ✅ **Role-Based Access Control (RBAC)** for Owners and Customers
- ✅ **Unit & Feature Tests**
- ✅ **Optimized Database Queries**

## 🔧 Installation & Setup

### **1️⃣ Clone Repository**
```sh
git clone https://github.com/Rajaei453/sports-arena-api.git
cd sports-arena-api
```

### **2️⃣ Install Dependencies**
Ensure you have PHP 8.2 or higher installed. Then, run the following command to install dependencies:
```sh
composer install
```

### **3️⃣ Set Up Environment**
Create a copy of the example environment file:
```sh
cp .env.example .env
```

Generate an application key:
```sh
php artisan key:generate
```

### **4️⃣ Configure Database**
Update your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run the migrations and seed the database:
```sh
php artisan migrate --seed
```

### **5️⃣ Run the Server**
Start the Laravel development server:
```sh
php artisan serve
```

### **6️⃣ API Documentation**
Use Postman to test the API:  
[📥 Download Postman Collection](https://github.com/Rajaei453/sports-arena-api/blob/main/SpSports Arena API.postman_collection.json)

## 🛠️ Running Tests

### **Unit Tests**
Run unit tests to verify core functionality:
```sh
php artisan test --filter=AuthTest
php artisan test --filter=ArenaTest
php artisan test --filter=TimeSlotTest
php artisan test --filter=BookingTest
```


## 🏆 Authentication Flow

### **1️⃣ Register**
Endpoint: **POST /api/auth/register**  
Register a new user with the following parameters:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "owner"
}
```

### **2️⃣ Login**
Endpoint: **POST /api/auth/login**  
Log in with the following parameters:
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```
Upon successful login, you will receive a JSON Web Token (JWT) in the response:
```json
{
  "message": "Login successful",
  "token": "generated_access_token",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "owner"
  }
}
```

### **3️⃣ Use Token in Requests**
For all authenticated requests, include the token in the `Authorization` header:
```plaintext
Authorization: Bearer YOUR_TOKEN_HERE
```

## 📡 API Endpoints

### **Authentication**
- **POST /api/auth/register**: Register a new user.
- **POST /api/auth/login**: Log in a user.
- **POST /api/auth/logout**: Log out a user (requires authentication).

### **Arena Management**
- **GET /api/arenas**: Get all arenas.
- **GET /api/arenas/{id}**: Get a specific arena by ID.
- **POST /api/arenas**: Create a new arena (requires owner role).

### **Time Slot Management**
- **GET /api/time-slots/available/{arenaId}**: Get available time slots for an arena.
- **POST /api/time-slots**: Create a new time slot (requires owner role).

### **Booking System**
- **POST /api/bookings/reserve**: Reserve a time slot (requires customer role).
- **POST /api/bookings/release-expired**: Release unconfirmed bookings (requires owner role).

## 🛡️ Security & Concurrency Handling

### **Security**
- Authentication is enforced using Laravel Sanctum.
- Middleware ensures that only authorized users can access certain routes.
- Unauthorized users receive a JSON response with a 401 status code.

### **Concurrency Handling**
- Time slots are locked using database transactions to prevent double bookings.
- Unconfirmed bookings are released after 10 minutes using a scheduled job.

## 🗂️ Folder Structure

The project is organized using the **Domain-Driven Design (DDD)** structure:

```
app/
├── Domain/
│   ├── Models/
│   ├── Repositories/
│   ├── Services/
├── Application/
│   ├── DTOs/
│   ├── UseCases/
├── Infrastructure/
│   ├── Persistence/
│   ├── Providers/
│   ├── Controllers/
```

## 📝 Documentation

### **Deploy to Production**
- Use Laravel Forge, AWS, or DigitalOcean for hosting.
- Configure environment variables in `.env`.
- Use Supervisor to manage queue workers if needed.

## 🤝 Contributors
- **Rajaei Hammoud (@Rajaei453)**

## 📜 License
This project is licensed under the **MIT License**.

