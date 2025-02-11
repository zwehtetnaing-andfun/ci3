### 1. Allow Dynamic Properties in Core Classes

Add `#[\AllowDynamicProperties]` above the class definitions in the following files:

#### Files:

-   `system/core/URI.php` - CI_URI class
    
-   `system/core/Router.php` - CI_Router class
    
-   `system/core/Controller.php` - CI_Controller class
    
-   `system/core/Loader.php` - CI_Loader class
    
-   `system/database/DB_driver.php` - CI_DB_driver class
    

#### Example for `CI_URI` in `system/core/URI.php`:

  

```php
#[\AllowDynamicProperties]

class CI_URI {

// Class code

}
```
  

Repeat for other classes mentioned.

  

### 2. Suppress Return Type Warnings in Session Driver

Add `#[\ReturnTypeWillChange]` above the following functions in `system/libraries/Session/drivers/Session_files_driver.php`:

#### Functions:

-   `open()`
    
-   `read()`
    
-   `write()`
    
-   `close()`
    
-   `destroy()`
    
-   `gc()`
    

#### Example for open():

  
```php
#[\ReturnTypeWillChange]

public function open($save_path, $name) {

// Function code

}
```
  

Repeat for other functions listed.

  
  

### 3. Remove index.php from URL

****1.  Create a .htaccess file in your project’s root directory.****
    
****2.  Add the following code:****
    

```markdown  
<IfModule mod_rewrite.c>

RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f

RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.*)$ index.php/$1 [L]

</IfModule>
```
  
  

****3.  Explanation:****
    

-   Enables URL rewriting.
    
-   Redirects requests without `index.php` to `index.php`.
    

****5.  Save the file and test by visiting `URLs` without `index.php`. Ensure `mod_rewrite` is enabled on your server.****
    

  

### Configuration - config.php

#### File Location:

`application/config/config.php`

----------

### Base URL Configuration:

Set your base URL in the config file:

  
```php
$config['base_url'] = 'http://localhost/project-ci3'; // Set your project URL here
```
  

This defines the base URL for the application.

  
  ----
  
  

### Database Setup & Migrations

#### 1. Database Configuration:

-   Edit the `application/config/database.php` file to configure your database connection:
    
```php
$db['default'] = array(

'dsn' => '',

'hostname' => 'localhost',

'username' => 'root',

'password' => '',

'database' => 'simple_project', // have to already create in your database

'dbdriver' => 'mysqli',

// Other configurations as needed

);
```
  
  
  

#### 2. Migrate Database Table:

-   In CI3, You have to migrate tables manually.
    
-   Open your command prompt and run the following MySQL command to create the articles table:
    

```bash
mysql -u root -p
```
  

-   Once inside MySQL, run this query to create the table:
    
```sql
CREATE TABLE IF NOT EXISTS articles (

id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,

title VARCHAR(50) NOT NULL,

content TEXT,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);
```
  
  
  ---
  
  
  

## Model Creation

#### 1. Create the Model File:

-   Location: application/models
    
-   Naming Convention: Model name must be capitalized and end with `_model`. Example: `Article_model`.
    

#### 2. Model Structure:

```php
<?php

class Article_model extends CI_Model {

public $title; // Declare model properties

public $content;

public $created_at;

public $updated_at;

  

// Constructor: Load the database

public function __construct() {

$this->load->database();

}

  

// Get all articles

public function get_all_articles() {

$query = $this->db->get('articles');

return $query->result_array(); // Return as an array

}

  

// Get article by ID

public function get_article_by_id($id) {

$this->db->where('id', $id);

$query = $this->db->get('articles');

return $query->row_array(); // Return single row as array

}

  

// Insert a new article

public function insert_article($data) {

$this->title = $data['title'];

$this->content = $data['content'];

$this->db->insert('articles', $this); // Insert article into DB

}

  

// Update an article

public function update_article($data) {

$this->title = $data['title'];

$this->content = $data['content'];

$this->db->update('articles', $this, array('id' => $data['id'])); // Update article

}

  

// Delete an article

public function delete_article($id) {

$this->db->delete('articles', array('id' => $id)); // Delete article by ID

}

}
```
  ---

### Controller Creation Documentation

#### 1. Create the Controller File:

-   Location: `application/controllers`
    

#### 2. Controller Structure:

```php
<?php

class Article extends CI_Controller {

  

// Constructor: Load necessary models and helpers

public function __construct() {

parent::__construct();

$this->load->model('article_model', 'Article'); // Load model as 'Article'

$this->load->helper('url_helper'); // Load URL helper

$this->load->helper('form'); // Load form helper

}

  

// Display all articles

public function index() {

$data['page_title'] = 'Article';

$data['articles'] = $this->Article->get_all_articles(); // Fetch articles from model

$this->load->view('layouts/header', $data); // Load header view

$this->load->view('articles/index', $data); // Load articles index view

$this->load->view('layouts/footer'); // Load footer view

}

  

// Show the create article form

public function create() {

$data['page_title'] = 'Create new article';

$this->load->view('layouts/header', $data); // Load header

$this->load->view('articles/create'); // Load create form view

$this->load->view('layouts/footer'); // Load footer

}

  

// Store new article data

public function store() {

$data['title'] = $this->input->post('title'); // Get title from form

$data['content'] = $this->input->post('content'); // Get content from form

$this->Article->insert_article($data); // Insert article via model

redirect('/article'); // Redirect to article index

}

  

// Show the edit form for a specific article

public function edit($id) {

$data['page_title'] = 'Edit article';

$data['article'] = $this->Article->get_article_by_id($id); // Get article by ID

$this->load->view('layouts/header', $data); // Load header

$this->load->view('articles/edit', $data); // Load edit form view

$this->load->view('layouts/footer'); // Load footer

}

  

// Update an existing article

public function update($id) {

$data['id'] = $id;

$data['title'] = $this->input->post('title');

$data['content'] = $this->input->post('content');

$this->Article->update_article($data); // Update article via model

redirect('/article'); // Redirect to article index

}

  

// Delete an article

public function delete($id) {

$this->Article->delete_article($id); // Delete article via model

redirect('/article'); // Redirect to article index

}

}
```
  
  ---

