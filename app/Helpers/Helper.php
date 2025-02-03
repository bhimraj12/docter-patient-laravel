<?php

namespace App\Helpers;

use Carbon\Carbon;
use Throwable;

class Helper
{
    public static function getFormattedDate($date, $onlyTime = null)
    {
        if (! $date) {
            return null;
        }

        try {
            $date = Carbon::parse($date);

            if ($onlyTime) {
                return [
                    'time' => $date->format('H:i'),
                    'beautified_time' => $date->format('h:i A'),
                ];
            }

            return [
                'date' => $date->format('Y-m-d'),
                'beautified_date' => $date->format('M d Y'),
                'time' => $date->format('H:i'),
                'beautified_time' => $date->format('h:i A'),
                'formatted_date' => $date->format('m-d-Y'),
                'month_year' => $date->format('m-Y'),
            ];
        } catch (Throwable $e) {
            return null;
        }
    }
}