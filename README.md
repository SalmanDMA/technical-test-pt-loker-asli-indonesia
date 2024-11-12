<h1 align="center" style="font-size: 32px; font-weight: 800;"> Transaksi Approval </h1> <br>

<p align="center" style="font-size: 20px; font-weight: 400;">
  "Transaksi Approval is a robust platform designed for managing approval processes for transactions and expenses, providing structured stages, approvers, and clear documentation."
</p>

 <p align='center' style="font-size: 16px; font-weight: 400;"> Reach Me On :</p>
 
  <p align='center'>
  <a href="https://bit.ly/my-portofolio-salmandma">
    <img src="https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white" alt="portfolio">
  </a>
  <a href="https://www.linkedin.com/in/salmandma/">
    <img src="https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white" alt="linkedin">
  </a>
  <a href="https://www.instagram.com/_slmndma_/">
    <img src="https://img.shields.io/badge/instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white" alt="instagram">
  </a>
  <a href="https://github.com/SalmanDMA">
    <img src="https://img.shields.io/badge/github-181717?style=for-the-badge&logo=github&logoColor=white" alt="github">
  </a>
</p>

## Table of Contents

-   [Introduction](#introduction)
-   [Features](#features)
-   [Technologies](#technologies)
-   [Installation](#installation)
-   [Endpoints](#endpoints)
-   [Testing](#testing)
-   [Contributors](#contributors)

## Introduction

[![On Process](https://img.shields.io/badge/build-on_process-blue)](https://github.com/SalmanDMA/alternatif-blog-api)
[![All Contributors](https://img.shields.io/badge/all_contributors-1-orange.svg?style=flat-square)](#contributors-)

Transaksi Approval is a REST API built to streamline and manage expense transaction approvals through a multi-level approval workflow. Each transaction must be approved by designated approvers in a set sequence, ensuring that only authorized personnel at the correct stage can provide approval. This system is ideal for organizations that need a structured, compliant, and controlled approach to expense approvals.

## Features

-   `Staged Approval Process:` Approvals must follow a defined sequence of stages. For instance, an expense may need approval from Approver A, then B, and finally C.

-   `Role-Based Approval Access:` Each stage can only be approved by the assigned approver. For example, Approver B cannot approve a transaction until Approver A has approved it.

-   `Approval Tracking:` The system ensures that each approval is recorded in the correct order, providing an audit trail for compliance and transparency.

## Technologies

-   Laravel 11 - Backend framework
-   PHPUnit - Unit testing
-   Swagger (L5-Swagger by DarkaOnline) - API documentation

## Installation

1. Clone Repository:

```bash
 git clone https://github.com/SalmanDMA/technical-test-pt-loker-asli-indonesia.git
```

2. Go to Directory:

```bash
 cd <your-repo>
```

3. Install Dependensi:

```bash
 composer install
```

4. Set Up Environment Variables:

    - Copy the .env.example file to create your .env file and update the necessary database settings:

    - Example:

```bash
 DB_CONNECTION=mysql
 DB_HOST=172.29.62.114
 DB_PORT=3306
 DB_DATABASE=transaksi_approval
 DB_USERNAME=username
 DB_PASSWORD=@Password123
```

5. Migrate the Database:

```bash
 php artisan migrate
```

6. Seed Database ( for status ):

```bash
 php artisan db:seed
```

7. Generate Swagger Documentation:

```bash
 php artisan l5-swagger:generate
```

8. Run Application:

```bash
 php artisan serve
```

## Endpoints

Here is a list of primary API endpoints for Transaksi Approval:

-   Approvers

    -   `POST /api/approvers` - Add a new approver

-   Approval Stages

    -   `POST /api/approval-stages` - Create a new approval stage
    -   `PUT /api/approval-stages/{id}` - Update an existing approval stage

-   Expenses
    -   `POST /api/expenses` - Create a new expense
    -   `PATCH /api/expenses/{id}/approve` - Approve an expense
    -   `GET /api/expenses/{id}` - View details of an expense

For full API documentation, refer to the Swagger UI available after running the project at http://localhost:8000/api/documentation.

## Testing

Unit tests are written using PHPUnit to ensure the reliability of the codebase. To run the tests:

```bash
 php artisan test
```

## Contributors

This project is created by [Salman DMA](https://github.com/SALMANDMA).
