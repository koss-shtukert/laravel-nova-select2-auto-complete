[![GitHub stars](https://img.shields.io/github/stars/koss-shtukert/laravel-nova-select2-auto-complete.svg?style=flat-square)](https://github.com/koss-shtukert/laravel-nova-select2-auto-complete/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/koss-shtukert/laravel-nova-select2-auto-complete.svg?style=flat-square)](https://github.com/koss-shtukert/laravel-nova-select2-auto-complete/network)
[![GitHub issues](https://img.shields.io/github/issues/koss-shtukert/laravel-nova-select2-auto-complete.svg?style=flat-square)](https://github.com/koss-shtukert/laravel-nova-select2-auto-complete/issues)
[![GitHub last commit](https://img.shields.io/github/last-commit/koss-shtukert/laravel-nova-select2-auto-complete.svg?style=flat-square)](https://github.com/koss-shtukert/laravel-nova-select2-auto-complete/commits)

# Laravel Nova Select2 Auto-Complete

##### An auto-completing Laravel Nova search field.

Provides a capability of auto-completed searching for results inside a select input field.

Based on [SELECT2](https://select2.org) (The jQuery replacement for select boxes)

![Select2 Auto-Complete](./screenshot_1.png)

![Select2 Auto-Complete](./screenshot_2.png)

![Select2 Auto-Complete](./screenshot_3.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require koss-shtukert/laravel-nova-select2-auto-complete
```

## Usage

The API is exactly the same as with [Nova's default `Select` Field](https://nova.laravel.com/docs/1.0/resources/fields.html#select-field)

Simply use `Select2` class instead of `Select` directly or alias it like the example below so you won't have to refactor too much existing code.

```php
<?php namespace App\Nova;

use App\Models\Category as CategoryModel;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Text;
use Illuminate\Http\Request;
use KossShtukert\LaravelNovaSelect2\Select2;

class Category extends Resource
{
    /**
      * The model the resource corresponds to.
      *
      * @var string
      */
     public static $model = CategoryModel::class;
 
     /**
      * The logical group associated with the resource.
      *
      * @var string
      */
     public static $group = 'Catalog';
 
     /**
      * The single value that should be used to represent the resource when being displayed.
      *
      * @var string
      */
     public static $title = 'name';
 
     /**
      * The columns that should be searched.
      *
      * @var array
      */
     public static $search = [
         'name',
     ];
 
     /**
      * Get the fields displayed by the resource.
      *
      * @param  \Illuminate\Http\Request $request
      * @return array
      */
     public function fields(Request $request)
     {
         $resourceId = $request->route()->parameter('resourceId');
         $categories = app(self::$model)->where('id', '!=', $resourceId)->pluck('name', 'id');
 
         return [
             ID::make()->sortable(),
 
             Select2::make('Parent category', 'category_id')
                 ->sortable()
                 ->options($categories)
                 /**
                  * Documentation
                  * https://select2.org/configuration/options-api
                  */
                 ->configuration([
                     'placeholder'             => __('Choose an option'),
                     'allowClear'              => true,
                     'minimumResultsForSearch' => 1
                 ])
                 /**
                  * Show as link to resource on Index and Detail page
                  *    
                  * @param null|string 
                  * Default: null
                  * Which Model it should be linked as Resource
                  */
                 ->showAsLink(self::$model),
 
             Text::make('Name')
                 ->sortable()
                 ->rules('required', 'max:255'),
 
             Text::make('Slug')
                 ->sortable()
                 ->creationRules('unique:categories,slug')
                 ->updateRules('unique:categories,slug,{{resourceId}}')
                 ->hideFromIndex(),
 
             Textarea::make('Description'),
 
             Image::make('Logo', 'logo')
                 ->hideFromIndex(),
         ];
     }
 
     /**
      * Get the cards available for the request.
      *
      * @param  \Illuminate\Http\Request $request
      * @return array
      */
     public function cards(Request $request)
     {
         return [];
     }
 
     /**
      * Get the filters available for the resource.
      *
      * @param  \Illuminate\Http\Request $request
      * @return array
      */
     public function filters(Request $request)
     {
         return [];
     }
 
     /**
      * Get the lenses available for the resource.
      *
      * @param  \Illuminate\Http\Request $request
      * @return array
      */
     public function lenses(Request $request)
     {
         return [];
     }
 
     /**
      * Get the actions available for the resource.
      *
      * @param  \Illuminate\Http\Request $request
      * @return array
      */
     public function actions(Request $request)
     {
         return [];
     }
}
```

### Multiple Selection

This package can also be used for multiple selection to handle a many-to-many relationship.

Say you have a many-to-many relationship between Category and Item and you want to be able to select multiple items on the Category Update page. You can handle it as follows:

```php
class Category extends Model
{
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
    
    ...
    
    public function getItemListAttribute()
    {
        return $this->items->pluck('id')->all();
    }
    
    public function setItemListAttribute($value)
    {
        $items = explode(",", $value);
        $this->items()->sync($items);
    }
}
```

```php
class Category extends Resource
{
    //...

    public function fields(Request $request)
    {
        //...
        $items = Item::all()->pluck('name', 'id');
        
        return [
            //...
            Select2::make('Items', 'itemList')
                ->sortable()
                ->options($items)
                /**
                * Documentation
                * https://select2.org/configuration/options-api
                */
                ->configuration([
                    'placeholder'             => __('Choose options'),
                    'allowClear'              => true,
                    'minimumResultsForSearch' => 1,
                    'multiple'                => true,
                ]),
            //...                        
        ];
    }
}
```
