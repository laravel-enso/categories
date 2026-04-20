# Categories

[![License](https://poser.pugx.org/laravel-enso/categories/license)](LICENSE)
[![Stable](https://poser.pugx.org/laravel-enso/categories/version)](https://packagist.org/packages/laravel-enso/categories)
[![Downloads](https://poser.pugx.org/laravel-enso/categories/downloads)](https://packagist.org/packages/laravel-enso/categories)
[![PHP](https://img.shields.io/badge/php-8.2%2B-777bb4.svg)](composer.json)
[![Issues](https://img.shields.io/github/issues/laravel-enso/categories.svg)](https://github.com/laravel-enso/categories/issues)
[![Merge Requests](https://img.shields.io/github/issues-pr/laravel-enso/categories.svg)](https://github.com/laravel-enso/categories/pulls)

## Description

Categories is Laravel Enso's reusable hierarchical category management package.

It provides the backend flow for storing, editing, listing, reordering, importing, and decorating nested categories, together with form and table builders that plug directly into the Enso admin UI. The package also supports optional category images, featured categories, select-friendly labels, and tree-shaped API payloads for frontend consumers.

## Installation

This package comes pre-installed in Laravel Enso distributions that need category administration.

For standalone package installation inside an Enso-based application:

```bash
composer require laravel-enso/categories
```

The package auto-registers its service provider, loads its routes and migrations, and merges the `enso.categories` configuration namespace.

Run the migrations after installation:

```bash
php artisan migrate
```

If you want to publish the package config or its factory stubs:

```bash
php artisan vendor:publish --tag=categories-config
php artisan vendor:publish --tag=categories-factory
```

## Features

- Stores categories in a self-referencing tree through `parent_id`.
- Keeps siblings ordered automatically through `order_index` and the global `Ordered` scope.
- Exposes full CRUD endpoints for category administration.
- Supports drag-and-drop style reorder and parent reassignment through the `move()` workflow.
- Builds frontend-ready form payloads through the Enso forms builder.
- Builds table metadata and data endpoints through the Enso tables builder.
- Returns nested category trees with image metadata for UI consumers.
- Generates select-compatible labels such as `Parent > Child`.
- Supports optional category images through Enso files integration.
- Restricts image uploads to top-level categories only.
- Supports featured categories through the `is_featured` flag and `featured()` scope.
- Includes import and validation classes for category dataset ingestion.
- Provides helper methods for parent trees, subtree flattening, depth, and level calculations.

::: warning Note
Only top-level categories can have images attached. Upload validation blocks image uploads for nested categories.

The maximum nesting depth is controlled through `CATEGORIES_MAX_NESTING_LEVEL`.
:::

## Usage

### Basic model usage

Create a top-level category:

```php
use LaravelEnso\Categories\Models\Category;

$category = Category::create([
    'name' => 'Solar Panels',
    'is_featured' => true,
]);
```

Create a child category:

```php
$subcategory = Category::create([
    'name' => 'Monocrystalline',
    'parent_id' => $category->id,
    'is_featured' => false,
    'order_index' => Category::nextIndex($category->id),
]);
```

Move a category to a different parent and position:

```php
$subcategory->move(orderIndex: 1, parentId: null);
```

Read the nested tree:

```php
$tree = Category::tree();
```

Inspect hierarchy helpers:

```php
$level = $subcategory->level();
$depth = $category->depth();
$parentTree = $subcategory->parentTree();
$flattenedIds = $category->flattenCurrentAndBelowIds();
```

### Select labels

Use the label resource when a dropdown needs the full breadcrumb:

```php
$options = Category::with('recursiveParent')
    ->get()
    ->map
    ->label();
```

### Frontend integration

The package ships the backend routes and payload builders used by the Enso categories administration UI.

Companion frontend package:

- [`@enso-ui/categories`](https://docs.laravel-enso.com/frontend/categories.html) [↗](https://github.com/enso-ui/categories)

## Contributions

are welcome. Pull requests are great, but issues are good too.

Thank you to all the people who already contributed to Enso!
