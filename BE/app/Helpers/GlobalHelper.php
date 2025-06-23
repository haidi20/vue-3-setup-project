<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

if (!function_exists('laravel_version')) {
    /**
     * Get the current Laravel version.
     *
     * @return string
     */
    function laravel_version()
    {
        return \Illuminate\Foundation\Application::VERSION;
    }
}

if (!function_exists('php_version')) {
    /**
     * Get the current PHP version.
     *
     * @return string
     */
    function php_version()
    {
        return phpversion();
    }
}

if (!function_exists('checkExtensionMedia')) {
    /**
     * Check media type based on file extension.
     *
     * This function identifies whether a file is an image or video
     * based on the provided file extension.
     *
     * @param string $fileExtension File extension to be checked
     * @return string|null Returns 'image' for images, 'video' for videos, or null if extension is not recognized
     */
    function checkExtensionMedia($fileExtension)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv'];

        if (in_array(strtolower($fileExtension), $imageExtensions)) {
            return 'image';
        } elseif (in_array(strtolower($fileExtension), $videoExtensions)) {
            return 'video';
        }

        return null;
    }
}

if (!function_exists('isImage')) {
    /**
     * Method isImage
     *
     * @param string $filePath [explicite description]
     *
     * @return string
     */
    function isImage($filePath)
    {
        $imageExtensions = ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'];

        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return true;
        }

        return in_array(strtolower(pathinfo($filePath, PATHINFO_EXTENSION)), $imageExtensions);
    }
}

if (!function_exists('greeting')) {
    /**
     * Returns greeting based on current time in Indonesian
     *
     * @return string
     */
    function greeting()
    {
        date_default_timezone_set('Asia/Makassar');
        $hour = (int) now()->format('H');

        if ($hour >= 0 && $hour < 4) {
            return "Dini Hari";
        } elseif ($hour >= 4 && $hour < 10) {
            return "Pagi";
        } elseif ($hour >= 10 && $hour < 15) {
            return "Siang";
        } elseif ($hour >= 15 && $hour < 18) {
            return "Sore";
        } else {
            return "Malam";
        }
    }
}

if (!function_exists('localDate')) {
    /**
     * Method localDate
     *
     * @param string $date [explicite description]
     *
     * @return string
     */
    function localDate($date)
    {
        return Carbon::parse($date)->isoFormat('DD MMM Y');
    }
}

if (!function_exists('localDateTime')) {
    /**
     * Method localDateTime
     *
     * @param string $date [explicite description]
     *
     * @return string
     */
    function localDateTime($date)
    {
        return Carbon::parse($date)->isoFormat('DD MMM Y, HH:mm');
    }
}

if (!function_exists('hashPassword')) {
    /**
     * Method hashPassword
     *
     * @param mixed $password [explicite description]
     *
     * @return string
     */
    function hashPassword($password)
    {
        return Hash::make($password);
    }
}

if (!function_exists('uuid')) {
    /**
     * Method uuid
     *
     * @return string
     */
    function uuid()
    {
        return Str::uuid()->toString();
    }
}

if (!function_exists('randomString')) {
    /**
     * Method randomString
     *
     * @param int $length [explicite description]
     *
     * @return string
     */
    function randomString($length = 10)
    {
        return Str::random($length);
    }
}

if (!function_exists('randomCode')) {
    /**
     * Generate a random code by mixing random string and timestamp
     *
     * @param int $length Length of random string portion
     *
     * @return string
     */
    function randomCode($length = 10)
    {
        $randStr = randomString($length);
        $timeStr = (string)time();

        if (microtime(true) * 10000 % 3 == 0) {
            return $randStr . $timeStr;
        } elseif (microtime(true) * 10000 % 3 == 1) {
            return $timeStr . $randStr;
        } else {
            $result = '';
            $maxLen = max(strlen($randStr), strlen($timeStr));

            for ($i = 0; $i < $maxLen; $i++) {
                if ($i < strlen($randStr)) {
                    $result .= $randStr[$i];
                }
                if ($i < strlen($timeStr)) {
                    $result .= $timeStr[$i];
                }
            }

            return $result;
        }
    }
}

if (!function_exists('isValidPhone')) {
    /**
     * Method isValidPhone
     *
     * @param mixed $phone [explicite description]
     *
     * @return string
     */
    function isValidPhone($phone)
    {
        return preg_match('/^(\+62|62|0)8[1-9][0-9]{6,9}$/', $phone);
    }
}

if (!function_exists('slugify')) {
    /**
     * Method slugify
     *
     * @param string $string [explicite description]
     *
     * @return string
     */
    function slugify($string)
    {
        return Str::slug($string);
    }
}

if (!function_exists('formatBytes')) {
    /**
     * Method formatBytes
     *
     * @param int $bytes [explicite description]
     * @param int $precision [explicite description]
     *
     * @return string
     */
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$precision}f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
    }
}

if (!function_exists('isWeekend')) {
    /**
     * Method isWeekend
     *
     * @param string $date [explicite description]
     *
     * @return string
     */
    function isWeekend($date)
    {
        return in_array(Carbon::parse($date)->format('l'), ['Saturday', 'Sunday']);
    }
}

if (!function_exists('userData')) {
    /**
     * Get the authenticated user data.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function userData()
    {
        return auth()->guard('web')->user();
    }
}

if (!function_exists('current_route_name')) {
    /**
     * Get the current route name.
     *
     * @return string|null
     */
    function current_route_name()
    {
        return request()->route()->getName();
    }
}

if (!function_exists('is_dev_mode')) {
    /**
     * Check if the application is in development mode.
     *
     * @return bool
     */
    function is_dev_mode()
    {
        return app()->environment('local');
    }
}

if (!function_exists('is_json')) {
    /**
     * Check if a string is valid JSON.
     *
     * @param string $string
     * @return bool
     */
    function is_json($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('error_response')) {
    /**
     * Return a JSON error response.
     *
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    function error_response($message, $status = 400)
    {
        return response()->json(['error' => $message], $status);
    }
}

if (!function_exists('data_uri')) {
    /**
     * Convert a file to a data URI.
     *
     * @param string $file_path
     * @return string
     */
    function data_uri($file_path)
    {
        $mime = mime_content_type($file_path);
        $data = file_get_contents($file_path);
        return 'data:' . $mime . ';base64,' . base64_encode($data);
    }
}

if (!function_exists('calculate_age')) {
    /**
     * Calculate detailed age (years, months, days).
     *
     * @param string $birth_date
     * @return array
     */
    function calculate_age($birth_date)
    {
        $birthDate = Carbon::parse($birth_date);
        $now       = Carbon::now();

        $years  = $now->diffInYears($birthDate);
        $months = $now->diffInMonths($birthDate) % 12;
        $days   = $now->diffInDays($birthDate->copy()->addYears($years)->addMonths($months));

        return [
            'years'  => $years,
            'months' => $months,
            'days'   => $days,
        ];
    }
}

if (!function_exists('isAvailable')) {
    /**
     * Check if file exists in Storage public disk
     *
     * @param string|null $path Path relative to storage/app/public directory
     * @return bool
     */
    function isAvailable(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        try {
            return Storage::disk('public')->exists($path);
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('str_limit')) {
    /**
     * Limit the number of characters in a string.
     *
     * @param string|null $value The string to be limited
     * @param int $limit Maximum number of characters (default: 50)
     * @param string $end The string to append if truncated (default: '...')
     * @return string
     */
    function str_limit(?string $value, int $limit = 50, string $end = '...'): string
    {
        if (is_null($value)) {
            return '';
        }

        return Str::limit($value, $limit, $end);
    }
}
