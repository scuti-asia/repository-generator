# Scuti/repository-generator

# How to install

### Step 1: Install via composer

```php
composer require scuti/repository-generator
```

### Step 2: Publish repository-generator

```php
php artisan vendor:publish --provider="Scuti\Admin\RepositoryGenerator\AdminServiceProvider"
```

After that, if you see:
```
Copied Directory [/vendor/namdhgc/repository-generator/src/commands] To [/app/Console/Commands]
Copied Directory [/vendor/namdhgc/repository-generator/src/stubs] To [/resources/stubs]
```
That means your publishing is complete.

Now in folder `app/Console/Commands`, you can see file name **RepositoryGenerator.php**.
and in folder `resources`, you can see folder name **stubs**


### Step 3: Use command to generate Repository
```
php artisan make:repository NameOfRepository
```

This command will create:
- Request
- Controller
- Model
- BaseRepository
- RepositoryInterface
- EloquentRepository
