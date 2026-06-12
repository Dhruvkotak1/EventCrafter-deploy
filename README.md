# 🎉 EventCrafter - Event Management System

EventCrafter is a web-based event management platform built using Laravel. It allows customers to browse and book events, organizers to manage events, and admins to monitor the overall platform operations. It is designed with a focus on simplicity, usability, and role-based functionality.

---

## 🚀 Features

### 👤 Customer
- View upcoming and featured events
- Book tickets for events
- Give feedback and rate attended events

### 🧑‍💼 Organizer
- Create, update, and delete events
- Manage bookings for their own events
- View analytics for events (bookings, feedback)

### 🛠️ Admin
- Manage users and organizers
- Approve/block users
- Manage all events
- View reports and feedback

---

## 🧱 Tech Stack

- **Framework:** Laravel 10+
- **Frontend:** TailwindCSS + DaisyUI (Night Theme)
- **Database:** MySQL
- **Deployment:** Render (frontend/backend) + Railway (database)
- **Authentication:** Laravel Breeze
- **Charts:** Chart.js for analytics


---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/EventCrafter.git
cd EventCrafter

2. Install Dependencies

composer install
npm install

3. Setup Environment

cp .env.example .env
php artisan key:generate

Edit .env and configure your database settings:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eventcrafter
DB_USERNAME=root
DB_PASSWORD=

4. Run Migrations and Seed

php artisan migrate --seed

5. Start Development Server

php artisan serve
npm run dev

```
---

🧪 Default Roles

Role	Login Details

Admin	admin@eventcrafter.com / password
Organizer	organizer@eventcrafter.com / password
Customer	customer@eventcrafter.com / password


> You can change these in the seeders or directly from the database.




---

📊 Reports & Analytics

Booking analytics are shown with ring charts and data tables.

Feedback reports include average ratings per event.

All analytics are auto-adjusted for dark/light themes using DaisyUI.


---


💡 Future Enhancements

Integrate a real payment system (e.g., Razorpay or Stripe)

Organizer-level analytics dashboard

Advanced filters for customers to find events

Multi-language support


---



👨‍💻 Developed By

Dhruv Kotak
Laravel Developer | Python Enthusiast | Java Programmer
GitHub: @Dhruvkotak1