### Route Configuration

#### 1. Location:

-   File: `application/config/routes.php`
    

#### 2. Routing Syntax:

Define routes by mapping URL patterns to controller methods.

```php
$routes['/controller/method/(:num)'] = 'controller/method/argument';
```
  

Where `(:num)` is a placeholder for a numeric value , which will be passed as an argument to the controller method.

`(:num)` : numeric value

`(:any`) : any characters

  

#### 3. Example Routes:

```php
$route['/article'] = 'article/index'; // Display the index page of articles

$route['/article/create'] = 'article/create'; // Show the article creation page

$route['/article/store'] = 'article/store'; // Post data to store a new article

$route['/article/edit/(:num)'] = 'article/edit/$1'; // Show the edit page for a specific article

$route['/article/store/(:num)'] = 'article/store/$1'; // Post data to update a specific article

$route['/article/delete/(:num)'] = 'article/delete/$1'; // Delete a specific article
```
  

### View Creation Documentation

#### 1. Location:

-   File Path: `application/views`
    

#### 2. Layouts:

`layouts/header.php`: This file contains the HTML head section, including the page title and meta tags.

```html
<!doctype html>

<html lang="en">

<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= $page_title ?></title>

</head>

<body>
```
  

-   Purpose: Set page title dynamically (`$page_title`) and include basic metadata.
    
    

`layouts/footer.php`: This file contains the closing body and HTML tags along with any footer content.
```html
<footer><em>&copy; 2025</em></footer>

<script src="app.js"></script> <!-- JS file -->

</body>

</html>
```
  

-   Purpose: Close the body and HTML tags, and load any necessary JavaScript files.
    

----------

#### 3. Index Page (`index.php`):

Displays a list of all articles with options to edit or delete.

  
```php
<div class="container">

<div class="row">

<div class="col-md-12 my-5 d-flex justify-content-between align-items-center">

<h2>Articles</h2>

<a href="<?= base_url('article/create') ?>" class="btn btn-primary">Create</a>

</div>

<?php foreach($articles as $article): ?>

<div class="col-md-8 mx-auto card mb-2">

<div class="card-header">

<h5><?= $article['title']; ?></h5>

</div>

<div class="card-body">

<p class="text-muted"><?= $article['content']; ?></p>

</div>

<div class="card-footer d-flex justify-content-end gap-2">

<a href="<?= base_url('article/edit')."/".$article['id'] ?>" class="btn btn-success btn-sm">Edit</a>

<a href="<?= base_url('article/delete')."/".$article['id'] ?>" class="btn btn-danger btn-sm">Delete</a>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

 ```

-   Purpose: Displays articles dynamically and provides links for editing and deleting.
    
-   Notes: `base_url()` dynamically links to the proper URLs based on the base URL configuration.
    

----------

#### 4. Create Page (`create.php`):

Displays the form to create a new article.

```php
<div class="container">

<div class="row">

<div class="col-md-8 card mx-auto my-5">

<div class="card-header">

<h5>Create Article</h5>

</div>

<div class="card-body">

<?= form_open('article/store'); ?> <!-- Form to store article -->

  

<div class="form-group mb-2">

<label for="title">Title</label>

<input type="input" name="title" class="form-control form-control-sm">

</div>

  

<div class="form-group mb-2">

<label for="content">Content</label>

<textarea name="content" class="form-control form-control-sm" cols="45" rows="4"></textarea>

</div>

  

<button type="submit" class="btn btn-primary">Submit</button>

</form>

</div>

</div>

</div>

</div>
```
  

-   Purpose: Display the form for creating an article, submitting data to store method.
    

----------

#### 5. Edit Page (`edit.php`):

Displays the form to edit an existing article.

  
```php
<div class="container">

<div class="row">

<div class="col-md-8 card mx-auto my-5">

<div class="card-header">

<h5>Edit Article</h5>

</div>

<div class="card-body">

<?= form_open('article/update/'.$article['id']); ?> <!-- Form to update article -->

  

<div class="form-group mb-2">

<label for="title">Title</label>

<input type="input" name="title" class="form-control form-control-sm" value="<?= $article['title'] ?>">

</div>

  

<div class="form-group mb-2">

<label for="content">Content</label>

<textarea name="content" class="form-control form-control-sm" cols="45" rows="4"><?= $article['content'] ?></textarea>

</div>

  

<button type="submit" class="btn btn-primary">Submit</button>

</form>

</div>

</div>

</div>

</div>
```
  

-   Purpose: Display the form with pre-filled data for editing the article, submitting data to update method.
    

----------

#### 6. Notes:

-   Form Helper: `form_open()` is used to open the form with the specified action.
    
-   Dynamic Content: Data like `$article['title']` and `$article['content']` are dynamically populated from the controller.
    
-   Base URL: The `base_url()` helper function ensures proper URL routing based on the configuration.
