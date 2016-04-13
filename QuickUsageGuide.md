# Introduction #

**php-excel** is a very, very simple class to generate excel 2003 files from PHP5 using the excel XML-notation. The main advantage is its easy handling and quick implementation.

# Prerequisites #

**php-excel** expects a two-dimensional array and dumps it into columns and rows. Please first download the file [from the branches directory](http://php-excel.googlecode.com/svn/branches/).

# Inclusion #

Step 01: Just put the class-excel-xml.inc.php in your project directory and include it using (of course you may choose to put it wherever you like):
```
require (dirname (__FILE__) . "/class-excel-xml.inc.php");
```

Step 02: For testing, create a two dimensional array:
```
$myarray =  array (
       1 => array ("Oliver", "Peter", "Paul"),
            array ("Marlene", "Mica", "Lina")
    );
```

Step 03: Instanciate class and dump the array into the document.
```
$xls = new Excel_XML;
$xls->addArray ( $myarray );
$xls->generateXML ( "testfile" );
```

The document (with filename "testfile") will be delivered to your browser for downloading. All values of the array will be defined as "string" - I may at support for more types later.
