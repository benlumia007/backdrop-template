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
The hierarchy system is smarter and more flexible template hierarchy for ClassicPress and WordPress.

## Custom Templates System
Custom templates for registering custom post templates, it works for any object type (e.g., post, term, user, etc.), but does not add any UI elements of its own.

The major difference between this and the typical WordPress page template system is that the template doesn't have to exist for registration. It also defaults to supporting all post types instead of just page.

## Requirements
* ClassicPress 1.4+
* WordPress 4.9+
* PHP 7.0+
* Composer 2.2+

## Copyright and Licenses
This project is licensed under the GNU GPL, version 2 or later.

2019–2023 © Benjamin Lu
