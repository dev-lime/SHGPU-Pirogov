<?php
class DispatcherModel {
    public static function getAllDispatchers() {
        $con = getDBConnection();
        $sql = "SELECT * FROM dispatchers";
        $result = pg_query($con, $sql);
        $dispatchers = [];
        while ($row = pg_fetch_assoc($result)) {
            $dispatchers[] = $row;
        }
        pg_close($con);
        return $dispatchers;
    }
}
?>
