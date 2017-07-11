<!DOCTYPE html>
<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,500,700' rel='stylesheet' type='text/css'>
	<title>GaPBIT</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/favicon.ico">
</head>
<body>
  <?php
		function read_docx($filename){

	    $striped_content = '';
	    $content = '';

	    if(!$filename || !file_exists($filename)) return false;

	    $zip = zip_open($filename);
	    if (!$zip || is_numeric($zip)) return false;

	    while ($zip_entry = zip_read($zip)) {

	        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

	        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

	        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

	        zip_entry_close($zip_entry);
	    }
	    zip_close($zip);
	    //$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
	    //$content = str_replace('</w:r></w:p>', "\r\n", $content);
	    $striped_content = strip_tags($content);

	    return $striped_content;
		}

		echo read_docx("data/EfficacyPatternsSummary_v2.docx");
  ?>
</body>
</html>
