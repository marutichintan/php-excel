# A simple PHP to Excel conversion #

For many modern companies Excel is still the main tool to use when it comes to analysis or reports. **php-excel** aims to be the most simple and lightweight approach to convert a matrix-like, two-dimensional array from PHP to Microsoft Excel. Here are some examples:

  * Create a quick export from a database table into Excel
  * Compile some statistical records with a few calculations and deliver the result in an Excel worksheet
  * Gather the items off your (web-based) todo list, put them in a worksheet and use it as a foundation for some more statistics magic.

However, this library **does not sport** many features, which would be possible: Creating functions, styling cells etc. If you need some holistic solution, there's a beautiful library project called [PHPExcel](http://www.codeplex.com/PHPExcel/) (thanks to _mcblazer_ in the comments), which is far more capable of doing these things.

## Version history ##

### Upcoming version 1.2 ###

Version 1.2 will be a complete rework and restructuring of the library. It will be **fully compatible with previous versions** but will contain some improvements addressing performance issues. I am currently testing this locally. Release will be soon. Read more in the [Upcoming wiki section](http://code.google.com/p/php-excel/wiki/Upcoming).

### Version 1.1 ###

There is an all new version out which addresses several issues from the [bugtracker](http://code.google.com/p/php-excel/issues/list). Please see the enclosed readme.txt for details. I will try to add a new wiki page to describe the new features. The version should be fully compatible with all code based on version 1.0.

MD5 checksum version 1.1 (php-excel-v1.1-20090910.zip):
DDC1F41860E4BAF60941108197649BD2

### Version 1 ###

Generating excel from php really bugs me. There are a lot of solutions out there, but each one is quite complex and doesn't focus on quick solutions. You have to include terabytes of libraries and generating documents fails from time to time.

MD5 checksum version 1.0 (php-excel-20070308.zip):
9e936ad9d5b45ac38bbb0b0529700340