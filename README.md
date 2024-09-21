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
    git clone https://github.com/yourname/loan-app-api.git
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up environment variables by copying `.env.example` to `.env` and configuring it for your setup.

## Docker Setup

1. Build and run containers:
    ```bash
    docker-compose up --build
    ```

2. Run migrations to set up the database:
    ```bash
    php yii migrate
    ```
   
## API Usage

### Submit Loan Request
Endpoint: `POST /requests`

Request body:
```json
{
  "user_id": 1,
  "amount": 3000,
  "term": 30
}
