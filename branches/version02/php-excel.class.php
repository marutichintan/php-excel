<?php

/**
 * Simple excel generating from PHP5
 * 
 * This is one of my utility-classes.
 * 
 * The MIT License
 * 
 * Copyright (c) 2007 Oliver Schwarz
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package Utilities
 * @author Oliver Schwarz <oliver.schwarz@gmail.com>
 * @version 1.0
 */

/**
 * Generating excel documents on-the-fly from PHP5
 * 
 * Uses the excel XML-specification to generate a native
 * XML document, readable/processable by excel.
 * 
 * @package Utilities
 * @subpackage Excel
 * @author Oliver Schwarz <oliver.schwarz@vaicon.de>
 * @version 1.1
 * 
 * @todo User should be able to set the encoding of the excel file remotely
 * @todo Issue #3: implode() is not working well with large arrays
 * @todo Issue #4: Internet Explorer 7 does not work well with the given header
 * @todo Add configuration to activate/deactivate the string conversion
 * @todo Add option to give out first line as header (bold text)
 * @todo Add option to give out last line as footer (bold text)
 */
class Excel_XML
{

    /**
     * Header of excel document (prepended to the rows)
     * @access private
     * @var string
     */
    private $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?\>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">";

    /**
     * Footer of excel document (appended to the rows)
     * @access private
     * @var string
     */
    private $footer = "</Workbook>";


    /**
     * Document lines (rows in an array)
     * 
     * @access private
     * @var array
     */
    private $lines = array ();

        /**
         * Used encoding
         * @var string
         */
        private $sEncoding;
        
        /**
         * Worksheet title
         * @var string
         */
        private $sWorksheetTitle = "Table1";

        /**
         * Constructor
         * 
         * The constructor allows the setting of some additional
         * parameters so that the library may be configured to
         * one's needs.
         * 
         * @param string $sEncoding Encoding to be used (defaults to UTF-8)
         */
        public function __construct($sEncoding = 'UTF-8')
        {
        	$this->sEncoding = $sEncoding;
        }
    
    /**
     * Add a single row to the $document string
     * 
     * @access private
     * @param array 1-dimensional array
     * @todo Row-creation should be done by $this->addArray
     */
    private function addRow ($array)
    {

        // initialize all cells for this row
        $cells = "";

        // foreach key -> write value into cells
        foreach ($array as $k => $v):

            $cells .= "<Cell><Data ss:Type=\"String\">" . $v . "</Data></Cell>\n"; 

        endforeach;

        // transform $cells content into one row
        $this->lines[] = "<Row>\n" . $cells . "</Row>\n";

    }

    /**
     * Add an array to the document
     * 
     * This should be the only method needed to generate an excel
     * document.
     * 
     * @access public
     * @param array 2-dimensional array
     * @todo Can be transfered to __construct() later on
     */
    public function addArray ($array)
    {
        // run through the array and add them into rows
        foreach ($array as $k => $v):
            $this->addRow ($v);
        endforeach;
    }

    /**
     * Set the worksheet title
     * 
     * Checks the string for not allowed characters (:\/?*),
     * cuts it to maximum 31 characters and set the title. Damn
     * why are not-allowed chars nowhere to be found? Windows
     * help's no help...
     *
     * @access public
     * @param string $title Designed title
     */
    public function setWorksheetTitle ($title)
    {

        // strip out special chars first
        $title = preg_replace ("/[\\\|:|\/|\?|\*|\[|\]]/", "", $title);

        // now cut it to the allowed length
        $title = substr ($title, 0, 31);

        // set title
        $this->sWorksheetTitle = $title;

    }

    /**
     * Generate the excel file
     * 
     * Finally generates the excel file and uses the header() function
     * to deliver it to the browser.
     * 
     * @access public
     * @param string $filename Name of excel file to generate (...xls)
     */
    function generateXML ($filename)
    {

        // deliver header (as recommended in php manual)
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $filename . ".xls\"");

        // print out document to the browser
        // need to use stripslashes for the damn ">"
        echo stripslashes ($this->header);
        echo "\n<Worksheet ss:Name=\"" . $this->sWorksheetTitle . "\">\n<Table>\n";
        echo "<Column ss:Index=\"1\" ss:AutoFitWidth=\"0\" />\n";
        foreach ($this->lines as $line):
                echo $line . "\n";
        endforeach;
        echo "</Table>\n</Worksheet>\n";
        echo $this->footer;

    }

}

?>