# 🛍️ Trendco Project

## 🔐 Authentication System

Authentication is designed with **flexibility** and **extensibility** in mind using key design patterns:

- **Strategy Pattern**  
  Supports multiple authentication methods (e.g., email/password, Google OAuth). Easily extendable to Facebook, etc.

- **Factory Pattern**  
  Returns the appropriate authentication handler class, keeping the code clean and decoupled.

### ✅ Email Verification

- Email verification is required for traditional sign-ups.
- Handled using **Events**, **Jobs**, and **Notifications**.
- Users can **resend** the verification email anytime.

### 🧱 Clean Architecture

- **Repository & Service Layers** ensure separation of concerns.
- Enhances **testability**, **scalability**, and **maintainability**.

---

## 🛠️ Admin Panel

A powerful backend management interface to control the system:

- 🗂️ **Category Management**
- 📦 **Product Management**
- 📬 **Order Status Management**
- 👤 **User Management**
- 🔐 **Admin Roles & Permissions**

Built with a focus on **security**, **usability**, and **scalability**.

---

## 👤 User Features

Designed for a smooth user experience:

- 🔍 **Browse Products & Categories**
- 👤 **Profile Management**
- 🛒 **Shopping Cart**
- 💳 **Secure Payments** via PayPal & Stripe

Focus on **usability** and **security** for effortless shopping.

---

## 💳 Application Architecture

- 🧠 **Payment Gateways** handled using **Strategy** and **Factory** patterns.
- 💉 **Dependency Injection** used across the app for testability and flexibility.
- 🧱 **Repository/Service Layers** for clean separation of logic.

This architecture ensures **extensibility**, **maintainability**, and **scalability**.

---

## 📩 Asynchronous Processing & Notifications

- ⚙️ **Jobs & Queues**: Send emails and handle background tasks without blocking.
- 📡 **Events & Listeners**: Decoupled business logic.
- 🔔 **Notifications**: Email, database, etc., for user events like order updates or email verification.

---

## ⚙️ Installation & Setup

### 🧵 Queue Configuration

```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

---

### 💰 Payment Gateways Integration

#### 🔹 PayPal

1. [Create Developer Account](https://developer.paypal.com/)
2. Add to `.env`:

```env
PAYPAL_SANDBOX_CLIENT_ID=your-client-id
PAYPAL_SECRET=your-secret
PAYPAL_SANDBOX_CLIENT_SECRET=sandbox
PAYPAL_MODE=sandbox
PAYPAL_CURRENCY=USD
PAYPAL_SUCCESS_URL=https://your-domain.com/payment/success
PAYPAL_CANCEL_URL=https://your-domain.com/payment/cancel
```

3. Webhook URL example:

```
https://your-ngrok-domain/api/payment/handle?method=paypal
```

#### 🔸 Stripe

1. [Create Stripe Account](https://dashboard.stripe.com/)
2. Add to `.env`:

```env
STRIPE_PUBLIC=your-publishable-key
STRIPE_SECRET=your-secret-key
STRIPE_CURRENCY=usd
STRIPE_SUCCESS_URL=https://your-domain.com/payment/success
STRIPE_CANCEL_URL=https://your-domain.com/payment/cancel
STRIPE_WEBHOOK_SECRET=your-webhook-secret
```

3. Webhook URL example:

```
https://your-ngrok-domain/api/payment/handle
```

---

### 🔑 Google OAuth

1. [Create OAuth Credentials](https://console.cloud.google.com/)
2. Set redirect URI:

```
http://localhost:8000/api/auth/register?provider=google
```

3. Add to `.env`:

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/api/auth/register?provider=google
```

---

### 🧰 General Setup

```bash
git clone https://github.com/yourusername/yourproject.git
cd yourproject
composer install
php artisan migrate --seed
php artisan serve
php artisan queue:work
```

## 📫 Postman Collection

You can explore and test the API using the official Postman collection:

👉 [Click here to open the Postman Collection](https://documenter.getpostman.com/view/40282253/2sB2qWHjSP)


---

## 📬 Need Help?

If you encounter any issues or have any questions, feel free to reach out:

- 📧 Email: [ibrahimahmedkhashaba@gmail.com](mailto:ibrahimahmedkhashaba@gmail.com)  
- 💼 LinkedIn: [Ibrahim Khashaba](https://www.linkedin.com/in/ibrahim-khashaba-9167a323b/)  
- 📱 WhatsApp: [+201124782711](https://wa.me/201124782711)

I'm happy to help anytime!

