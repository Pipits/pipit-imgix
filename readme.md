# Pipit Imgix

Pipit Imgix is a Perch [template filter](https://docs.grabaperch.com/api/template-filters/) that enables you to easily manipulate and optimise your images on the fly using [Imgix](https://imgix.com). Imgix also serves your images with a worldwide CDN optimized for visual content.


## Installation
- Download the latest version of the Pipit Imgix.
- Unzip the download
- Place the `PipitTemplateFilter_imgix.class.php` file in the folder `perch/addons/templates/filters/`
- Include the class in the file `perch/addons/templates/filters.php`:

```php
include('filters/PipitTemplateFilter_imgix.class.php');
```


## Imgix setup

Follow Imgix's [setup guide](https://docs.imgix.com/setup) and set up your Source. 

If you are storing your images on your server along with your Perch installation (i.e. not in cloud storage), create a web folder source and use your root domain as the base URL.



## Perch configuration

Add your Imgix source subdomain to your Perch config file `config.php`. If your subdomain is `grabapipit.imgix.net`, you would add:

```php
define('PIPIT_IMGIX_SUBDOMAIN', 'grabapipit');
```


#### Development / Staging environments

By default, the filter does not rewrite your image URLs if you set your Perch production environment to development or staging:
 
```php
define('PERCH_PRODUCTION_MODE', PERCH_DEVELOPMENT);
```

You have the option to enable it:

```php
define('PIPIT_IMGIX_DEV', true);
```

Note that Imgix requires a publicly accessible URL to fetch the image from. 

Also note that your Imgix subdomain is tied to a specific location, so unless you are using cloud storage a single subdomain won't work across multiple environments.




## Usage

Use `filter="imgix"` on your image field tags to serve the image via Imgix:

```html
<perch:content id="image" type="image" filter="imgix">
```

### Adding parameters

Refer to [Imgix's documentation](https://docs.imgix.com/apis/) for what parameters you can use. You can also use their [Sandbox tool](https://sandbox.imgix.com/create) to see them in action.

You can add Imgix parameters in 2 ways:

1. Use the `imgix-opts` or `opts` attribute and add them all together as if you were to add them to a URL:

```html
<perch:content id="image" type="image" filter="imgix" imgix-opts="auto=format&q=80&w=800">
<perch:content id="image" type="image" filter="imgix" opts="auto=format&q=80&w=800">
```

2. Or you can add each parameter as a tag attribute prefixed with `imgix-`:

```html
<perch:content id="image" type="image" filter="imgix" imgix-auto="format" imgix-q="80" imgix-w="800">
```


### Dynamic variables

You can also use dynamic variables inside the imgix attributes. These are the variables you have access to inside the template:

```html
<perch:content id="quality" type="select" label="Image Quality" options="90,80,70" suppress>
<perch:content id="image" type="image" label="Image" filter="imgix" imgix-opts="auto=format&q={quality}&w=800">
```

```html
<perch:content id="quality" type="select" label="Image Quality" options="90,80,70" suppress>
<perch:content id="image" type="image" label="Image" filter="imgix" imgix-q="{quality}" imgix-auto="format">
```


### Options

You can specify a subdomain other than the default `PIPIT_IMGIX_SUBDOMAIN` with the `subdomain` attribute:

```html
<perch:content id="image" type="image" filter="imgix" imgix-opts="auto=format&q=80&w=800" subdomain="grabapipit">
```