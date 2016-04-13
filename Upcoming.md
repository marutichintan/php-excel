# The simple PHP to Excel converter #

The code php-excel aims at being a **very** simple. Generating larger excel files in the PHP processor brings some heavy load to the system. Therefore the class itself should be as lightweight as possible.

This implies that I need to (and will) judge thoroughfully about every single adjustment or feature enhancement. The core class Excel\_XML will _always_ deliver only the most basic features.

## Roadmap ##

### Version 1.2 ###

  * ~~Add support for different variable types~~ (_Implemented in 1.1_)
  * ~~Add support for headlines (1st row) and footer (last row)~~ (will not be implemented in core class)
  * ~~Add option to remotely set the used charset~~ (_Implemented in 1.1_)
  * ~~Fixing issues from the bugtracker (#3, #4, #7, #8, #9)~~ (_Implemented in 1.1_)
  * Explore and summarize more possible features
  * Add a method to write the output to a file instead of delivering it out
  * Add a method to return the output
  * Add multiple worksheets in a workbook
  * Add option to save the file in different file formats (xml/xls)
  * **Version 1.2 will be downward compatible with older versions**

### Version 1.3 ###

  * Introduction of an extension class Excel\_XML\_Extended which will allow more features based on the core library
  * **Version 1.3 will be downward compatible with older versions**
  * Version 1.1 methods `addArray` and `generateXML` will throw errors of type Notice (anouncing depreciation)