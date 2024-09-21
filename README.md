# Loan Application API

This project provides a REST API for submitting loan applications. Users can submit loan requests, which are stored in a database.

## Requirements
- PHP 7.4 or higher
- Yii2 Framework
- Docker and Docker Compose (optional, for containerized environment)
- PostgreSQL

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/dkorablev14/loan-app.git
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up environment variables by copying `.env.example` to `.env` and configuring it for your setup.

## Docker Setup

1. Build and run containers:
    ```bash
    docker-compose up --d
    ```

2. Run migrations to set up the database:
    ```bash
    php yii migrate
    ```
   
## API Usage

### Create Loan
Endpoint: `POST loan/create`

Request body:
```json
{
  "user_id": 1,
  "amount": 3000,
  "term": 30
}
```

### Process Loans
Endpoint: `GET loan/processor?delay=5`
