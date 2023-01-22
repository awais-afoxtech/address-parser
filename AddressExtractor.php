<?php

class AddressExtractor
{
    public function extractFields(string $address, array $field_names = ['address1', 'address2', 'city', 'state', 'zip']): array
    {
        $fields = array();

        // Split the address string into an array of lines
        $lines = explode(",", $address);

        // Extract the fields
        foreach ($field_names as $field_name) {
            switch ($field_name) {
                case 'address1':
                    $fields[$field_name] = trim($lines[0]);
                    break;
                case 'address2':
                    if (count($lines) > 1) {
                        $fields[$field_name] = trim($lines[1]);
                    } else {
                        $fields[$field_name] = "";
                    }
                    break;
                case 'city':
                    $city_state_zip = $lines[count($lines) - 1];
                    $parts = explode(", ", $city_state_zip);
                    $fields[$field_name] = trim($parts[0]);
                    break;
                case 'state':
                    $city_state_zip = $lines[count($lines) - 1];
                    $parts = explode(", ", $city_state_zip);
                    $state_zip = $parts[1];
                    $state_zip_parts = explode(" ", $state_zip);
                    $fields[$field_name] = trim($state_zip_parts[0]);
                    break;
                case 'zip':
                    $city_state_zip = $lines[count($lines) - 1];
                    $parts = explode(", ", $city_state_zip);
                    $state_zip = $parts[1];
                    $state_zip_parts = explode(" ", $state_zip);
                    $fields[$field_name] = trim($state_zip_parts[1]);
                    break;
            }
        }

        return $fields;
    }
}
