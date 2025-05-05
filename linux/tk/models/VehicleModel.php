<?php
class VehicleModel extends BaseModel {
    protected static $tableName = 'vehicles';
    protected static $primaryKey = 'vehicle_id';
    
    public static function create($connection, $data) {
        $fields = [
            'plate_number' => $data['plate_number'],
            'model' => $data['model'],
            'capacity_kg' => $data['capacity_kg'],
            'status' => $data['status'] ?? 'available'
        ];
        return parent::create($connection, $data, $fields);
    }
}
?>
