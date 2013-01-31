# FuelPHP Package for Navigation

This package output breadcrumbs, links and sitemap.


***

## Configuration
1. Copy packages/navigation/config/navigation-default.php to under app/config directory.
2. Edit navigation-default.php that copied.

## Enable Navigation package.
### In app/config/config.php

```
'always_load' => array(
	'packages' => array(
		'navigation',
		...
```

or

### In your code
```
Package::load('navigation');
```

## Usage

### breadcrumbs

Outputs a breadcrumb in the form of Twitter Bootstrap
```
Navigation::breadcrumbs($config = 'default');
// result <ul class="breadcrumb"><li><a title="Home" href="/">Home</a><span class="divider">/</span></li><li class="active">page1</li></ul>
```

If you specify a "$config", switch the configuration file

#### Example
```
$configfilename = 'eng';
```
navigation-default.php -> navigation-eng.php


### links

Outputs a link Relations, start, next and prev
```
Navigation::links($config = 'default');
// result
// <link rel="start" href="/" title="Home">
// <link rel="next" href="/page3" title="page3">
// <link rel="prev" href="/page1" title="page1">
```

If you specify a "$config", switch the configuration file

#### Example
```
$configfilename = 'eng';
```
navigation-default.php -> navigation-eng.php


### sitemap

Outputs a Sitemap
```
Navigation::sitemap($config = 'default');
// result
// <?xml version="1.0" encoding="UTF-8"?>
// <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
//   <url>
//     <loc>http://example.com/</loc>
//   </url>
//   <url>
//     <loc>http://example.com/page1</loc>
//   </url>
//   ...
// </urlset>
```

If you specify a "$config", switch the configuration file

#### Example
```
$configfilename = 'eng';
```
navigation-default.php -> navigation-eng.php


### get properties

Outputs a property
```
Navigation::get($uri, $property, $config = 'default');
// result home etc..
```

"$uri" is Root-relative URL.

#### Example
```
$uri = '/page1/page2';
```

"$property" is "properties" of navigation-settings.php

#### Example
```
$property = 'description';
```

If you specify a "$config", switch the configuration file

#### Example
```
$configfilename = 'eng';
```
navigation-default.php -> navigation-eng.php

###### my code is ugly (笑
