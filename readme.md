# 📌 Smart Task Manager

A full-stack role-based task management system built using **PHP, MySQL, HTML, CSS, and JavaScript**.
It includes authentication, admin control, task CRUD operations, and a modern dashboard UI.

---

# 🚀 Features

## 👤 User Features

* User registration and login
* Create tasks
* View personal tasks
* Mark tasks as completed
* Delete tasks
* Search and filter tasks

## 🛡️ Admin Features

* Admin dashboard access
* View all users’ tasks
* Task analytics (total, pending, completed)
* Centralized task monitoring

## 📊 Dashboard

* Real-time task statistics
* Clean card-based UI
* Sidebar navigation layout
* Responsive design

---

# 🧰 Tech Stack

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP
* **Database:** MySQL
* **Server:** Apache (XAMPP)

---

# 🏗️ Project Structure

```
smart-task-manager/
│
├── api/
│   ├── auth.php
│   ├── tasks.php
│   └── admin.php
│
├── config/
│   └── db.php
│
├── public/
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── admin.php
│   └── logout.php
│
├── assets/
│   └── style.css
│
└── README.md
```

---

# ⚙️ Installation & Setup

## 1. Clone or Download Project

Place the project inside:

```
C:\xampp\htdocs\
```

---

## 2. Start Server

Start:

* Apache
* MySQL (via XAMPP)

---

## 3. Create Database

Create a database:

```
smart_task_manager
```

Import or create tables:

### Users Table

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(255),
  role VARCHAR(20) DEFAULT 'user'
);
```

### Tasks Table

```sql
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  status VARCHAR(20) DEFAULT 'pending',
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

## 4. Run Project

Open in browser:

```
http://localhost/smart-task-manager/public/login.php
```

---

# 🔐 Login Flow

* Register new user
* Login with credentials
* Redirect to dashboard
* Admin users access admin panel

---

# 👑 Admin Access

To make a user admin:

```sql
UPDATE users SET role = 'admin' WHERE id = 1;
```

---

# 🎯 Learning Outcomes

This project demonstrates:

* Full-stack CRUD operations
* Session-based authentication
* Role-based access control (RBAC)
* REST-like PHP API structure
* Frontend-backend integration
* Responsive UI design

---

# 🚀 Future Improvements

* Add task deadlines
* Add notifications
* Drag & drop task board
* Charts for analytics
* Deploy to live server

---

