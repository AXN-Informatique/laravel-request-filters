# Laravel Request Filters

Permet de filtrer les données entrantes.

Par exemple lorsqu'elles sont passées par un content editable et dans lesquelles on retrouvent un peu de n'importe quoi mis par le navigateur...


## Installation

Requérir ce paquet dans votre composer.json :

```
    "require" : {
        "axn/laravel-request-filters" : "~1.0"
    }
```

Ajouter le dépôt privé à votre composer.json :

```
    "repositories" : [{
            "type" : "vcs",
            "url" : "git@bitbucket.org:axn/laravel-request-filters.git"
        }
    ]
```

Vous aurez besoin d'une clé SSH pour exécuter la commande suivante :

```
composer update
```


## Utilisation

Globalement deux choses à faire : définir les filtres à appliquer, appeller le trait dans la FormRequest

```php
<?php

namespace App\Http\Requests;

use Axn\RequestFilters\FilterableFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class MyRequest extends FormRequest
{
    use FilterableFormRequest;

    protected $filters = [
        'name' => 'stripped|trim'
    ];

    //...
}

```

Les données seront automatiquement filtrées juste avant d'être validées.

Il est possible de passer les noms des filtres à appliquer dans un tableau :

```php
<?php
//...

    protected $filters = [
        'name' => [
            'stripped',
            'trim'
        ]
    ];

//...
```

Vous pouvez utiliser n'importe quel chaine de caractère qui représente une fonction de rappel (callable) :

```php
<?php
//...

    protected $filters = [
        'name' => 'stripped|trim|strtolower|ucwords'
    ];

//...

Les filtres sont appliqués dans l'ordre qu'ils sont déclarés ; autrement dit ci-dessus, "stripped" est appliqué, puis "trim", puis "strtolower" et enfin "ucwords".

Pour rappel, un callable peut être une méthode d'une classe utilisateur :

```php
<?php
//...

    protected $filters = [
        'name' => [
            'stripped',
            'trim',
            'Foo::Bar'
        ]
    ];

//...

class Foo
{
    public static function Bar($string)
    {
        return ucwords($string);
    }
}

//...

```
