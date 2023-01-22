<?php
require_once 'AddressExtractor.php';

$address = "290 Area BLVD APT 71, City, FL 12323";

$fields = (new AddressExtractor())->extractFields($address);
print_r($fields);

// Output
// Array
// (
//     [address1] => 290 AREA BLVD
//     [address2] => APT 71
//     [city] => City
//     [state] => FL
//     [zip] => 12323
//     [condo_unit_number] => 71
//     [condo_floor_number] => 1
// )

$address = "290 Area BLVD Unit 1231, City, FL 12323";

$fields = (new AddressExtractor())->extractFields($address);
print_r($fields);

// Output
// Array
// (
//     [address1] => 290 AREA BLVD
//     [address2] => UNIT 1231
//     [city] => City
//     [state] => FL
//     [zip] => 12323
//     [condo_unit_number] => 1231
//     [condo_floor_number] => 12
// )

$address = "290 Area BLVD, City, FL 12323";
$fields = (new AddressExtractor())->extractFields($address);
print_r($fields);

// Output
// Array
// (
//     [address1] => 290 AREA BLVD
//     [address2] =>
//     [city] => City
//     [state] => FL
//     [zip] => 12323
//     [condo_unit_number] =>
//     [condo_floor_number] =>
// )
