# PEDO BACKEND

Backend untuk aplikasi PEDO.

Aplikasi ini secara basis menggunakan library Eloquent ORM milik laravel [illuminate/database](https://github.com/illuminate/database)

## Quick Start

#### Installation

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

### Storage

#### Upload File
When you upload a file it will return the encrypted file name.
```php
<?php
require_once('../vendor/autoload.php');

use Helper\Storage;

$file = Storage::upload($_FILES['name'], 'path/to/upload');
echo $file;

```


#### Delete File
When you delete a file, this function will return a boolean value

```php
<?php
require_once('../vendor/autoload.php');

use Helper\Storage;

Storage::delete('path/to/file', 'image.jpg');
...

```