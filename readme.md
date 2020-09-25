Ce package **est abandonné** à la faveur de [\Illuminate\Foundation\Http\FormRequest::prepareForValidation()](https://laravel.com/docs/master/validation#prepare-input-for-validation)

Laravel Request Filters
=======================

Permet de filtrer les données entrantes des FormRequest.

Par exemple lorsqu'elles sont passées par un content editable et dans lesquelles on retrouvent un peu de n'importe quoi mis par le navigateur...


Installation
------------

Inclure le package avec Composer :

```sh
composer require axn/laravel-request-filters
```

Utilisation
-----------

Globalement deux choses à faire :

- appeller le trait dans la FormRequest
- définir la liste des filtres à appliquer dans une méthode filters()

```php
<?php

namespace App\Http\Requests;

use Axn\RequestFilters\FilterableFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class MyRequest extends FormRequest
{
    use FilterableFormRequest;

    public function filters()
    {
        return [
            'name' => 'stripped|trim'
        ];
    }
    //...
}

```

Les données passeront alors automatiquement dans les filtres juste avant d'êtres validées.

La méthode filters() doit retourner un tableaux. Les clés de ce tableau étant les noms des champs de la requête,
et les valeurs les nom des filtres à appliquer.

Il est possible de passer les noms des filtres à appliquer dans un tableau :

```php
<?php
//...

    public function filters()
    {
        return [
            'name' => [
                'stripped',
                'trim'
            ]
        ];
    }

//...
```

Vous pouvez utiliser n'importe quelle chaine de caractère qui représente une fonction de rappel (callable) :

```php
<?php
//...

    public function filters()
    {
        return [
            'name' => 'stripped|trim|strtolower|ucwords'
        ];
    }

//...
```

Les filtres sont appliqués dans l'ordre qu'ils sont déclarés ; autrement dit ci-dessus, "stripped" est appliqué, puis "trim", puis "strtolower" et enfin "ucwords".

Pour rappel, un callable peut être une méthode d'une classe utilisateur :

```php
<?php
//...

    public function filters()
    {
        return [
            'name' => [
                'stripped',
                'trim',
                'Foo::Bar'
            ]
        ];
    }

//...

class Foo
{
    public static function Bar($str)
    {
        return ucwords(strtolower($str));
    }
}

//...

```

Il est également possible de déclarer un filtre dans une closure :

```php
<?php
//...

    public function filters()
    {
        return [
            'name' => [
                'stripped',
                'trim',
                function($str) {
                    return ucwords(strtolower($str));
                }
            ]
        ];
    }

//...
```

Filtres disponibles
-------------------

### `trim`

Pour supprimer les espaces superflus de chaques côtés de la chaine de caractère

Note : y compris la(les) chaine(s) "&nbsp;"

### `strip`

Alias : `stripped` ou `sanitize_string`

Pour supprimer le code potentiellement dangereux.

En fait, passe la chaine de caractère dans :
`filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)`

### `url`

Alias : `sanitize_url`

Supprime tous les caractères qui ne devraient pas se trouver dans une URL.

En fait, passe la chaine de caractère dans :
`filter_var($str, FILTER_SANITIZE_URL)`

### `email`

Alias : `sanitize_email`

Supprime tous les caractères qui ne devraient pas se trouver dans une adresse email.

En fait, passe la chaine de caractère dans :
`filter_var($str, FILTER_SANITIZE_EMAIL)`
