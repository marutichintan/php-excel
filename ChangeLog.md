# Version 1 #

## Version 1.1 ##

Version 1.1 is a more advanced library which fixes several issues from the [bugtracker](http://code.google.com/p/php-excel/issues/list). Thanks to a lot of people giving feedback and describing their problems I was able to bring out this version based on the fixes they posted in comments and issues.

  * Users are now able to set encoding/charset remotely in the constructor
  * Library does now work better with larger arrays/data containers
  * Special characters are now converted before injected in table cells
  * Constructor now allows activating/deactivating the automatic type conversion in cells
  * Several unneeded code passages (mainly xml) have been removed
  * It's not as easy to produce errors as in version 1 ;)

**Version 1.1 is fully compatible to all code based on version 1.0.**

## Version 1.0 ##

Version 1 was the first simple implementation of a class converting a simple PHP-Array into an excel-readable XML file. I took advantage of the fact that - when having the mimetype .xls - Excel would read the file without prompts.

**Features were:**

  * Converting a 2-dimensional array in a row/column xml
  * Delivering out a .xls document using PHP's header function