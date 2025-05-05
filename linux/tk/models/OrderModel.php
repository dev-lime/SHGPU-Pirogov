<?php
class OrderModel extends BaseModel {
    protected static $tableName = 'orders';
    protected static $primaryKey = 'order_id';
    
    public static function create($connection, $data) {
        $fields = [
            'client_id' => $data['client_id'],
            'dispatcher_id' => $data['dispatcher_id'],
            'driver_id' => $data['driver_id'],
            'vehicle_id' => $data['vehicle_id'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'cargo_description' => $data['cargo_description'],
            'weight_kg' => $data['weight_kg'],
            'delivery_date' => $data['delivery_date']
        ];
        return parent::create($connection, $data, $fields);
    }
}
?>
