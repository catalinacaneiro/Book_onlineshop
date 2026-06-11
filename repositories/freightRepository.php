<?php
require_once("Models/freight_rules.php");

class FreightRepository
{
    private PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getFreightRuleByZoneCode(string $zoneCode)
{
    $sql = "SELECT * FROM freight_rules WHERE zone_code = :zone_code";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':zone_code' => $zoneCode
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function getAllFreightRules(): array
    {
        $sql = "SELECT * FROM freight_rules";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, "FreightRules");
    }

    public function insertFreightRule($zone_code, $zone_name, $base_fee, $weight_modifier, $free_shipping_threshold): bool
    {
        $sql = "INSERT INTO freight_rules 
                (zone_code, zone_name, base_fee, weight_modifier, free_shipping_threshold)
                VALUES 
                (:zone_code, :zone_name, :base_fee, :weight_modifier, :free_shipping_threshold)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":zone_code" => $zone_code,
            ":zone_name" => $zone_name,
            ":base_fee" => $base_fee,
            ":weight_modifier" => $weight_modifier,
            ":free_shipping_threshold" => $free_shipping_threshold
        ]);
    }

    public function updateFreightRule($id, $zone_code, $zone_name, $base_fee, $weight_modifier, $free_shipping_threshold): bool
    {
        $sql = "UPDATE freight_rules
                SET zone_code = :zone_code,
                    zone_name = :zone_name,
                    base_fee = :base_fee,
                    weight_modifier = :weight_modifier,
                    free_shipping_threshold = :free_shipping_threshold
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":zone_code" => $zone_code,
            ":zone_name" => $zone_name,
            ":base_fee" => $base_fee,
            ":weight_modifier" => $weight_modifier,
            ":free_shipping_threshold" => $free_shipping_threshold
        ]);
    }
}

?>