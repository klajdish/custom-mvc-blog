# Custom MVC Blog Project

This repository contains a custom Model-View-Controller (MVC) architecture implementation in PHP for a blog project. The MVC pattern provides a structured approach to building web applications by separating the application logic into three interconnected components: the model, the view, and the controller. Additionally, the project incorporates the Singleton design pattern for certain classes and includes middleware functionality.


## Features

- User registration and login functionality
- Viewing blog posts and comments
- Adding comments to blog posts
- Admin dashboard for managing the site
- CRUD operations for managing blog posts, comments, and user accounts
- Middleware functionality for handling HTTP request filtering and preprocessing
- Pagination functionality for splitting large result sets into manageable pages
- Search functionality to find specific blog posts or comments

## Requirements

To run this project, ensure that your system meets the following requirements:

- PHP 7.4 or above
- MySQL 5.7 or above
- Web server (Apache or Nginx)


## Project Structure

The project follows a directory structure that adheres to the MVC pattern:

- `controllers/`: Contains the controller classes responsible for handling requests and interacting with the model and view.
- `models/`: Contains the model classes that handle data manipulation and database operations.
- `views/`: Contains the view files responsible for rendering the HTML templates.
- `core/`: Contains the core classes and vendor logic where base classes are implemented.
- `middleware/`: Contains the middleware classes for handling HTTP request filtering and preprocessing.

Additional files and directories:

- `index.php`: Acts as the entry point to the application and handles the routing of requests to the appropriate controller.
