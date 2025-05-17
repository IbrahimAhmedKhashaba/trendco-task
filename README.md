Trendco Task

🔐 Authentication System

The authentication system is designed with flexibility and extensibility in mind using key design patterns:

Strategy Pattern:Supports multiple authentication methods, including traditional email/password login and social media login (e.g., Google). This allows adding new providers like Facebook without modifying the core authentication logic.

Factory Pattern:Returns the appropriate class instance based on the authentication method, enabling a clean and decoupled implementation.

Email Verification

For traditional email sign-ups, users must verify their email address.

Email verification uses Laravel Events, Jobs, and Notifications to send a verification link asynchronously.

Users can also resend the verification email if needed.

Clean Architecture

Authentication logic is abstracted using Repository and Service Layers, ensuring separation of concerns and easy maintainability.

This approach ensures the authentication module is scalable, testable, and production-ready.

🛠️ Admin Panel

The Admin Panel provides a comprehensive management interface allowing administrators to efficiently oversee key aspects of the application:

Category Management: Create, update, delete, and organize product categories.

Product Management: Add, edit, and remove products.

Order Status Management: Modify and track order statuses during the order lifecycle.

User Management: Manage user accounts and control access levels.

Admin Roles & Permissions: Manage administrators and assign roles securely.

Designed with a focus on security, usability, and scalability.

👤 User Features

The User module offers a seamless and intuitive experience for customers:

Browse Categories and Products: Explore categories and detailed product info.

Profile Management: View and update user profile details.

Shopping Cart Management: Add, update, remove products, and review cart contents.

Secure Payments: Supports payments via PayPal and Stripe.

Focus on usability and security for effortless shopping.

💳 Application Architecture

Payment Gateways Handling:Implemented using Strategy and Factory patterns for easy addition or switching of gateways like PayPal and Stripe without changing existing code.

Dependency Injection:Used across the application to promote loose coupling, easier testing, and maintainability.

Repository and Service Layers:Abstract business logic and data access via interfaces, facilitating clean architecture and testability.

This ensures scalability, maintainability, and extensibility.

⚙️ Asynchronous Processing & Notifications

Jobs & Queues:Background tasks (e.g., sending emails) are handled asynchronously with Laravel Queues, improving responsiveness.

Events & Listeners:Business events trigger decoupled listeners for clean and maintainable code.

Notifications:Users receive notifications via email, database, and other channels for events like email verification and order updates.

This setup ensures smooth, scalable, and user-friendly operations.

⚙️ Installation & Setup

Follow these steps to set up the project and configure essential integrations:

Queue Configuration

Uses Laravel’s database queue driver for background jobs.

Run migrations to create the jobs table:

php artisan queue:table
php artisan migrate

Payment Gateways Integration

PayPal Setup

Create a PayPal developer account at PayPal Developer.

Create a new REST API app to obtain your Client ID and Secret.

Add credentials to your .env file:

PAYPAL_SANDBOX_CLIENT_ID=your-client-id
PAYPAL_SECRET=your-secret
PAYPAL_SANDBOX_CLIENT_SECRET=sandbox
PAYPAL_MODE=sandbox
PAYPAL_CURRENCY=USD
PAYPAL_SUCCESS_URL=https://your-domain.com/payment/success
PAYPAL_CANCEL_URL=https://your-domain.com/payment/cancel

Set up webhook in PayPal dashboard with the following events:

Checkout order approved

Payment capture completed

Payment capture denied

Webhook URL example:

https://your-ngrok-domain/api/payment/handle?method=paypal

Stripe Setup

Create a Stripe account at Stripe Dashboard.

Retrieve your Publishable Key and Secret Key.

Add credentials to your .env file:

STRIPE_PUBLIC=your-publishable-key
STRIPE_SECRET=your-secret-key
STRIPE_CURRENCY=usd
STRIPE_SUCCESS_URL=https://your-domain.com/payment/success
STRIPE_CANCEL_URL=https://your-domain.com/payment/cancel
STRIPE_WEBHOOK_SECRET=your-webhook-secret

Set up webhook in Stripe dashboard tracking events:

Checkout order approved

Payment capture completed

Payment capture denied

Webhook URL example:

https://your-ngrok-domain/api/payment/handle

Google OAuth Setup

Go to Google Cloud Console.

Create OAuth 2.0 Client ID credentials.

Set authorized redirect URI:

http://localhost:8000/api/auth/register?provider=google

Add credentials to your .env file:

GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/api/auth/register?provider=google

General Setup

Clone the repository:

git clone https://github.com/yourusername/yourproject.git
cd yourproject

Install PHP dependencies:

composer install

Set up .env with database, payment, and OAuth credentials.

Run migrations and seeders:

php artisan migrate --seed

Start the Laravel development server:

php artisan serve

Start the queue worker:

php artisan queue:work

