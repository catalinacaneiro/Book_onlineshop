<?php 
require_once(__DIR__.'/../vendor/autoload.php');
require_once(__DIR__.'/../repositories/freightRepository.php');
require_once(__DIR__.'/../config/database.php');

$db = new Database();
$pdo = $db->getPdo();
$freight = new FreightRepository($pdo);


//DEPRECATION WARNING!---> strunta i den varning, den är under arbete och eventuell byter namn. Den har försvunnit. 
$csv = League\Csv\Reader::From(__DIR__.'/frakt.csv', 'r');

$csv->setHeaderOffSet(0); // Första raden på frakt.csv fil  det är rubriker. 


foreach ($csv->getRecords() as $record) {

    $existingRule = $freight->getFreightRuleByZoneCode($record['zon_kod']);

    if ($existingRule) {

        $freight->updateFreightRule(
            $existingRule['id'],
            $record['zon_kod'],
            $record['zon_namn'],
            (float)$record['basavgift_sek'],
            (float)$record['vikt_multiplikator_sek_per_kg'],
            (float)$record['fri_frakt_grans_sek']
        );

    } else {

        $freight->insertFreightRule(
            $record['zon_kod'], 
            $record['zon_namn'],
            (float)$record['basavgift_sek'],
            (float)$record['vikt_multiplikator_sek_per_kg'],
            (float)$record['fri_frakt_grans_sek']
        );
    }
}

echo "Freight rules synced!";

?>