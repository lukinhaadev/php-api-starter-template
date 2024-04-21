Docs available in [pt-BR](README-ptBR.md)

# PHP API Starter Template 💻

## Prerequisites 🛠️

- PHP installed on your machine. 🐘
- Composer installed on your machine. 📦
- Configured MySQL database. 🗄️
- Basic understanding of PHP programming. 🧠

## Dependency Installation 🚀

1. Clone the project or download the template to your local directory. 📂

2. Navigate to your project directory and run the following command to install the dependencies:

    ```bash
    composer install
    ```

3. This will install all dependencies listed in the `composer.json` file and ensure that you work with the exact versions specified in `composer.lock`. 🔒

## Environment Variables Configuration ⚙️

1. Locate the [.env.example](.env.example) file in the project directory. 🗂️

2. Rename the file to `.env`:

    Command prompt:
    ```cmd
    rename .env.example .env
    ```
    
    PowerShell:
    ```powershell
    mv .env.example .env
    ```

3. Open the `.env` file in a text editor and configure the environment variables as needed: 📝

    - **API Configuration:**
        - `API_HOST`: The address where the API will be executed (e.g. `localhost`). 🌐
        - `API_PORT`: The port on which the API will run (e.g. `8000`). 🔌
        - `TIMEZONE`: The application's time zone (for example, `America/Sao_Paulo`). 🕰️

    - **Database Configuration:**
        - `DB_HOST`: The address of the database server. 🏠
        - `DB_PORT`: The database server port. 🔌
        - `DB_USER`: The username to access the database. 👤
        - `DB_PASS`: The password to access the database. 🔑
        - `DB_NAME`: The name of the database. 🏷️

4. Save changes to the `.env` file. 💾

## Configuring DAO, Model and Controller 🛠️

### DAO (Data Access Object) 🗃️

1. Create a DAO class for each database entity (e.g. `UserDAO` for the `users` table). 👥

2. Implement methods for specific operations, such as `selectAll()`. 💼

3. Use the database connection to run SQL queries. 💻

#### Here is an example of UserDAO:

```php
<?php

namespace App\DAO;

class UserDAO extends DAO
{
    // Constructor to initialize the UserDAO object
    public function __construct()
    {
        // Call the parent class constructor (DAO) to initialize the database connection
        parent::__construct();
    }

    // Method to select all records from the "User" table
    public function selectAll()
    {
        // Definition of the SQL query to select all records from the "User" table
        $sql = "SELECT * FROM User";

        // Prepare SQL query using database connection
        $stmt = $this->conn->prepare($sql);

        // Execute the prepared query
        $stmt->execute();

        // Returns all query results as class objects (based on DAO class)
        return $stmt->fetchAll(DAO::FETCH_CLASS);
    }
}
```

### Model   

1. Create a Model class for each database entity (e.g. `UserModel`). 👤

2. Define attributes to represent the database table columns. 📊

3. Implement methods to interact with the DAO, such as `getAll()`. 🛠️

#### Here is an example UserModel:

```php
<?php

namespace App\Model;

use App\DAO\UserDAO;
use Exception;

class UserModel extends Model
{
    // Public attributes to represent the columns of the User table
    public $id, $name;

    // Method to get all records from the User table
    public function getAll()
    {
        try {
            // Create a UserDAO instance to access the data layer
            $dao = new UserDAO();
            // Call UserDAO selectAll() method to get all records
            // Results are stored in the $rows property
            $this->rows = $dao->selectAll();
        } catch (Exception $e) {
            // Throws an exception in case of error during execution
            throw $e;
        }
    }
}
```
### Controller ⚙️

1. Create a Controller class for each feature or set of functionality in your API (e.g. `UserController`). 💡

2. In the Controller, create methods to respond to specific HTTP requests, such as `GET`, `POST`, `PUT`, and `DELETE`. 📝

3. Call Model methods to process data received from requests and send appropriate responses to the client. 📨

#### Here is an example of a UserController:

```php
<?php

namespace App\Controller;

use App\Model\UserModel;

class UserController extends Controller
{
    // Static method that will be executed when the corresponding route is accessed
    public static function index(): void
    {
        // Create a new UserModel instance to access the model layer
        $model = new UserModel;
        
        // Call UserModel getAll() method to get all records
        $model->getAll();
        
        // Sends the response in JSON format containing the records obtained
        parent::sendJSONResponse($model->rows);
    }
}
```

## Registering api routes ↪️

1. Add the necessary routes in the [routes.php](App/routes.php) file:

```php
<?php
use App\Controller\UserController;
use App\Modules\HttpMethod;
use App\Modules\Router;

Router::request(HttpMethod::GET, "/users", [UserController::class, "index"]);
```

## Starting the Application 🏁

1. To start the application, run the following command in the project root directory:

    ```bash
    php api start
    ```

2. This will start the server at the address and port defined in `.env`.

## Testing the API   

1. Make HTTP requests to your API endpoints to verify that everything is working as expected. ✅

2. Use tools like Insomnia to send `GET`, `POST`, `PUT`, and `DELETE` requests. 📮

3. Check response to ensure data is processed correctly. ✔️