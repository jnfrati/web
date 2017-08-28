<?php
//$fileName = $_REQUEST['fn'];
//$fileContent = $_REQUEST['fc'];

$extension = strtolower($_POST['language']);
$nombre = strtolower($_POST['problem']);

$filename=$nombre.'.'.$extension;
$clase = substr($filename, 0, strrpos($filename, 46));
$extension = strrchr(strtolower($filename), 46); 

if($extension == ".c"){
	$fileContent = 
	"#include <stdio.h>

int main(int argc, char *argv[]){
    // tu código aquí...
    return 0;
}";
}

else if($extension == ".java"){
	
		$fileContent = 
"import java.util.*;
import java.io.*;

public class $clase{
	public static void main(String[] args){
    	// tu código aquí...
	}
}";
}

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=$filename");

echo $fileContent;

