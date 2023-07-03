# Invoice Api

The Invoicing REST Backend API is a PHP Laravel-based project that aims to provide a robust and efficient solution for managing and generating invoices. The API allows users to create and manage invoices, track inventory, and implement user authentication and authorization. For simplicity this api uses the basic authentication

## Documentation

See the [documentation](https://documenter.getpostman.com/view/21869124/2s93zCYL9M) for sample request and response


## Table of Contents

- [Project Description](#project-description)
- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Technologies Used](#technologies-used)


## Project Description

# Specifications

- **Invoice Management**: The API allows users to create invoices with issue and due dates, providing a convenient way to track payment deadlines and manage billing processes.

- **Customer Integration**: Each invoice is associated with a customer, enabling efficient tracking of client-specific transactions and facilitating easy retrieval of customer-related information.

- **Itemization**: Invoices can contain one or more items, allowing for detailed billing of products or services. Each item includes essential information such as unit price, quantity, amount, and description.

# Other Functionalities

- **Inventory Tracking**: The API includes features to prevent overselling by implementing item creation and inventory tracking. This ensures that the user cannot sell more items than are available in stock, thus helping maintain accurate inventory levels.

- **User Authentication and Authorization**: The API uses basic authentication to secure the endpointa


## Installation

1. Clone the repository.


## Usage

Switch to the repo folder

    cd to the project

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the customer factory to create dummy customers inside the database

    php artisan db:seed --class=CustomerSeeder

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

The api uses basic auth

    username: testuser password: testpassword


## Features

Main features.

You can have access to the API sample request and response at [API Documentation](https://documenter.getpostman.com/view/21869124/2s93zCYL9M).

- **Creating Invoice**
    - Method: POST
    - Endpoint: `/api/invoices`
    - Body: JSON

- **Updating Invoice**
    - Method: PUT
    - Endpoint: `/api/invoices/{id}`
    - Body: JSON

- **Get All Invoice**
    - Method: GET
    - Endpoint: `/api/invoices`
    - Body: None

- **Get Specific Invoice**
    - Method: GET
    - Endpoint: `/api/invoices/{id}`
    - Body: None

- **Delete Invoice**
    - Method: DELETE
    - Endpoint: `/api/invoices/{id}`
    - Body: None

**Request Body Definition**
| Key             | Definition |
| --------------- | --------------- |
| issue_date      | This field represents the date when the invoice was created |
| due_date        | This field represents the date when the invoice was completed |
| customer_id     | The ID of the customer |
| items           | An array containig at list one item |
| invoice_item_id | This field is used to track the same item. This is also used to reduce the item in the system to prevent over selling |
| unit_price      | This field represents the price of a single unit of an item |
| amount          | This field represents the total amount for a specific item on the invoice.|
| quantity        | This field represents the number of items for a particular order |
| description     | This field represents the description of the item |




## Technologies Used

- Laravel 8





