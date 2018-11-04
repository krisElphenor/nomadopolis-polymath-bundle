**Polymath Bundle**

To install Polymath in your project:

```
git submodule add https://github.com/krisElphenor/nomadopolis-polymath-bundle.git
```

After installing the bundle, enable it:

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