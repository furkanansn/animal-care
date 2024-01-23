
# Animal Care README

## Introduction

This Laravel project serves as an API for a comprehensive system that manages various aspects of animal care, health, and community engagement. The API provides endpoints for handling diseases, donations, animals, medicines, operations, announcements, events, users, and more. Additionally, there are views designed for an admin interface to manage and visualize the data.

## Getting Started

To set up and run the project locally, follow the steps mentioned in the previous section. In addition to that, the admin views can be accessed by running the Laravel development server and navigating to the appropriate routes.

### Admin Views

The admin views are designed to provide a user-friendly interface for managing the application data. These views include functionalities such as creating and updating records, viewing lists of data, and interacting with various features.

To access the admin views:

1. Start the Laravel development server:

   ```bash
   php artisan serve
   ```

2. Open your web browser and navigate to the following routes:

   - **Animals Admin View**: `http://localhost:8000/admin/animals`
   - **Diseases Admin View**: `http://localhost:8000/admin/diseases`
   - **Donations Admin View**: `http://localhost:8000/admin/donations`
   - **Medicines Admin View**: `http://localhost:8000/admin/medicines`
   - **Operations Admin View**: `http://localhost:8000/admin/operations`
   - **Announcements Admin View**: `http://localhost:8000/admin/announcements`
   - **Events Admin View**: `http://localhost:8000/admin/events`
   - **Users Admin View**: `http://localhost:8000/admin/users`
   - **Sectors Admin View**: `http://localhost:8000/admin/sectors`
   - **Notices Admin View**: `http://localhost:8000/admin/notices`
   - **Databank Admin View**: `http://localhost:8000/admin/databank`
   - **Announcement Types Admin View**: `http://localhost:8000/admin/announcement-types`
   - **Animal Kinds Admin View**: `http://localhost:8000/admin/animal-kinds`
   - **Cities Admin View**: `http://localhost:8000/admin/cities`

## Laravel Mix Scripts

- **Development**: `npm run development`
- **Watch**: `npm run watch`
- **Watch with Polling**: `npm run watch-poll`
- **Hot Module Replacement (HMR)**: `npm run hot`
- **Production**: `npm run production`

## Dependencies

### PHP

- `edwinhoksberg/php-fcm`: Firebase Cloud Messaging library.
- `fideloper/proxy`: Trusted proxy package.
- `fruitcake/laravel-cors`: CORS (Cross-Origin Resource Sharing) handling.
- `guzzlehttp/guzzle`: HTTP client library.
- `laravel/framework`: Laravel framework.
- `laravel/passport`: Laravel Passport for API authentication.
- `laravel/tinker`: Laravel REPL.
- `league/flysystem-aws-s3-v3`: Flysystem adapter for AWS S3.
- `simplesoftwareio/simple-qrcode`: QR code generator.
- `spatie/laravel-html`: HTML and Form builder.
- `twilio/sdk`: Twilio SDK for integration.
- ...

### NPM

- `axios`: Promise-based HTTP client.
- `laravel-mix`: Asset compilation for Laravel.
- `lodash`: JavaScript utility library.
- `postcss`: CSS post-processor.
- `izitoast`: Toast notifications library.
- ...

## Development Tools

- `facade/ignition`: Laravel error page for debugging.
- `fakerphp/faker`: PHP library for generating fake data.
- `knuckleswtf/scribe`: API documentation generator.
- `twilio/sdk`: Twilio API client library.
- ...

## API Routes

### Authentication

- `POST /v1/auth/register`: Register a new user.
- `POST /v1/auth/login`: Log in a user.
- `POST /v1/auth/approve`: Approve a user.
- `POST /v1/auth/forget-password`: Initiate forget password process.
- `POST /v1/auth/reset-password`: Reset user password.
- `POST /v1/auth/deleteAccount`: Delete user account.
- `DELETE /v1/auth/logout`: Log out a user.

### Animals

- `GET /v1/animals`: Get a list of animals.
- `GET /v1/animals/get/{id}`: Get details of a specific animal.
- `POST /v1/animals/create`: Create a new animal.
- `POST /v1/animals/update/{id}`: Update an existing animal.
- `DELETE /v1/animals/delete/{id}`: Delete an animal.
- `GET /v1/animals/show`: Show photos of animals.
- `GET /v1/animals/qr/{id}`: Get QR code for an animal.
- `GET /v1/animals/getAnimal/{uuid}`: Get animal by UUID.

### Animal Kinds

- `GET /v1/animal-kinds`: Get a list of animal kinds.
- `GET /v1/animal-kinds/{id}`: Get details of a specific animal kind.

### Cities

- `GET /v1/cities`: Get a list of cities.
- `GET /v1/cities/ilce/{id}`: Get districts of a city.
- `GET /v1/cities/mahalle/{id}`: Get neighborhoods of a district.
- `GET /v1/cities/sokak/{id}`: Get streets of a neighborhood.

### Notices

- `GET /v1/notices`: Get a list of notices.
- `GET /v1/notices/get/{id}`: Get details of a specific notice.
- `GET /v1/notices/my-notices`: Get notices of the authenticated user.
- `POST /v1/notices/agree`: Agree to a notice.
- `POST /v1/notices/create`: Create a new notice.
- `POST /v1/notices/update/{id}`: Update an existing notice.
- `DELETE /v1/notices/delete/{id}`: Delete a notice.

### Sectors

- `GET /v1/sectors`: Get a list of sectors.
- `GET /v1/sectors/get/{id}`: Get details of a specific sector.
- `POST /v1/sectors/create`: Create a new sector.
- `POST /v1/sectors/update/{id}`: Update an existing sector.
- `DELETE /v1/sectors/delete/{id}`: Delete a sector.

### Users

- `GET /v1/users`: Get a list of users.
- `GET /v1/users/get/{id}`: Get details of a specific user.
- `POST /v1/users/update/{id}`: Update an existing user.
- `DELETE /v1/users/delete/{id}`: Delete a user.

### Events

- `GET /v1/events`: Get a list of events.
- `GET /v1/events

/get/{id}`: Get details of a specific event.

### Databank

- `GET /v1/databank`: Get a list of databank records.
- `GET /v1/databank/get/{id}`: Get details of a specific databank record.

### Databank Categories

- `GET /v1/categories`: Get a list of databank categories.

### Announcements

- `GET /v1/announcements`: Get a list of announcements.
- `GET /v1/announcements/get/{id}`: Get details of a specific announcement.
- `POST /v1/announcements/create`: Create a new announcement.
- `POST /v1/announcements/update/{id}`: Update an existing announcement.
- `DELETE /v1/announcements/delete/{id}`: Delete an announcement.

### Announcement Types

- `GET /v1/announcements/type`: Get a list of announcement types.
- `GET /v1/announcements/type/get/{id}`: Get details of a specific announcement type.

### Diseases

- `GET /v1/diseases`: Get a list of diseases.
- `GET /v1/diseases/get/{id}`: Get details of a specific disease.

### Operations

- `GET /v1/operations`: Get a list of operations.
- `GET /v1/operations/get/{id}`: Get details of a specific operation.

### Medicines

- `GET /v1/medicines`: Get a list of medicines.
- `GET /v1/medicines/get/{id}`: Get details of a specific medicine.

### Home

- `GET /v1/home`: Get the home data.

### Donations

- `GET /v1/donations/get/{id}`: Get details of a specific donation.
- `POST /v1/donations/create`: Create a new donation.
