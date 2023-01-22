# Changelog

## 2.0.0 - January 22, 2023
- New and Improved Framework

## 1.1.6 - January 19, 2021
- This is the last update for version 1.1.6

## 1.1.2 - November 18, 2020
- Add Support for ClassicPress

## 1.1.1 - April 10, 2020
- Merged

## 1.1.0 - March 21, 2020
- update minor fixes

## 1.0.9 - March 21, 2020
- fixed namespace

## 1.0.8 - March 17, 2020
- fixed divs

## 1.0.7 - March 17, 2020
- backdropScreenReaderText to backdropCoreScreenReaderText

## 1.0.6 - February 25, 2020
- updated

## 1.0.5 - June 26, 2019
- add widget-area class to dyanmic_sidebar( $item )
- fixed santize for layouts $setting->id

## 1.0.4 - June 12, 2019
- menu_display(); fixed

## 1.0.3 - May 11, 2019
- removed/deleted `src/Contracts/Interfaces/Admin.php`
- changed `src/Contracts/Admin/Admin.php` to abstract
- removed/deleted `src/Contracts/Abstracts/Customize.php`
- added `src/Contracts/Customize/Customize.php`
- updated `/src/Framework`
- deleted the following items
<pre>
deleted:    src/Contracts/Entry/Entry.php
deleted:    src/Contracts/Interfaces/Entry.php
deleted:    src/Contracts/Interfaces/Site.php
deleted:    src/Contracts/Interfaces/View.php
deleted:    src/Contracts/Site/Site.php
deleted:    src/Contracts/View/View.php
</pre>
- Added comments to the Admin.php
- Added Displayable, Renderable, and Viewable
- Updated `src/Site/Site`, `src/Entry/Entry`, and `src/View/View`
- moved `src/Register/Menu.php` to `src/Menu/Menu.php`
- moved `src/Register/Sidebar.php` to `src/Sidebar/Sidebar.php`
- moved `src/Customize/Control/ImageRadio.php` to starter theme
- delete `src/Register/ThemeLayout and move to starter theme
- edit `src/Framework` for layouts
- move assets for layouts to themes
<pre>
deleted:    assets/css/image-radio.css
deleted:    assets/images/1col.png
deleted:    assets/images/2cl.png
deleted:    assets/images/2cr.png
deleted:    assets/js/image-radio.js
</pre>


## 1.0.2 - May 6, 2019
- add h1 heading to post_type_archive_title ( 'entry-title' )
- add is_page() to entry-title when is in page template

## 1.0.1 - May 3, 2019
- Removed Font Awesome 5 Free for Regular, colliding/conflicts when uing Solid.
- Removed `brands.css`, `brands.min.css`, `solid.css`, and `solid.min.css`
- Primary Navigation set depth 2, allowing only sub-menu only.

## 1.0.0 - May 1, 2019
- Initial Release
