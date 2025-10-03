<?php

namespace App\Services;

use App\Models\Target;
use Carbon\Carbon;

class TargetStatisticService
{

    public static function statusesAll(Target $target)
    {
        $targetStatuses = $target->targetStatus;
        $statuses = [];

        foreach ($targetStatuses as $targetStatus) {
            if ($targetStatus->start_date && $targetStatus->stop_date) {

                $diff = $targetStatus->start_date->diff($targetStatus->stop_date);
                $statuses[] = [
                    'stop'  => $targetStatus->stop_date,
                    'start' => $targetStatus->start_date,
                    'downtime' => $diff->format('%h:%I'),
                ];
            } elseif (!$targetStatus->start_date && $targetStatus->stop_date) {
                $statuses[] = [
                    'stop'  => $targetStatus->stop_date,
                    'start' => $targetStatus->start_date,
                    'downtime' => 'doesnt work',
                ];
            }
        }

        return $statuses;
    }

    public static function statusesByDays(Target $target, $lastDays=null)
    {
        $date = $lastDays ? Carbon::now()->subDays($lastDays) : null;

        $targetStatuses = $date
            ? $target->targetStatus()->where('stop_date', '>', $date)->get()
            : $target->targetStatus;
        $statuses = [];

        foreach ($targetStatuses as $targetStatus) {
            if ($targetStatus->start_date && $targetStatus->stop_date) {

                $diff = $targetStatus->start_date->diff($targetStatus->stop_date);
                $statuses[] = [
                    'stop'  => $targetStatus->stop_date,
                    'start' => $targetStatus->start_date,
                    'downtime' => $diff->format('%h:%I'),
                ];
            } elseif (!$targetStatus->start_date && $targetStatus->stop_date) {
                $statuses[] = [
                    'stop'  => $targetStatus->stop_date,
                    'start' => $targetStatus->start_date,
                    'downtime' => 'doesnt work',
                ];
            }
        }

        return $statuses;
    }
}