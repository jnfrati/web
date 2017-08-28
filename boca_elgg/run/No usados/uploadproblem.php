<?php
require_oonce('../boca/src/db.php');
if (isset($_POST["Submit3"]) && isset($_POST["problemnumber"]) && is_numeric($_POST["problemnumber"]) && 
    isset($_POST["problemname"]) && $_POST["problemname"] != "") {
	if(strpos(trim($_POST["problemname"]),' ')!==false) {
		$_POST["confirmation"]='';
		MSGError('Problem short name cannot have spaces');
	} else {
	if ($_POST["confirmation"] == "confirm") {
		if ($_FILES["probleminput"]["name"] != "") {
			$type=myhtmlspecialchars($_FILES["probleminput"]["type"]);
			$size=myhtmlspecialchars($_FILES["probleminput"]["size"]);
			$name=myhtmlspecialchars($_FILES["probleminput"]["name"]);
			$temp=myhtmlspecialchars($_FILES["probleminput"]["tmp_name"]);
			if (!is_uploaded_file($temp)) {
				IntrusionNotify("file upload problem.");
				ForceLoad("index.php");
			}
		} else $name = "";

		$param = array();
		$param['number'] = $_POST["problemnumber"];
		$param['name'] = trim($_POST["problemname"]);
		$param['inputfilename'] = $name;
		$param['inputfilepath'] = $temp;
		$param['fake'] = 'f';
		$param['colorname'] = $_POST["colorname"];
		$param['color'] = $_POST["color"];
		DBNewProblem (1, $param);
	}
	}
	ForceLoad("uploadproblem.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload Problem</title>
</head>
<body>

	<form name="form1" enctype="multipart/form-data" method="post" action="uploadproblem.php">
	  <input type=hidden name="confirmation" value="noconfirm" />
	  <script language="javascript">
	    function conf() {
				if(document.form1.problemname.value=="") {
					alert('Sorry, mandatory fields are empty');
				} else {
					var s2 = String(document.form1.probleminput.value);
					if(s2.length > 4) {
						if (confirm("Confirm?")) {
							document.form1.confirmation.value='confirm';
						}
					} else {
						alert('File package must be given');
					}
				}
	    }
	  </script>
	  <center>
	    <table border="0">
	      <tr>
	        <td width="35%" align=right>Number:</td>
	        <td width="65%">
	          <input type="text" name="problemnumber" value="" size="20" maxlength="20" />
	        </td>
	      </tr>
	      <tr>
		 <td width="35%" align=right>Short Name (usually a letter, no spaces):</td>
	        <td width="65%">
	          <input type="text" name="problemname" value="" size="20" maxlength="20" />
	        </td>
	      </tr>

	      <tr>
		 <td width="35%" align=right>Problem package (ZIP):</td>
	        <td width="65%">
	          <input type="file" name="probleminput" value="" size="40" />
	        </td>
	      </tr>

	      <tr>
	        <td width="35%" align=right>Color name:</td>
	        <td width="65%">
	          <input type="text" name="colorname" value="" size="40" maxlength="100" />
	        </td>
	      </tr>
	      <tr>
	        <td width="35%" align=right>Color (RGB HTML format):</td>
	        <td width="65%">
	          <input type="text" name="color" value="" size="6" maxlength="6" />
	        </td>
	      </tr>
	    </table>
	  </center>
	  <center>
	      <input type="submit" name="Submit3" value="Send" onClick="conf()">
	      <input type="reset" name="Submit4" value="Clear">
	  </center>
	</form>
</body>
</html>
