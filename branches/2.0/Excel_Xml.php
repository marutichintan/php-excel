<?php

/**
 * Excel Xml Generator
 * 
 * @author Oliver Schwarz <oliver.schwarz@gmail.com>
 */

/**
 * Excel Xml Generator Class
 * 
 * A simple class to dump an array into a file or output stream
 * readable by Excel or other calc/spreadsheet software.
 * 
 * @author Oliver Schwarz <oliver.schwarz@gmail.com>
 */
class Excel_Xml
{
    /**
     * Microsoft Open XML header for spreadsheets
     * @var string
     * @static
     */
    const sSpreadsheetHeader = "<?xml version=\"1.0\" encoding=\"%s\"?\>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";

    /**
     * Microsoft Open Xml closing tag
     * @var string
     * @static
     */
    const sSpreadsheetFooter = "</Workbook>";

    /**
     * Worksheet data
     * @var array
     */
    protected $aWorksheetData;

    /**
     * Output string
     * @var string
     */
    protected $sOutput;

    /**
     * Encoding
     * @var string
     */
    protected $sEncoding;

    /**
     * Get sanitized workbook title
     * 
     * Sanitizes a workbook title (filename) to contain only the
     * allowed characters using a whitelist regexp.
     * 
     * @param string $title Title to sanitize
     * @return string Sanitized workbook title
     */
    private function getSanitizedWorkbookTitle($title)
    {
        return preg_replace('/[^aA-zZ0-9\_\-\.]', '', $title);
    }

    /**
     * Get sanitized worksheet title
     * 
     * Sanitizes a worksheet title using a whitelist regexp.
     * Excel only allows certain characters and only a certain
     * length in workbook titles.
     * 
     * @param string $title Title to sanitize
     * @return string Sanitized worksheet title
     */
    private function getSanitizedWorksheetTitle($title)
    {
        $sWorksheetTitle = preg_replace('/[\\\|:|\/|\?|\*|\[|\]]', '', $title);
        return substr($sWorksheetTitle, 0, 31);
    }
    
    /**
     * Constructor
     * 
     * Sets default property values and allows to configure
     * the used encoding. If a certain encoding is used, Excel_Xml
     * expects all other input in this encoding.
     * 
     * @param string $sEncoding Encoding to use (default UTF-8) [optional]
     * @return void
     */
    public function __construct($sEncoding = 'UTF-8')
    {
        $this->sEncoding = $sEncoding;
        $this->sOutput = '';
    }

    /**
     * Destructor
     * 
     * The worksheet may contain some massive amount of data. The deconstructor
     * frees some of the memory again.
     * 
     * @return void
     */
    public function __destruct()
    {
        unset($this->aWorksheetData);
        unset($this->sOutput);
    }

}