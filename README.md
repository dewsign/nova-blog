# Blogging module for Laravel Nova

Easily add a Blog with Articles and Categories in Nova using repeaters blocks for content. See documentation for [Repeater Blocks](https://github.com/dewsign/nova-repeater-blocks) for details.

## Installation

`composer require dewsign\nova-blog`

Run the migrations

```sh
php artisan migrate
```

Load the tool in your NovaServiceProvider.php

```php
public function tools()
{
    return [
        ...
        new \Dewsign\NovaBlog\Nova\NovaBlogTool,
        ...
    ];
}
```

## Templates

The packages doesn't come with any pre-made templates. Simply replace the published views.

## Configuration

### Repeaters

Add additional repeater blocks by adding it to the nova blog config

```php
'repeaters' => [
    'More\Repeaters'
],
```

Or remove all standard repeaters and use your own selection.

```php
'replaceRepeaters' => true,
```

### Customisation

If you want more control, you can specify which Nova Resources and Models to use. Because of the way nova reads the model from a static variable you must provide your own custom resource if you want to use a custom model.

```php
'models' => [
    'article' => 'App\Article',
],
'resources' => [
    'article' => 'App\Nova\Article',
],
```

### Nova Resource Group

```php
'group' => 'Blog',
```

You can customise the nova resource group.

## Routing

Blog, category and article routing is all included under the `/blog` slug.

## Factories & Seeders

The package comes with pre-made factories and seeders. Should you wish to include them in your application simply call the seeder or use the factory provided.

```php
// database/seeds/DatabaseSeeder.php

public function run()
{
    $this->call(Dewsign\NovaBlog\Database\Seeds\CategorySeeder::class);
    $this->call(Dewsign\NovaBlog\Database\Seeds\ArticleSeeder::class);
}
```

## Permissions

A BlogPolicy is included, but not loaded by default, for [Brandenburg](https://github.com/Silvanite/brandenburg) / [Nova Tool](https://github.com/Silvanite/novatoolpermissions). Simply load the AuthServiceProvider from this package.

```php
// config/app.php

'providers' => [
    ...
    Dewsign\NovaBlog\Providers\AuthServiceProvider::class,
],
```
