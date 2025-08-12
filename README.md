# PG Booking Platform

A simple **PG (Paying Guest) / Hostel Room Booking System** built using **PHP, MySQL, HTML, CSS, JavaScript, and Tailwind CSS**.  
It allows **owners** to list their PG rooms and **users** to search, view details, and book rooms online.

---

## 📌 Features

### For Owners
- Owner Registration & Login
- Add, Edit, and Delete PG Room Details
- Upload Room Photos
- View Bookings and Customer Details

### For Users
- Search PG Rooms by Location & Price
- View Room Details & Images
- Book Rooms Online
- Receive Booking Confirmation

### Admin Panel (Optional)
- Manage Owners & Users
- View All PG Listings
- Delete or Edit Listings

---

## 🛠 Tech Stack

- **Frontend:** HTML, CSS, Tailwind CSS, JavaScript
- **Backend:** PHP (Procedural or OOP)
- **Database:** MySQL
- **Server:** Apache (XAMPP/LAMP)

---

## 📂 Folder Structure

pg-booking/
│── config/
│ └── db.php # Database connection
│
│── pages/
│ ├── owner_dashboard.php
│ ├── user_dashboard.php
│ ├── room_details.php
│ ├── booking_form.php
│ └── login.php
│
│── assets/
│ ├── css/
│ ├── js/
│ └── images/
│
│── index.php # Home page
│── register.php # Owner/User registration
│── README.md # Project documentation
└── database.sql # MySQL database structure


---

## ⚙️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/pg-booking.git
Move the project to your server directory

For XAMPP: C:/xampp/htdocs/pg-booking

For LAMP: /var/www/html/pg-booking

Import the database

Open phpMyAdmin

Create a database (e.g., pg_booking)

Import database.sql from the project folder

Configure database

Update config/db.php with your database credentials:

$conn = mysqli_connect("localhost", "root", "", "pg_booking");
Start Apache & MySQL

Open XAMPP and start services

Visit http://localhost/pg-booking

📸 Screenshots
<img width="1261" height="566" alt="image" src="https://github.com/user-attachments/assets/ffbac81b-470d-403e-935b-5cb77aece362" />
<img width="471" height="549" alt="image" src="https://github.com/user-attachments/assets/1b2f75d0-9a6c-45c9-a843-6ff3cfb8de58" />



🚀 Future Improvements
Payment Gateway Integration

Review & Rating System

Advanced Filters (Wi-Fi, AC, Food Included)

Email/SMS Notifications

👨‍💻 Author
Vikash Yadav
