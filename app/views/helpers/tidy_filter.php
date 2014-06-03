<?php 
class TidyFilterHelper extends AppHelper {
    function __construct()
    {
        ob_start();
    }
    
    function __destruct()
    {
        $output = ob_get_clean();
        $config = array('indent' => true, 'indent-spaces' => 5, 'output-xhtml' => true, 'doctype' => 'omit');
        $output = tidy_repair_string($output, $config, 'utf8');
        
        ob_start();
        echo $output;
    }
}
?>
