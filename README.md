🛍️ Trendco Project
🔐 Authentication System
Authentication is designed with flexibility and extensibility in mind using key design patterns:

Strategy Pattern
Supports multiple authentication methods (e.g., email/password, Google OAuth). Easily extendable to Facebook, etc.

Factory Pattern
Returns the appropriate authentication handler class, keeping the code clean and decoupled.

✅ Email Verification
Email verification is required for traditional sign-ups.

Handled using Events, Jobs, and Notifications.

Users can resend the verification email anytime.

🧱 Clean Architecture
Repository & Service Layers ensure separation of concerns.

Enhances testability, scalability, and maintainability.

🛠️ Admin Panel
A powerful backend management interface to control the system:

🗂️ Category Management

📦 Product Management

📬 Order Status Management

👤 User Management

🔐 Admin Roles & Permissions

Built with a focus on security, usability, and scalability.

👤 User Features
Designed for a smooth user experience:

🔍 Browse Products & Categories

👤 Profile Management

🛒 Shopping Cart

💳 Secure Payments via PayPal & Stripe

Focus on usability and security for effortless shopping.

💳 Application Architecture
🧠 Payment Gateways handled using Strategy and Factory patterns.

💉 Dependency Injection used across the app for testability and flexibility.

🧱 Repository/Service Layers for clean separation of logic.

This architecture ensures extensibility, maintainability, and scalability.

📩 Asynchronous Processing & Notifications
⚙️ Jobs & Queues: Send emails and handle background tasks without blocking.

📡 Events & Listeners: Decoupled business logic.

🔔 Notifications: Email, database, etc., for user events like order updates or email verification.

⚙️ Installation & Setup
🧵 Queue Configuration
php artisan queue:table
php artisan migrate
php artisan queue:work
💰 Payment Gateways Integration
🔹 PayPal
Create Developer Account

Add to .env:
PAYPAL_SANDBOX_CLIENT_ID=your-client-id
PAYPAL_SECRET=your-secret
PAYPAL_MODE=sandbox
PAYPAL_CURRENCY=USD
...
Webhook URL example:
https://your-ngrok-domain/api/payment/handle?method=paypal
🔸 Stripe
Create Stripe Account

Add to .env:
STRIPE_PUBLIC=your-publishable-key
STRIPE_SECRET=your-secret-key
...
Webhook URL example:
https://your-ngrok-domain/api/payment/handle
🔑 Google OAuth
Create OAuth Credentials

Set redirect URI:

http://localhost:8000/api/auth/register?provider=google
Add to .env:
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-secret
🧰 General Setup

git clone https://github.com/yourusername/yourproject.git
cd yourproject
composer install
php artisan migrate --seed
php artisan serve

---

## 📬 Need Help?

If you encounter any issues or have any questions, feel free to reach out:

- 📧 Email: [ibrahimahmedkhashaba@gmail.com](mailto:ibrahimahmedkhashaba@gmail.com)  
- 💼 LinkedIn: [Ibrahim Khashaba](https://www.linkedin.com/in/ibrahim-khashaba-9167a323b/)  
- 📱 WhatsApp: [+201124782711](https://wa.me/201124782711)

I'm happy to help anytime!
