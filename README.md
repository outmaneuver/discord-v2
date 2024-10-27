# Discord V2

## Description
Discord V2 is a project that aims to create a clone of the popular communication platform, Discord. This project includes features such as server creation, joining servers, sending messages, and more.

## Installation
To install and run this project locally, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/outmaneuver/discord-v2.git
   ```
2. Navigate to the project directory:
   ```bash
   cd discord-v2
   ```
3. Install the necessary dependencies:
   ```bash
   composer install
   ```
4. Set up the database:
   - Create a new database in your MySQL server.
   - Import the `discord.sql` file located in the root directory of the project into your database.

5. Configure the database connection:
   - Open the `config/connection.php` file.
   - Update the database connection details (host, username, password, database name) to match your local environment.

6. Start the development server:
   ```bash
   php -S localhost:8000
   ```

7. Open your web browser and navigate to `http://localhost:8000` to access the application.

## Usage
Once the project is set up and running, you can use the following features:

- **Create an Account**: Sign up for a new account to start using the application.
- **Login**: Log in to your account to access your servers and messages.
- **Create a Server**: Create a new server to communicate with others.
- **Join a Server**: Join an existing server using a server link or code.
- **Send Messages**: Send messages to other members in the server.

## Contributing
Contributions are welcome! If you would like to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Make your changes and commit them:
   ```bash
   git commit -m "Add your commit message"
   ```
4. Push your changes to your forked repository:
   ```bash
   git push origin feature/your-feature-name
   ```
5. Open a pull request in the main repository, describing your changes and the feature or bug fix you have implemented.
