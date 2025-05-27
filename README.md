# CityCitizenAnalytics

A Laravel web application developed as part of a collaborative academic practice for the *Web Design & E-Commerce* course. It implements a MVC architecture with Eloquent ORM, Blade views, and email reporting functionality via SMTP. The app lets users:

- Track, create, update and delete cities and citizens  
- View citizen counts across cities and other key metrics on a dashboard
- Browse citizens grouped by city
- Send and receive a citizens-by-city report via email with a single click

---

## Features (Functional Requirements)

1. **Dashboard:**  
   - **Card 1:** Shows the total number of cities  
   - **Card 2:** Shows the total number of citizens  
   - **Card 3:** Displays a horizontal bar chart showing the number of citizens per city in ascending order

2. **Grouped View:**  
   - Displays citizens organized by city in a table  
   - Sorts cities alphabetically  
   - Provides a search bar to filter by citizen name or city  

3. **Email Reporting:**  
   - Adds a navigation button that, when clicked, sends an email containing the citizens-by-city report
   
---

## Team & Responsibilities

Development was split into feature branches, one per team member, as follows:

- **[Cristian Gago](https://github.com/Criqua)** – `feature/dashboard-cards`  
Built the dashboard's key metric cards and integrated bar chart component; led the integration of feature branches into `develop` for testing.

- **[Manuel López](https://github.com/ElVatoEste)** – `feature/citizens_grouped_view`  
  Created the grouped-by-city table view *(citizen's index.blade.php)* and implemented the search/filter logic.

- **[María Aguilar](https://github.com/mabelenaa)** – `feature/email-report`  
  Defined the `Mailable` class, designed the email Blade view template, and configured the mailing logic.

---

## Git Workflow

To summarize:
1. Every new feature lives in its own **feature/** branch
2. All feature branches are merged into `develop` for integration testing
3. Once `develop` is stable, it's merged into `main` for "release"

---

## Quick Setup

> **Note:** This project requires **PHP 8.4.x** to meet the version constraints of Laravel 10+ and its ecosystem packages. If that's already settled, run the following commands in your terminal:

    git clone https://github.com/Criqua/CityCitizenAnalytics.git
    cd CityCitizenAnalytics
    composer install
    cp .env.example .env
    php artisan key:generate

> Then, you need to set up **SMTP (Gmail)**. To do so, open .env, locate the mail settings and replace it with your credentials (from line 51 to line 58).

    php artisan migrate
    npm install
    npm run build
    php artisan serve

---

You're all set!

