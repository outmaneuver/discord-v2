# Discord v2

Discord v2 is a web-based application that allows users to create and join servers, communicate with other members, and manage server settings. This project is built using PHP and MySQL.

## Features

- User authentication (sign up, login, logout)
- Create and join servers
- Manage server settings
- Invite members to servers
- Send and receive messages within servers

## Installation

1. Clone the repository:

```bash
git clone https://github.com/Xann15/discord-v2.git
```

2. Navigate to the project directory:

```bash
cd discord-v2
```

3. Set up the database:

- Create a new MySQL database.
- Import the `discord.sql` file located in the root directory of the project into your MySQL database.

4. Configure the database connection:

- Open the `config/connection.php` file.
- Update the database connection details (host, username, password, database name) to match your MySQL configuration.

5. Start the development server:

- If you are using a local development environment like XAMPP or WAMP, place the project directory in the `htdocs` or `www` folder.
- Start the Apache and MySQL services.
- Open your web browser and navigate to `http://localhost/discord-v2`.

## Usage

1. Sign up for a new account or log in with an existing account.
2. Create a new server or join an existing server using an invitation link or code.
3. Manage server settings, invite members, and communicate with other members within the server.

## Examples

### Creating a New Server

1. Click on the "Servers" dropdown menu and select "Create Server".
2. Fill in the server name, description, and visibility settings.
3. Click the "Create" button to create the server.

### Joining a Server

1. Click on the "Servers" dropdown menu and select "Join Server".
2. Enter the invitation link or code provided by the server owner.
3. Click the "Join" button to join the server.

### Sending a Message

1. Navigate to the server you want to send a message in.
2. Type your message in the message input box.
3. Press the "Enter" key or click the "Send" button to send the message.
