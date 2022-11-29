# PEDO BACKEND

Backend untuk aplikasi PEDO.

Aplikasi ini secara basis menggunakan library Eloquent ORM milik laravel [illuminate/database](https://github.com/illuminate/database)

## Installation

Install with git

```bash
  git clone https://github.com/aliftrd/pedo-backend.git
  cd pedo-backend
  composer install
```

    
## Usage/Examples

### Fetching Data

```php
<?php
require_once('../vendor/autoload.php');

use Models\User;

$user = User::get();
...

```

### Uploading File

```php
<?php
require_once('../vendor/autoload.php');

use Helper\Storage;

$file = Storage::upload($_FILES['name'], 'path/to/upload');
...

```

