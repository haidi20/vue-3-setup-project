<?php

namespace App\Helpers;

use App\Models\Location;

class LocationHelper
{
    /**
     * Get location name by code
     * 
     * @param string $code Location code (e.g. '64.72')
     * @return string|null Location name
     */
    public static function getLocationName(string $code): ?string
    {
        $location = Location::where('code', $code)->first();
        return $location ? $location->name : null;
    }

    /**
     * Get all related locations based on provided code
     * 
     * @param string $code Location code (e.g. '31.74.06.1003')
     * @return array Related locations data
     */
    public static function getLocationHierarchy(string $code): array
    {
        $parts = explode('.', $code);
        $result = [];
        
        if (isset($parts[0])) {
            $provinceCode = $parts[0];
            $province = Location::where('code', $provinceCode)->first();
            if ($province) {
                $result['provinsi'] = [
                    'code' => $provinceCode,
                    'name' => $province->name
                ];
            }
        }
        
        if (isset($parts[0]) && isset($parts[1])) {
            $cityCode = $parts[0] . '.' . $parts[1];
            $city = Location::where('code', $cityCode)->first();
            if ($city) {
                $result['kota'] = [
                    'code' => $cityCode,
                    'name' => $city->name
                ];
            }
        }
        
        if (isset($parts[0]) && isset($parts[1]) && isset($parts[2])) {
            $districtCode = $parts[0] . '.' . $parts[1] . '.' . $parts[2];
            $district = Location::where('code', $districtCode)->first();
            if ($district) {
                $result['kecamatan'] = [
                    'code' => $districtCode,
                    'name' => $district->name
                ];
            }
        }
        
        if (isset($parts[0]) && isset($parts[1]) && isset($parts[2]) && isset($parts[3])) {
            $subDistrictCode = $parts[0] . '.' . $parts[1] . '.' . $parts[2] . '.' . $parts[3];
            $subDistrict = Location::where('code', $subDistrictCode)->first();
            if ($subDistrict) {
                $result['kelurahan'] = [
                    'code' => $subDistrictCode,
                    'name' => $subDistrict->name
                ];
            }
        }
        
        return $result;
    }
    
    /**
     * Format location code to full location name
     * 
     * @param string $code Location code
     * @return string Formatted location name
     */
    public static function formatLocation(string $code): string
    {
        $hierarchy = self::getLocationHierarchy($code);
        $parts = [];
        
        if (isset($hierarchy['kelurahan'])) {
            $parts[] = $hierarchy['kelurahan']['name'];
        }
        
        if (isset($hierarchy['kecamatan'])) {
            $parts[] = $hierarchy['kecamatan']['name'];
        }
        
        if (isset($hierarchy['kota'])) {
            $parts[] = $hierarchy['kota']['name'];
        }
        
        if (isset($hierarchy['provinsi'])) {
            $parts[] = $hierarchy['provinsi']['name'];
        }
        
        return implode(', ', array_reverse($parts));
    }
    
    /**
     * Get location data in JSON format
     * 
     * @param string $code Location code
     * @return string JSON string of location hierarchy
     */
    public static function getLocationJson(string $code): string
    {
        return json_encode(self::getLocationHierarchy($code), JSON_PRETTY_PRINT);
    }
}