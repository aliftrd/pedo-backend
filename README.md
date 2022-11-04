# PEDO BACKEND

Backend untuk aplikasi PEDO


## Installation

Install with git

```bash
  git clone https://github.com/aliftrd/pedo-backend.git
  cd pedo-backend
  composer install
```

    
## Usage/Examples

Aplikasi ini secara basis menggunakan library Eloquent ORM milik laravel [illuminate/database](https://github.com/illuminate/database)
```php
<?php
require_once('../vendor/autoload.php');

use Models/User;

$user = User::get();
...

```

