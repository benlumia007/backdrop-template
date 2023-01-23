# Backdrop\Template
Backdrop Template is a drop-in package for Backdrop framework for developing ClassicPress and WordPress themes. This feature is used for setting up the view engine, a smarter and flexible template hierarchy and of course registering custom templates.

## View System
This feature is used for setting up and rendering template files, and it is similar to the WordPress core feature `get_template_part` function. However, this allows you to build a hierarchy of potential templates.

By default, the templates is located at `resources/views`, you can change the location by using a filter to change the templates location
<pre>
add_filter( 'backdrop/template/path', function() {
	return  'public/views';
} );
</pre>

## Hierarchy System


## Requirements
* ClassicPress 1.4+
* WordPress 4.9+
* PHP 7.0+
* Composer 2.2+

## Copyright and Licenses
This project is licensed under the GNU GPL, version 2 or later.

2019–2023 © Benjamin Lu
