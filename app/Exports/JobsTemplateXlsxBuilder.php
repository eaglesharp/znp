<?php

namespace App\Exports;

use App\Exports\Sheets\JobsAllowedValuesSheet;
use App\Exports\Sheets\JobsTemplateJobsSheet;
use App\Services\JobBulkUploadService;
use ZipArchive;

/**
 * Builds the bulk-jobs .xlsx template using PHP's native ZipArchive instead of
 * PhpSpreadsheet's Xlsx writer.
 *
 * Why: PhpSpreadsheet's Xlsx writer pulls in maennchen/zipstream-php v3, which
 * uses PHP 8.1 `readonly` properties and therefore fatals on both the PHP 8.0
 * local box and the PHP 7.4 staging server. An .xlsx file is just a zip of XML
 * parts, so we assemble it directly with ZipArchive (available on PHP 5.x+).
 *
 * The package mirrors a real Excel-authored workbook as closely as possible
 * (shared strings, theme, doc properties, sheet views/dimension, cell styles)
 * because strict importers such as Google Sheets reject minimal/partial files.
 */
class JobsTemplateXlsxBuilder
{
    /** Rows the dropdown data-validation is applied to (header is row 1). */
    private const VALIDATION_ROWS = 200;

    /** @var string[] */
    private $countries;

    /** @var string[] */
    private $awards;

    /** @var string[] */
    private $perks;

    /** @var array<string, int> Shared-string value => index. */
    private $sharedStrings = [];

    /** @var string[] Ordered unique shared strings. */
    private $sharedStringList = [];

    /** @var int Total number of string cell references (not unique). */
    private $sharedStringCount = 0;

    public function __construct(array $countries = [], array $awards = [], array $perks = [])
    {
        $this->countries = $countries;
        $this->awards = $awards;
        $this->perks = $perks;
    }

    /**
     * Build the workbook and return the path to a temporary .xlsx file.
     */
    public function build(): string
    {
        $jobsRows = (new JobsTemplateJobsSheet($this->countries, $this->awards, $this->perks))->array();
        $allowedRows = (new JobsAllowedValuesSheet())->array();

        /* Render sheets first so the shared-string table is fully populated. */
        $sheet1 = $this->jobsSheetXml($jobsRows);
        $sheet2 = $this->simpleSheetXml($allowedRows);

        $path = tempnam(sys_get_temp_dir(), 'jobs_tpl_');

        $zip = new ZipArchive();
        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Unable to create the Excel template file.');
        }

        $zip->addFromString('[Content_Types].xml', $this->contentTypesXml());
        $zip->addFromString('_rels/.rels', $this->rootRelsXml());
        $zip->addFromString('docProps/core.xml', $this->coreXml());
        $zip->addFromString('docProps/app.xml', $this->appXml());
        $zip->addFromString('xl/workbook.xml', $this->workbookXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelsXml());
        $zip->addFromString('xl/theme/theme1.xml', $this->themeXml());
        $zip->addFromString('xl/styles.xml', $this->stylesXml());
        $zip->addFromString('xl/sharedStrings.xml', $this->sharedStringsXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet1);
        $zip->addFromString('xl/worksheets/sheet2.xml', $sheet2);

        $zip->close();

