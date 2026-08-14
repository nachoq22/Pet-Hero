🐾 Pet Hero

Pet Hero is a marketplace platform that connects pet owners with trusted sitters and walkers, so owners can find reliable caregivers to look after their pets while they're away.

Originally built as a final capstone project for the Software Engineering degree at Universidad Tecnológica Nacional (UTN), and later extended and re-presented for the professional practice defense.

Features
User accounts & roles — pet owners and pet keepers/sitters, with role-based access.
Pet profiles — owners can register their pets with type, size, and details.
Publications — keepers can publish their availability; owners can browse and search.
Bookings — request, confirm, and manage pet-sitting bookings.
In-app chat — messaging between owners and keepers tied to a booking.
Reviews — owners can rate and review keepers after a completed booking.
PDF generation — booking/receipt documents generated with Dompdf.
Email notifications — via PHPMailer.
Tech Stack
Backend: PHP (custom lightweight MVC — no framework)
Database: MySQL
Frontend: Server-rendered PHP views + jQuery
Architecture: Layered — Controllers → DAO (Data Access Objects, with interfaces) → MySQL, with custom exception classes per domain error case
Libraries: Dompdf (PDF generation), PHPMailer (email)
Project Structure
PetHero/
├── Config/          # App config, routing, DB connection settings
├── Controllers/      # Request handlers per resource (Booking, Chat, Pet, etc.)
├── DAO/               # Data access layer, one interface + implementation per entity
├── Exceptions/        # Domain-specific exception classes
├── Lib/                # Third-party libraries (Dompdf, PHPMailer)
└── Views/              # PHP views + static assets (js, css, images)
Getting Started
Prerequisites
PHP 7.4+ with the PDO MySQL extension
MySQL / MariaDB
Apache with mod_rewrite enabled (e.g. via XAMPP or Laragon)
Setup
Clone the repository into your local server's document root:
bash
   git clone https://github.com/nachoq22/Pet-Hero.git
Create a MySQL database (e.g. petHero) and import the schema:
bash
   mysql -u root -p petHero < PetHero/Config/DB/PetHero-DB.sql
Copy the example environment file and set your own local credentials:
bash
   cp PetHero/.env.example PetHero/.env

Then edit PetHero/.env with your local MySQL credentials:

   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=petHero
   DB_USER=root
   DB_PASS=your_password

.env is gitignored and never committed — each developer sets their own local credentials there. Config.php reads them automatically at runtime.

Point your Apache virtual host / document root to the PetHero/ folder and make sure .htaccess rewrite rules are enabled.
Open the app in your browser and you should see the Pet Hero home page.
Author

Built by Ignacio Ríos with Misael Flores as part of the UTN Software Engineering program.