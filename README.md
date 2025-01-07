## Live Demo
- **URL**: [https://coding-test.naz.sh/](https://coding-test.naz.sh/)

---

## Main Files and Features
#### Kindly refer to these files for the logic implementations of the coding tests.

### **1. Card Distribution Test**

#### **Backend Logic**
- **File**: [`CardController.php`](./app/Http/Controllers/CardController.php)
- **Description**: Contains the logic for distributing cards among participants.

#### **Frontend UI**
- **File**: [`CardDistributor.jsx`](./resources/js/components/CardDistributor.jsx)
- **Description**: React component that renders the UI for the card distribution test.

### **2. SQL Improvement Test**

#### **Backend Logic**
- **File**: [`QueryController.php`](./app/Http/Controllers/QueryController.php)
- **Description**: Implements two SQL queries (original and improved) to compare their performance and results.

#### **Frontend UI**
- **File**: [`SQLImprovement.jsx`](./resources/js/components/SQLImprovement.jsx)
- **Description**: React component for comparing SQL query performance and displaying results.

---

## Prerequisites

Ensure the following are available:
- Docker and Docker Compose (for Laravel Sail)
- Node.js and npm (for frontend setup)

---

## Setup Instructions

### 1. Install Dependencies
Use Laravel Sail to install PHP and Composer dependencies:
```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer install
```

### 2. Environment Configuration
Copy the `.env.example` file and configure the environment variables:
```bash
cp .env.example .env
```
Update the `.env` file with database credentials and other configurations.

### 3. Start Laravel Sail
Bring up the Sail environment:
```bash
./vendor/bin/sail up -d
```

### 4. Run Migrations
Run the database migrations to set up the schema:
```bash
./vendor/bin/sail artisan migrate
```

### 5. Run Seeder
Seed the `Jobs` table with sample data:
```bash
./vendor/bin/sail artisan db:seed --class=JobsSeeder
```