        return $path;
    }

    private function contentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet2.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/theme/theme1.xml" ContentType="application/vnd.openxmlformats-officedocument.theme+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '<Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>'
            . '<Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>'
            . '<Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>'
            . '</Types>';
    }

    private function rootRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>'
            . '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>'
            . '</Relationships>';
    }

    private function coreXml(): string
    {
        $now = gmdate('Y-m-d\TH:i:s\Z');

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties"'
            . ' xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/"'
            . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
            . '<dc:creator>ZNP</dc:creator>'
            . '<cp:lastModifiedBy>ZNP</cp:lastModifiedBy>'
            . '<dcterms:created xsi:type="dcterms:W3CDTF">' . $now . '</dcterms:created>'
            . '<dcterms:modified xsi:type="dcterms:W3CDTF">' . $now . '</dcterms:modified>'
            . '</cp:coreProperties>';
    }

    private function appXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties"'
            . ' xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">'
            . '<Application>Microsoft Excel</Application>'
            . '<DocSecurity>0</DocSecurity>'
            . '<ScaleCrop>false</ScaleCrop>'
            . '<HeadingPairs><vt:vector size="2" baseType="variant"><vt:variant><vt:lpstr>Worksheets</vt:lpstr></vt:variant><vt:variant><vt:i4>2</vt:i4></vt:variant></vt:vector></HeadingPairs>'
            . '<TitlesOfParts><vt:vector size="2" baseType="lpstr"><vt:lpstr>Jobs</vt:lpstr><vt:lpstr>Allowed Values</vt:lpstr></vt:vector></TitlesOfParts>'
            . '<Company></Company>'
            . '<LinksUpToDate>false</LinksUpToDate>'
            . '<SharedDoc>false</SharedDoc>'
            . '<HyperlinksChanged>false</HyperlinksChanged>'
            . '<AppVersion>16.0300</AppVersion>'
            . '</Properties>';
    }

    private function workbookXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<fileVersion appName="xl" lastEdited="7" lowestEdited="7" rupBuild="10000"/>'
            . '<workbookPr defaultThemeVersion="166925"/>'
            . '<bookViews><workbookView xWindow="0" yWindow="0" windowWidth="20000" windowHeight="10000"/></bookViews>'
            . '<sheets>'
            . '<sheet name="Jobs" sheetId="1" r:id="rId1"/>'
            . '<sheet name="Allowed Values" sheetId="2" r:id="rId2"/>'
            . '</sheets>'
            . '<calcPr calcId="0"/>'
            . '</workbook>';
    }

    private function workbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet2.xml"/>'
            . '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme" Target="theme/theme1.xml"/>'
            . '<Relationship Id="rId4" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '<Relationship Id="rId5" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>'
            . '</Relationships>';
    }

    private function stylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="1"><font><sz val="11"/><color theme="1"/><name val="Calibri"/><family val="2"/><scheme val="minor"/></font></fonts>'
            . '<fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/></cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '<dxfs count="0"/>'
            . '<tableStyles count="0" defaultTableStyle="TableStyleMedium2" defaultPivotStyle="PivotStyleLight16"/>'
            . '</styleSheet>';
    }

    private function themeXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<a:theme xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" name="Office Theme">'
            . '<a:themeElements>'
            . '<a:clrScheme name="Office">'
            . '<a:dk1><a:sysClr val="windowText" lastClr="000000"/></a:dk1>'
            . '<a:lt1><a:sysClr val="window" lastClr="FFFFFF"/></a:lt1>'
            . '<a:dk2><a:srgbClr val="44546A"/></a:dk2>'
            . '<a:lt2><a:srgbClr val="E7E6E6"/></a:lt2>'
            . '<a:accent1><a:srgbClr val="4472C4"/></a:accent1>'
            . '<a:accent2><a:srgbClr val="ED7D31"/></a:accent2>'
            . '<a:accent3><a:srgbClr val="A5A5A5"/></a:accent3>'
            . '<a:accent4><a:srgbClr val="FFC000"/></a:accent4>'
            . '<a:accent5><a:srgbClr val="5B9BD5"/></a:accent5>'
            . '<a:accent6><a:srgbClr val="70AD47"/></a:accent6>'
            . '<a:hlink><a:srgbClr val="0563C1"/></a:hlink>'
            . '<a:folHlink><a:srgbClr val="954F72"/></a:folHlink>'
            . '</a:clrScheme>'
            . '<a:fontScheme name="Office">'
            . '<a:majorFont><a:latin typeface="Calibri Light" panose="020F0302020204030204"/><a:ea typeface=""/><a:cs typeface=""/></a:majorFont>'
            . '<a:minorFont><a:latin typeface="Calibri" panose="020F0502020204030204"/><a:ea typeface=""/><a:cs typeface=""/></a:minorFont>'
            . '</a:fontScheme>'
            . '<a:fmtScheme name="Office">'
            . '<a:fillStyleLst>'
            . '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>'
            . '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>'
            . '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>'
            . '</a:fillStyleLst>'
            . '<a:lnStyleLst>'
            . '<a:ln w="6350" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"/></a:solidFill></a:ln>'
            . '<a:ln w="12700" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"/></a:solidFill></a:ln>'
            . '<a:ln w="19050" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"/></a:solidFill></a:ln>'
            . '</a:lnStyleLst>'
            . '<a:effectStyleLst>'
            . '<a:effectStyle><a:effectLst/></a:effectStyle>'
            . '<a:effectStyle><a:effectLst/></a:effectStyle>'
            . '<a:effectStyle><a:effectLst/></a:effectStyle>'
            . '</a:effectStyleLst>'
            . '<a:bgFillStyleLst>'
            . '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>'
            . '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>'
            . '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>'
            . '</a:bgFillStyleLst>'
            . '</a:fmtScheme>'
            . '</a:themeElements>'
            . '</a:theme>';
    }

    /**
     * The Jobs sheet, including dropdown data-validation on the enum columns.
     *
     * @param array<int, array<int, mixed>> $rows
     */
    private function jobsSheetXml(array $rows): string
    {
        $lastCol = $this->columnLetter(max(1, count(JobBulkUploadService::TEMPLATE_COLUMNS)));
        $dimension = 'A1:' . $lastCol . max(1, count($rows));

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<dimension ref="' . $dimension . '"/>'
            . '<sheetViews><sheetView tabSelected="1" workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/><selection pane="bottomLeft" activeCell="A2" sqref="A2"/></sheetView></sheetViews>'
            . '<sheetFormatPr defaultRowHeight="15"/>'
            . '<sheetData>' . $this->rowsXml($rows) . '</sheetData>'
            . $this->dataValidationsXml()
            . '</worksheet>';
    }

    /**
     * A plain sheet (no validations) for the Allowed Values reference tab.
     *
     * @param array<int, array<int, mixed>> $rows
     */
    private function simpleSheetXml(array $rows): string
    {
        $maxCols = 1;
        foreach ($rows as $row) {
            $maxCols = max($maxCols, count($row));
        }
        $dimension = 'A1:' . $this->columnLetter($maxCols) . max(1, count($rows));

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<dimension ref="' . $dimension . '"/>'
            . '<sheetViews><sheetView workbookViewId="0"/></sheetViews>'
            . '<sheetFormatPr defaultRowHeight="15"/>'
            . '<sheetData>' . $this->rowsXml($rows) . '</sheetData>'
            . '</worksheet>';
    }

    /**
     * @param array<int, array<int, mixed>> $rows
     */
    private function rowsXml(array $rows): string
    {
        $xml = '';
        $rowNumber = 0;

        foreach ($rows as $row) {
            $rowNumber++;
            $cells = '';

            $colIndex = 0;
            foreach (array_values($row) as $value) {
                $colIndex++;
                $cells .= $this->cellXml($this->columnLetter($colIndex) . $rowNumber, $value);
            }

            $xml .= '<row r="' . $rowNumber . '">' . $cells . '</row>';
        }

        return $xml;
    }

    /**
     * @param mixed $value
     */
    private function cellXml(string $ref, $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        if (is_int($value) || is_float($value)) {
            return '<c r="' . $ref . '"><v>' . $value . '</v></c>';
        }

        $index = $this->internString((string) $value);

        return '<c r="' . $ref . '" t="s"><v>' . $index . '</v></c>';
    }

    private function internString(string $value): int
    {
        $this->sharedStringCount++;

        if (array_key_exists($value, $this->sharedStrings)) {
            return $this->sharedStrings[$value];
        }

        $index = count($this->sharedStringList);
        $this->sharedStrings[$value] = $index;
        $this->sharedStringList[] = $value;

        return $index;
    }

    private function sharedStringsXml(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . $this->sharedStringCount . '" uniqueCount="' . count($this->sharedStringList) . '">';

        foreach ($this->sharedStringList as $value) {
            $escaped = htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
            $xml .= '<si><t xml:space="preserve">' . $escaped . '</t></si>';
        }

        return $xml . '</sst>';
    }

    private function dataValidationsXml(): string
    {
        $columns = JobBulkUploadService::TEMPLATE_COLUMNS;
        $dropdowns = JobBulkUploadService::dropdownColumns();
        $lastRow = self::VALIDATION_ROWS + 1;

        $validations = '';
        $count = 0;

        foreach ($dropdowns as $field => $values) {
            $position = array_search($field, $columns, true);
            if ($position === false) {
                continue;
            }

            $letter = $this->columnLetter($position + 1);
            $list = htmlspecialchars(
                '"' . implode(',', array_map('strval', $values)) . '"',
                ENT_QUOTES | ENT_XML1,
                'UTF-8'
            );
            $sqref = $letter . '2:' . $letter . $lastRow;

            $validations .= '<dataValidation type="list" allowBlank="1" showInputMessage="1" showErrorMessage="1"'
                . ' errorStyle="stop" error="Please choose a value from the dropdown list." errorTitle="Invalid value"'
                . ' sqref="' . $sqref . '">'
                . '<formula1>' . $list . '</formula1>'
                . '</dataValidation>';
            $count++;
        }

        if ($count === 0) {
            return '';
        }

        return '<dataValidations count="' . $count . '">' . $validations . '</dataValidations>';
    }

    private function columnLetter(int $index): string
    {
        $letter = '';

        while ($index > 0) {
            $index--;
            $letter = chr(65 + ($index % 26)) . $letter;
            $index = intdiv($index, 26);
        }

        return $letter;
    }
}
