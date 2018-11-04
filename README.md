**Polymath Bundle**

After installing the bundle (using git for now), enable the bundle:

```
// config/bundles.php
 return [
     // ...
     Nomadopolis\PolymathBundle::class => ['all' => true],
 ];
``` 

Then, create the package configuration:

```
// config/packages/nomadopolis_polymath.yaml
nomadopolis_polymath:
    end_point: 'http://url_to_api_endpoint.url'
``` 

That's it !