<?php
require_once("../../../config.inc.php");
require_once(APP_INC_PATH . "class.misc.php");

$compile_dir = APP_PATH . "templates_c";
$templates = Misc::getFileList($compile_dir);
foreach ($templates as $filename) {
    unlink($compile_dir . '/' . $filename);
}

?>
done