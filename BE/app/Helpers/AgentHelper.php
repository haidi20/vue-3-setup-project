<?php

namespace App\Helpers;

use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\OperatingSystem;
use DeviceDetector\Parser\Client\Browser;

class AgentHelper
{
    /**
     * Method getDeviceDetector
     *
     * @return mixed
     */
    protected static function getDeviceDetector()
    {
        $userAgent   = request()->header('User-Agent', '');
        $clientHints = ClientHints::factory($_SERVER);

        $dd = new DeviceDetector($userAgent, $clientHints);
        $dd->parse();

        return $dd;
    }

    public static function getClientInfo()
    {
        $dd = self::getDeviceDetector();
        return $dd->isBot() ? $dd->getBot() : $dd->getClient();
    }

    public static function getOsInfo()
    {
        return self::getDeviceDetector()->getOs();
    }

    public static function getDeviceDetails()
    {
        $dd = self::getDeviceDetector();
        return [
            'device' => $dd->getDeviceName(),
            'brand'  => $dd->getBrandName(),
            'model'  => $dd->getModel(),
        ];
    }

    public static function getOsFamily()
    {
        $dd = self::getDeviceDetector();
        return OperatingSystem::getOsFamily($dd->getOs('name'));
    }

    public static function getBrowserFamily()
    {
        $dd = self::getDeviceDetector();
        return Browser::getBrowserFamily($dd->getClient('name'));
    }

    public static function getClientIP()
    {
        return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    }

    public static function getClientIPv4()
    {
        $ip = self::getClientIP();
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? $ip : null;
    }

    public static function getClientIPv6()
    {
        $ip = self::getClientIP();
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? $ip : null;
    }

    public static function getClientIPType()
    {
        $ip = self::getClientIP();
        switch (true) {
            case filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4):
                return 'IPv4';
            case filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6):
                return 'IPv6';
            default:
                return 'Unknown';
        }
    }

    public static function getServerIP()
    {
        return $_SERVER['SERVER_ADDR'] ?? 'Unknown';
    }

    public static function getServerSoftware()
    {
        return $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
    }

    public static function getRequestHeaders()
    {
        return getallheaders();
    }

    public static function isBot()
    {
        return self::getDeviceDetector()->isBot();
    }

    public static function isSmartphone()
    {
        return self::getDeviceDetector()->isSmartphone();
    }

    public static function isFeaturePhone()
    {
        return self::getDeviceDetector()->isFeaturePhone();
    }

    public static function isTablet()
    {
        return self::getDeviceDetector()->isTablet();
    }

    public static function isPhablet()
    {
        return self::getDeviceDetector()->isPhablet();
    }

    public static function isConsole()
    {
        return self::getDeviceDetector()->isConsole();
    }

    public static function isPortableMediaPlayer()
    {
        return self::getDeviceDetector()->isPortableMediaPlayer();
    }

    public static function isCarBrowser()
    {
        return self::getDeviceDetector()->isCarBrowser();
    }

    public static function isTV()
    {
        return self::getDeviceDetector()->isTV();
    }

    public static function isSmartDisplay()
    {
        return self::getDeviceDetector()->isSmartDisplay();
    }

    public static function isSmartSpeaker()
    {
        return self::getDeviceDetector()->isSmartSpeaker();
    }

    public static function isCamera()
    {
        return self::getDeviceDetector()->isCamera();
    }

    public static function isWearable()
    {
        return self::getDeviceDetector()->isWearable();
    }

    public static function isPeripheral()
    {
        return self::getDeviceDetector()->isPeripheral();
    }

    public static function isBrowser()
    {
        return self::getDeviceDetector()->isBrowser();
    }

    public static function isFeedReader()
    {
        return self::getDeviceDetector()->isFeedReader();
    }

    public static function isMobileApp()
    {
        return self::getDeviceDetector()->isMobileApp();
    }

    public static function isPIM()
    {
        return self::getDeviceDetector()->isPIM();
    }

    public static function isLibrary()
    {
        return self::getDeviceDetector()->isLibrary();
    }

    public static function isMediaPlayer()
    {
        return self::getDeviceDetector()->isMediaPlayer();
    }

    public static function getDeviceType()
    {
        $dd = self::getDeviceDetector();
        switch (true) {
            case $dd->isSmartphone():
            case $dd->isFeaturePhone():
                return 'Mobile';
            case $dd->isTablet():
            case $dd->isPhablet():
                return 'Tablet';
            case $dd->isConsole():
            case $dd->isPortableMediaPlayer():
            case $dd->isCarBrowser():
            case $dd->isTV():
            case $dd->isSmartDisplay():
            case $dd->isSmartSpeaker():
                return 'Other Device';
            case $dd->isCamera():
            case $dd->isWearable():
            case $dd->isPeripheral():
                return 'Peripheral';
            default:
                return 'Desktop';
        }
    }

    public static function getClientAllIP()
    {
        return [
            'client_ip'       => AgentHelper::getClientIP(),
            'client_ipv4'     => AgentHelper::getClientIPv4(),
            'client_ipv6'     => AgentHelper::getClientIPv6(),
            'ip_type'         => AgentHelper::getClientIPType(),
            'server_ip'       => AgentHelper::getServerIP(),
            'server_software' => AgentHelper::getServerSoftware(),
        ];
    }

    public static function getClientIpOnly()
    {
        return [
            'client_ip'       => AgentHelper::getClientIP(),
            'client_ipv4'     => AgentHelper::getClientIPv4(),
            'client_ipv6'     => AgentHelper::getClientIPv6(),
            'ip_type'         => AgentHelper::getClientIPType(),
        ];
    }
}