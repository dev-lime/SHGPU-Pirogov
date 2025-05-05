<?php
class ClientModel extends BaseModel {
    protected static $tableName = 'clients';
    protected static $primaryKey = 'client_id';
    
    public static function createClient($connection, $data) {
        $fields = [
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'company_name' => $data['company_name']
        ];
        return parent::create($connection, $data, $fields);
    }
}
?>
