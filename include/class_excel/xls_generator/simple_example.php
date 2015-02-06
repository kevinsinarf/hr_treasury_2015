<?

//ini_set("include_path",ini_get("include_path").";.;");

// UNCLUDING THE THE MAIN CLASS FILE
require_once("cl_xls_generator.php");

// CREATING XML TEMPLATE
$xml_template = "<?xml version=\"1.0\"?>
<Workbook>
<Styles>
    <style name=\"heading\" bold=\"1\" valign=\"middle\" align=\"center\" />
</Styles>
<Worksheet name=\"Simple Demo\">
    <Table>
        <Row height=\"25\">
            <cell width=\"40\" style=\"heading\" >Hello</cell>
            <cell width=\"50\" style=\"heading\" >World!</cell>
        </Row>
        <Row height=\"25\">
            <cell width=\"40\" style=\"heading\" >Current date is - </cell>
            <cell width=\"50\" num_format=\" d mmmm yyy hh:mm:ss\" >".Unix2Excel(time())."</cell>
        </Row>
    </Table>
</Worksheet>
</Workbook>
";

// TEMP DIRECTORY PATH - !!! YOU SHOULD HAVE THE WRITING PERMISSIONS TO IT
$temp_dir = "";

// RESULT FILE NAME
$file_name = "xml_test.xls";

// MAIN CLASS CALL
$xls = new xls($xml_template,$file_name,"xls_config.inc",$temp_dir);


// PASSING THE GENERATED FILE TO THE USER
header("Content-Type: application/X-MS-Excel; name=\"$file_name\"");
header("Content-Disposition: attachment; filename=\"$file_name\"");

$fh=fopen($file_name, "rb");
fpassthru($fh);
unlink($file_name);

?>