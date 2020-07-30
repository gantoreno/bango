<p align="center">
    <img src="assets/svg/banner.svg" height="75">
</p>

## Disclaimer

Bango is a PHP experiment created as a university project of a student (me). It was created within a week, please note that this is not a production-ready framework, there are several security flaws and issues that must be solved before making it available as stable code.

## About Bango

With Bango, there are zero-tricks; it's just you, and PHP. Bango is the lightweight MVC framework that will allow you to create outstanding web applications with almost no effort and vanilla PHP, thanks to its expressive and elegant syntax, and its carefully designed library of components, such as:

-   Fast routing engine.
-   Easy file manipulation.
-   Instant access to environment variables.
-   Total HTTP control.
-   Zero-pain controller declaration.
-   Simple authentication system.
-   Accessible database query system.

## Usage

Since Bango works with the MVC design pattern, new integration of custom elements is straightforward.

To see all of Bango's capabilities, take a look inside the `vendor/Bango` directory, and go through each class to see how they work.

To get started, simply clone this directory. Since [v0.1.1](https://github.com/hollandsgabe/bango/releases/tag/v0.1.1) Bango supports [Docker](https://www.docker.com/), you can get it up and running through the `Makefile`:

```sh
$ make # Or "make start" to start the project
$ make migrate # To run the migrations
```

### Environment variables

In order for Bango to use certain services (such as MySQL/MariaDB databases), you'll need to store your credentials inside the `.env` file. Since it's not commited, rename the `.env.example` to `.env` and place your credentials on each field. Feel free to add more if you need them, you can reference a specific key-value pair using the `Bango\Environment` class, for example:

```php
use \Bango\Environment;

Environment::readEnv("JWT_SECRET");
```

### Routes

To register a new route group, create a new file under the `routes` directory, or declare the routes inside one of the existing files. To associate a route with a controller's method, inside your route file, use the `Route::get/post/put/delete` method (and remember to use the `Bango\Router` class):

```php
use \Bango\Router;

Route::get("/about", "AboutController::index");
```

### Controllers

Creating a controller is simple and easy, only place a new file under the `controllers` directory, following the pattern of `<controllername>Controller.php` (for example, `HomeController.php`, using PascalCase), extend the `Controller` class (remember to include it from the `Bango` namespace), and create your methods inside. As convention, if the controller is intended to render a view, you'll create an `index` method, calling `self::createView` inside.

Inside `AboutController.php`:

```php
use \Bango\Controller;

class About extends Controller {
    // ...

    /**
     * Serve a given view as entry point.
     *
     * @return void
     */
    public static function index()
    {
        self::createView("about.view");
    }

    // ...
}
```

### Views

Views are available under the `views` directory, to get a new view up and running, create a new file with the name of the view, ending with the extension `.view.php`, and whenever you want to render it, you can send the view inside your controller by calling:

```php
$name = "Gabriel";
$age = 19;
$gender = "M";

self::createView('<viewname>.view', [
    "person" => new Person($name, $age, $gender)
]);
```

Notice how an associative array gets passed to the view, this will make the content of the array available as global variables inside the view.

To access variables inside the view, simply use the PHP classic tags:

```xml
<!-- ... -->

<div class="profile">
    <?php foreach($person as $key => $value): ?>
        <div class="<?= $key ?>">
            <?=  $value ?>
        </div>
    <?php endif ?>
</div>

<!-- ... -->
```

This will result in:

```html
<!-- ... -->

<div class="profile">
    <div class="name">Gabriel</div>
    <div class="age">19</div>
    <div class="gender">M</div>
</div>

<!-- ... -->
```

### Static assets

To access a static asset, simply use the `href` attribute referencing the `assets` folder, and the file location within it (be careful with file extensions!).

### Models

Models are placed inside the `models` directory, to create a new model, make a new file (following the naming convention).

Take a look at the `User` model:

```php
use \Bango\Model;

class User extends Model
{

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bindEntity("users");
        $this->createFields([
            "id" => "integer", 
            "email" => "string", 
            "password" => "string"
        ]);
    }
}
```

It's necessary to use the `bindEntity` method, since that registers the database table to which the model belongs (NOTE: The table must exist). And the `createFields` has to describe all the fields inside the table, making sure that types match (`integer` for `INT`, `string` for `VARCHAR`, etc).

After that, the model is available to use. To create a new model object you can do the following:

```php
$user = new User();

$user->email = "john@doe.com";
$user->password = password_hash("johnisawesome", PASSWORD_DEFAULT);

if ($user->save()) {
    // ...
}
```

The `save` method will save the information to the database, always make sure to check the return value. To find a current database object (or many), the following methods are available:

```php
$all_users = User::all(); // Retrieve all entries
$single_user = User::where("id", "=", 1)->one(); // Get a single entry
$filtered_users = User::where("id", ">", 3)->all(); // Get all the entries that fit the criteria
```

To update a model's data, or delete it, you can use the `update` and `delete` methods, as the following:

```php
$user = User::where("email", "=", "john@doe.com");

$user->email = "info@johndoe.com";
$user->password = password_hash("johnisstillawesome", PASSWORD_DEFAULT);

if ($user->update()) {
    // ...
}

// Or, if you want to delete it

if ($user->delete()) {
    // ...
}
```

Again, make sure to check the return values to see if changes were successful.

All the models will be available throughout the app thanks to the `config/autoload.php` function.

### Migrations

With bango, creating a migration is fairly straightforward. All you have to do is place your SQL queries inside the `database/migration.sql`.

```sql
-- ...

CREATE DATABASE bango;

USE bango;

CREATE TABLE users (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, email VARCHAR(128) UNIQUE NOT NULL, password VARCHAR(128) NOT NULL);

-- ...
```

To run the migrations, open a command shell and type the following:

```sh
$ php bango migrate
```

If everything went ok, you should receive back a `Migration successful` message.

## Security Vulnerabilities

If you discover a security vulnerability within Bango, please send an e-mail to Gabriel Moreno via [gamoreno@urbe.edu.ve](mailto:gamoreno@urbe.edu.ve). All security vulnerabilities will be promptly addressed.

## License

The Bango framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
