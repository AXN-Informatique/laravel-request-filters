# Laravel Request Sanitizer

Permet de nettoyer les données entrantes.

Par exemple lorsqu'elles sont passées par un content editable et dans lesquelles on retrouvent un peu de n'importe quoi mis par le navigateur...


## Installation

Requérir ce paquet dans votre composer.json :

```
    "require" : {
        "axn/laravel-request-sanitizer" : "~1.0"
    }
```

Ajouter le dépôt privé à votre composer.json :

```
    "repositories" : [{
            "type" : "vcs",
            "url" : "git@bitbucket.org:axn/laravel-request-sanitizer.git"
        }
    ]
```

Vous aurez besoin d'une clé SSH pour exécuter la commande suivante :

```
composer update
```


## Utilisation

Globalement deux choses à faire : définir les règles de nettoyage, appeller le trait dans la FormRequest

```php
<?php

namespace App\Http\Requests;

use Axn\RequestSanitizer\FilterableFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class MyRequest extends FormRequest
{
    use FilterableFormRequest;

    protected $sanitizes = [
        'name' => 'trim|stripped'
    ];
}

```
