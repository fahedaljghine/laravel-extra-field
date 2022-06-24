# laravel-extra-field

![Laravel 9.0](https://img.shields.io/badge/Laravel-9.0-f4645f.svg)
![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)

A package to enable assigning extra fields to Eloquent Models

## Contact Me

You can check all of my information
by [Checking my website](https://fahedaljghine.com/).

## Installation

You can install the package via composer:

``` bash
composer require fahedaljghine/laravel-extra-field
```

The package will automatically register itself.

You must publish the migration with:

```bash
php artisan vendor:publish --provider="Fahedaljghine\ExtraField\ExtraFieldServiceProvider" --tag="migrations"
```

Migrate the `extras` & `extra_values` table:

```bash
php artisan migrate
```

Optionally you can publish the config-file with:

```bash
php artisan vendor:publish --provider="Fahedaljghine\ExtraField\ExtraFieldServiceProvider" --tag="config"
```

This is the contents of the file which will be published at `config/extra-field.php`

```php
return [

    /*
     * The class name of the extra model that holds all extras.
     *
     * The model must be or extend `Fahedaljghine\ExtraField\Extra`.
     */
    'extra_model' => Fahedaljghine\ExtraField\Extra::class,

    /*
     * The class name of the extra value model that holds all values.
     *
     * The model must be or extend `Fahedaljghine\ExtraField\ExtraValue`.
     */
    'extra_value_model' => Fahedaljghine\ExtraField\ExtraValue::class,

    /*
     * The name of the column which holds the ID of the model related to the extra values.
     *
     * You can change this value if you have set a different name in the migration for the extra_values table.
     */
    'model_primary_key_attribute' => 'model_id',


    /*
     * The name of the column which holds the Class Name of the model related to the extras.
     *
     * You can change this value if you have set a different name in the migration for the extras table.
     */
    'model_name_attribute' => 'model_class',
];
```

## Usage

Add the `HasExtraFields` trait to a model you like to use extras on.

```php
use Fahedaljghine\ExtraField\HasExtraFields;

class YourEloquentModel extends Model
{
    use HasExtraFields;
}
```

### Add a new extra field and value

You can add a new extra field like this:

```php
$extra_field = $model->addExtraField('fieldName' , 'fieldType');

//assign value
$extra_field = $model->addExtraValue($extra_field->id , 'filedValue');

//assign value for other instance no need to add extra field again
$extra_field = $otherModel->addExtraValue($extra_field->id , 'filedValue');

//for another instance
$extra_field = $anotherModel->addExtraValue($extra_field->id , 'filedValue');
```

### Add a new extra field string type and assign value

if you want to add a new string extra field for your model you can do it like this:

```php

$model->addStringExtraValue('fieldName' , 'filedValue');

//you can repeat for other object
$otherModel->addExtraValue('fieldName', 'filedValue');

```

### Retrieve data

```php

// will give array of all extra fields with associated values
$model->getExtras(); // ['fieldName1' => 'filedValue' , 'fieldName2' => 'filedValue']


$model->extras(); // will return a collection of Fahedaljghine\ExtraField\Extra


$model->extraValues ; //will return a collection of Fahedaljghine\ExtraField\ExtraValue


$model->extraValues() ; // will return hasMany Relation of Fahedaljghine\ExtraField\ExtraValue
```


### Drop extra field
```php

//this wil drop the value of the given name extra field for this model
$model->dropExtraFieldData($name) ;
```

### Drop extra field and all related data to model
# `use with caution`
```php

//this will drop the extra data field and all associated data with it
$model->dropExtraField($name);
```


### update extra field value
sometimes you may need to update the value of the extra field, you can achive that by using this :
```php

#$extra_field @param String the name of the extra field
#$updated_value @param String the new value

$model->updateExtraValue($extra_field , $updated_value);
```


### Custom models and migrations

You can change the models used by specifying a class name in the `extra_model` & `extra_value_model` key of
the `extra-field` config file.

You can change the column name used in the extra_values table (`model_id` by default) when using a custom migration
where you
changed that. In that case, simply change the `model_primary_key_attribute` key of the `extra-field` config file.

You can change the column name used in the extra_values table (`model_class` by default) when using a custom migration
where you
changed that. In that case, simply change the `model_name_attribute` key of the `extra-field` config file.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

You are welcome to contribute

## Dontae
 - [Paypal](https://www.paypal.com/donate/?hosted_button_id=MSKWTL27YPFDW)

## Credits

- [Fahed Aljghine](https://github.com/fahedaljghine)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
