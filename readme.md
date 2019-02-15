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