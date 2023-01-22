<?php
$address = "123 Main St, Suite 200, Anytown USA 12345";

$fields = (new AddressExtractor())->extractFields($address);
print_r($fields);

// Output
// Array (
//     [address1] => 123 Main St
//     [address2] => Suite 200
//     [city] => Anytown
//     [state] => USA
//     [zip] => 12345
// )

$fields = (new AddressExtractor())->extractFields($address, ['city', 'state']);
print_r($fields);

// Output
// Array (
//     [city] => Anytown
//     [state] => USA
// )

// Output
$fields = (new AddressExtractor())->extractFields($address, ['address1', 'address2', 'city', 'state']);
print_r($fields);

// Array (
//     [address1] => 123 Main St
//     [address2] => Suite 200
//     [city] => Anytown
//     [state] => USA
// )
