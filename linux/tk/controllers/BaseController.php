<?php
abstract class BaseController {
    protected static $modelClass;
    protected static $successMessage;
    
    public static function handleCreate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /tk/index.php");
            exit;
        }
        
        try {
            $con = getDBConnection();
            $data = static::prepareData($_POST);
            $result = static::$modelClass::create($con, $data);
            
            if ($result) {
                header("Location: /tk/index.php?success=" . static::$successMessage);
            } else {
                header("Location: /tk/index.php?error=create_failed");
            }
        } catch (Exception $e) {
            header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
        }
    }
    
    abstract protected static function prepareData($postData);
}
?>
