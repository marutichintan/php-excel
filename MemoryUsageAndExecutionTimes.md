# Performance #

Version 1.2 will contain a major restructuring of the library. It will contain several improvements and an easier introduction if you want to extend the class in some way. However, generating large Excel files - even if it's just XML - can be a little bit of a hassle for computers or servers.

I've used [XDebug](http://xdebug.org/) to run some performance analysis on the creation of large files out of a MySQL database (which was one of the worst cases I could think of). I've exported 12.000 records (each containing 15 fields with strings and/or numeric values). My test generated a **11.7MB** xml file using `self::writeWorkbook()` which took about **6 seconds**. But during that time the peak memory usage was at **36.69MB**.

The library does not _stream_ the file to the harddisk, instead it creates it in an internal object and writes this object to the file afterwards. **24MB** of the total memory consumed was used to generate the object - which lets me investigate, whether this process could be optimized.

I will continue testing with various data dumps and post the findings here.