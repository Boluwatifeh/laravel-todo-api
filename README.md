# 📝 Laravel Todo API

A simple token-based Laravel REST API that allows users to register, authenticate, and manage their todo items.

Built with Laravel 12 and Sanctum for authentication. Designed for frontend consumption via Postman, React, Vue, or any HTTP client.

---

## 🔐 Authentication

Authentication is powered by **Laravel Sanctum** with token-based access (not cookie/session based).

---

## 📦 API Endpoints

### 🔸 Public Routes

| Method | Endpoint        | Description           |
|--------|------------------|------------------------|
| POST   | `/api/register` | Register a new user    |
| POST   | `/api/login`    | Login and get token    |

### 🔐 Protected Routes (require `Bearer Token`)

| Method | Endpoint         | Description                  |
|--------|------------------|------------------------------|
| POST   | `/api/logout`    | Logout (invalidate token)    |
| GET    | `/api/user`      | Get authenticated user info  |

### ✅ Todo Routes (Protected)

| Method | Endpoint             | Description               |
|--------|----------------------|---------------------------|
| POST   | `/api/todos`         | Create a new todo         |
| GET    | `/api/todos`         | Get list of user's todos  |
| GET    | `/api/todos/{id}`    | View a single todo        |
| PUT    | `/api/todos/{id}`    | Update a todo             |
| DELETE | `/api/todos/{id}`    | Delete a todo             |

---

## 🛠️ Setup Instructions

### 1. Clone the Repo

```bash
git clone https://github.com/Boluwatifeh/laravel-todo-api.git
cd laravel-todo-api
