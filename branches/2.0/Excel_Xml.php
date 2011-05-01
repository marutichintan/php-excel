<?php

/**
 * Excel Xml Generator
 * 
 * @category Utilities
 * @package  Utilities
 * @author   Oliver Schwarz <oliver.schwarz@gmail.com>
 * @license  MIT License http://www.opensource.org/licenses/mit-license.php
 * @version  2.0
 * @link     http://code.google.com/p/php-excel/
 * 
 * @todo Add compatibility methods for version 1.0
 * @todo Add method to write to file
 * @todo Add method to return output
 */

/**
 * Excel Xml Generator Class
 * 
 * A simple class to dump an array into a file or output stream
 * readable by Excel or other calc/spreadsheet software.
 * 
 * @category Utilities
 * @package  Utilities
 * @author   Oliver Schwarz <oliver.schwarz@gmail.com>
 * @license  MIT license http://www.opensource.org/licenses/mit-license.php
 * @version  2.0
 * @link     http://code.google.com/p/php-excel/
 */
class Excel_Xml
{
    /**
     * Microsoft Open XML header for spreadsheets
     * @var string
     * @static
     */
    const HEADER = "<?xml version=\"1.0\" encoding=\"%s\"?\>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";

    /**
     * Microsoft Open Xml closing tag
     * @var string
     * @static
     */
    const FOOTER = '</Workbook>';

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
     * 
     * @return string Sanitized workbook title
     */
    private function _getSanitizedWorkbookTitle($title)
    {
        return preg_replace('/[^aA-zZ0-9\_\-\.]/', '', $title);
    }

    /**
     * Get sanitized worksheet title
     * 
     * Sanitizes a worksheet title using a whitelist regexp.
     * Excel only allows certain characters and only a certain
     * length in worksheet titles.
     * 
     * @param string $title Title to sanitize
     * 
     * @return string Sanitized worksheet title
     */
    private function _getSanitizedWorksheetTitle($title)
    {
        $sWorksheetTitle = preg_replace('/[\\\|:|\/|\?|\*|\[|\]]/', '', $title);
        return substr($sWorksheetTitle, 0, 31);
    }

    /**
     * Generate workbook
     * 
     * Generates the outer workbook frame to contain multiple worksheets.
     * Expects to have all required sheets as data already in the
     * $aWorksheetData container.
     * 
     * @uses $aWorksheetData
     * @uses generateWorksheet()
     * 
     * @return void
     */
    protected function generateWorkbook()
    {
        $this->sOutput = stripslashes(sprintf(self::HEADER, $this->sEncoding))."\n";
        foreach ($this->aWorksheetData as $aSheet) {
            $this->generateWorksheet($aSheet);
        }

        $this->sOutput .= self::FOOTER;
    }

    /**
     * Generate worksheet
     * 
     * Generates a single worksheet into the output container.
     * 
     * @param array $aSheet Array with sheet data
     * 
     * @uses generateRow()
     * @todo Check whether the row restriction is still necessary
     * @return void
     */
    protected function generateWorksheet($aSheet)
    {
        $this->sOutput .= sprintf("<Worksheet ss:Name=\"%s\">\n    <Table>\n", $aSheet['title']);
        if (count($aSheet['data'])) {
            $aSheet['data'] = array_slice($aSheet['data'], 0, 65536);
            foreach ($aSheet['data'] as $k => $v) {
                $this->generateRow($v);
            }
        }

        $this->sOutput .= "    </Table>\n</Worksheet>\n";
    }

    /**
     * Generate row
     * 
     * Generates a single row in the worksheet.
     * 
     * @param array $row Row item with data
     * 
     * @uses generateCell()
     * @return void
     */
    protected function generateRow($row)
    {
        $this->sOutput .= "        <Row>\n";
        foreach ($row as $k => $v) {
            $this->generateCell($v);
        }

        $this->sOutput .= "        </Row>\n";
    }

    /**
     * Generate single cell
     * 
     * This is where all the magic happens. Generates the cell from the given
     * input.
     * 
     * @param string $cell Cell data
     * 
     * @return void
     */
    protected function generateCell($cell)
    {
        // set default type
        $type = 'String';
        $cell = str_replace('&#039;', '&apos;', htmlspecialchars($cell, ENT_QUOTES));
        $this->sOutput .= sprintf("            <Cell><Data ss:Type=\"%s\">%s</Data></Cell>\n", $type, $cell);
    }
    
    /**
     * Constructor
     * 
     * Sets default property values and allows to configure
     * the used encoding. If a certain encoding is used, Excel_Xml
     * expects all other input in this encoding.
     * 
     * @param string $sEncoding Encoding to use (default UTF-8) [optional]
     * 
     * @return void
     */
    public function __construct($sEncoding = 'UTF-8')
    {
        $this->sEncoding = $sEncoding;
        $this->sOutput = '';
    }

    /**
     * Add a worksheet
     * 
     * Adds a new worksheet to the data container.
     * 
     * @param string $title Title of worksheet
     * @param array  $data  Two-dimensional array of data
     * 
     * @return void
     */
    public function addWorksheet($title, $data)
    {
        $this->aWorksheetData[] = array(
            'title' => $this->_getSanitizedWorksheetTitle($title),
            'data' => $data
            );
    }

    /**
     * Send workbook to browser
     * 
     * Sends the workbook to the browser opening the default "Save as..."
     * dialog by using PHP's header directive.
     * 
     * @param string $filename Filename to use in dialog
     * 
     * @return void
     */
    public function sendWorkbook($filename)
    {
        if (!preg_match('/\.(xml|xls)$/', $filename)) {
            throw new InvalidArgumentException('Filename mimetype must be .xml or .xls');
        }
        $filename = $this->_getSanitizedWorkbookTitle($filename);
        $this->generateWorkbook();
        if (preg_match('/\.xls$/', $filename)) {
            header("Content-Type: application/vnd.ms-excel; charset=" . $this->sEncoding);
            header("Content-Disposition: inline; filename=\"" . $filename . "\"");
        } else {
            header("Content-Type: application/xml; charset=" . $this->sEncoding);
            header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        }
        echo $this->sOutput;
    }

    /**
     * Write workbook to file
     *
     * Writes the workbook into the file/path given as a parameters.
     * The method checks whether the directory is writable and the
     * file is not existing and writes the file.
     *
     * @param string $filename Filename to use for writing (must contain mimetype)
     * 
     * @return string Message
     */
    public function writeWorkbook($filename)
    {
        $this->generateWorkbook();
        $filename = $this->_getSanitizedWorkbookTitle($filename);
        if (!$handle = @fopen($filename, 'w+')) {
            throw new Exception(sprintf("Not allowed to write to file %s", $filename));
        }
        if (@fwrite($handle, $this->sOutput) === false) {
            throw new Exception(sprintf("Error writing to file %s", $filename));
        }
        @fclose($handle);
        return sprintf("File %s written", $filename);
    }

    /**
     * Get workbook
     * 
     * Returns the generated workbook.
     * 
     * @return string Generated workbook XML
     */
    public function getWorkbook()
    {
        $this->generateWorkbook();
        return $this->sOutput;
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