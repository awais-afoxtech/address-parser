<?php

class AddressExtractor
{
    public function extractFields(string $address, array $field_names = ['address1', 'address2', 'city', 'state', 'zip', 'condo_unit_number', 'condo_floor_number']): array
    {
        try {
            $fields = array();

            // Split the address string into an array of lines
            $lines = explode(",", $address);

            if (count($lines) !== 3) {
                throw new Exception("Invalid Address!");
            }

            // Extract the fields
            foreach ($field_names as $field_name) {
                switch ($field_name) {
                    case 'address1':
                        $fields[$field_name] = self::getAddress1($address);
                        break;
                    case 'address2':
                        $fields[$field_name] = self::getAddress2($address) ?? '';
                        break;
                    case 'city':
                        $fields[$field_name] = self::trimSpaces($lines[count($lines) - 2]);
                        break;
                    case 'state':
                        $fields[$field_name] = self::trimSpaces(explode(' ', self::trimSpaces($lines[count($lines) - 1]))[0]);
                        break;
                    case 'zip':
                        $fields[$field_name] = self::trimSpaces(explode(' ', self::trimSpaces($lines[count($lines) - 1]))[1]);
                        break;
                    case 'condo_unit_number':
                        $fields[$field_name] = self::getCondoUnitNumber($address);
                        break;
                    case 'condo_floor_number':
                        $fields[$field_name] = self::getCondoFloorNumber($address);
                        break;
                }
            }
            return $fields;
        } catch (Exception | Error $e) {
            throw new Exception($e->getMessage());
        }
    }

    protected static function getAddress1(string $address)
    {
        try {
            $address = strtolower($address);

            $address1 = explode(',', $address)[0] ?? null;

            if (!$address1) {
                return null;
            }

            $address1 = self::trimSpaces($address1);

            $address1 = strtoupper($address1);

            $address2 = self::getAddress2($address);

            if (!$address2) {
                return $address1;
            }

            $address1 = str_replace($address2, "", $address1);
            $address1 = self::trimSpaces($address1);

            return $address1;

        } catch (Exception | Error $e) {
            throw new Exception($e->getMessage());
        }
    }

    protected static function getAddress2(?string $address = null)
    {
        try {
            $address = strtolower($address);

            $address1 = explode(',', $address)[0] ?? null;

            if (!$address1) {
                return null;
            }

            $address1 = strtolower($address1);

            $address2Indicators = ['#', 'apt', 'suite', 'unit'];
            $indicatorInAddress1 = null;

            foreach ($address2Indicators as $indicator) {
                if (str_contains($address1, $indicator)) {
                    $indicatorInAddress1 = $indicator;
                }
            }

            if (!$indicatorInAddress1) {
                return null;
            }

            $address2 = explode($indicatorInAddress1, $address1)[1];

            $address2 = self::trimSpaces("$indicatorInAddress1 $address2");

            $address2 = strtoupper($address2);

            return $address2;

        } catch (Exception | Error $e) {
            throw new Exception($e->getMessage());
        }
    }

    protected static function getCondoUnitNumber(?string $address = null)
    {
        try {
            $address2 = self::getAddress2($address);

            $condoUnitNumber = explode(' ', $address2)[1] ?? null;

            if (!$condoUnitNumber) {
                return null;
            }

            return $condoUnitNumber;

        } catch (Exception | Error $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getCondoFloorNumber(?string $address = null)
    {
        $condoUnitNumber = (int) (self::getCondoUnitNumber($address));

        if (!$condoUnitNumber) {
            return null;
        }

        $floor = floor($condoUnitNumber / 100);
        return $floor == 0 ? 1 : $floor;
    }

    protected static function trimSpaces(?string $str = null)
    {
        if (!$str) {
            return null;
        }

        return trim(preg_replace('/\s+/', ' ', $str));
    }

}
