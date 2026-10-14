# ResLife

ResLife is a PHP-based student marketplace built for university communities to buy and sell second-hand items. The project allows students to register, browse listings, add products to a cart, complete checkout, sell their own items, and manage purchases through a simple dashboard.

## Overview

This application was designed as a campus marketplace where students can:

- Sign up and log in securely
- Browse items for sale
- View detailed product information
- Add items to a shopping cart
- Complete a checkout flow
- Sell their own goods
- Track orders and purchases in a dashboard
- Access an admin panel for moderation and order administration

## Features

- User authentication and registration
- Product catalog with item cards and detail pages
- Searchable / browsable shop pages
- Shopping cart and remove/add functionality
- Checkout and order processing
- User dashboard for listings and purchases
- Admin login and admin dashboard
- MySQL-backed data storage with seeded example records

## Tech Stack

- PHP
- MySQL / MariaDB
- HTML
- CSS
- JavaScript
- Apache (via XAMPP / WAMP / LAMP)

## Project Structure

- `index.php` – login/register landing page
- `homepage.php` – main storefront landing page
- `shop.php` – product browsing page
- `item.php` – item details page
- `sell.php` – form for listing a product
- `cart.php` – shopping cart page
- `process_checkout.php` – checkout processing logic
- `dashboard.php` – user dashboard
- `admin_login.php` – admin login screen
- `admin_dashboard.php` – admin management screen
- `connect.php` – database connection settings
- `mmconsul_reslife_db.sql` – database schema and sample data
- `images/` and `img/` – image assets
- `style.css` and `script.js` – shared styling and scripts

## Database Setup

1. Create a MySQL database named `mmconsul_reslife_db`.
2. Import the schema and sample data:

```bash
mysql -u root -p mmconsul_reslife_db < mmconsul_reslife_db.sql
```

3. Update the database credentials in `connect.php`:

```php
$servername = "localhost";
$username = "your_db_user";
$password = "your_db_password";
$database = "mmconsul_reslife_db";
```

## Local Installation

1. Install a PHP server stack such as XAMPP, WAMP, or LAMP.
2. Clone this repository into your server document root, e.g.:

```bash
git clone https://github.com/Lusa-M/reslife.git
```

3. Move the project folder into your local web server directory (for example `htdocs` in XAMPP).
4. Start Apache and MySQL.
5. Open the project in your browser:

```text
http://localhost/reslife
```

If your folder has a different name, adjust the URL accordingly.

## Admin Access

The project includes an admin table and an admin login page. After importing the database, you can log in from `admin_login.php` using the seeded admin account or create your own admin record in the `admin` table.

## Notes

- This project is intended for learning and academic/demo use.
- The codebase contains server-side PHP logic and direct database access patterns typical of a lightweight web application.
- For production deployment, consider security improvements such as password hashing, validation, prepared statements, and environment-based configuration.

## License

This project does not currently include a formal license file. If you plan to reuse it publicly, you should add an appropriate open-source license before distribution.

## Author

Built for a student marketplace / campus trading use case.
