<?php

namespace App\Telegraph;

use App\Models\Target;

class ClientMessages
{
    /**
     * @param Target $target
     * @param string $status
     * @param string|null $errorInfo
     * @return string
     */
    public static function targetDown(Target $target, string $status, string|null $errorInfo): string
    {
        $clientMessage = [
            'text'    => $target->url . ' unavailable!' ,
            'message' => 'Status: ' . Target::getStatusText($status),
        ];

        if ($errorInfo) {
            $clientMessage['info'] = $errorInfo;
        }

        return <<<HTML
            <b>ℹ️ {$clientMessage['text']}</b>
            {$clientMessage['message']}
            {$clientMessage['info']}
            HTML;
    }

    /**
     * @param Target $target
     * @param string $status
     * @return string
     */
    public static function targetRestore(Target $target, string $status): string
    {
        $clientMessage = [
            'text'    => '🚀 ' . $target->url . ' available!' ,
            'message' => 'Status: ' . Target::getStatusText($status),
        ];

        return <<<HTML
            {$clientMessage['text']}!
            {$clientMessage['message']}
            HTML;
    }

    public static function targetStatistic(array $targetStatuses)
    {
        $statuses = [];

        foreach ($targetStatuses as $targetStatus) {

            if ($targetStatus['start'] && $targetStatus['stop']) {
                $diff = $targetStatus['start']->diff($targetStatus['stop']);
                $statuses[] = sprintf(
                    "❌ from <b>%s</b> to <b>%s</b> (⏱ %s)",
                    $targetStatus['start'],
                    $targetStatus['stop'],
                    $diff->format('%h:%I')
                );
            } elseif ($targetStatus['stop'] && !$targetStatus['start']) {
                $statuses[] = sprintf(
                    "❌ Was offline until <b>%s</b> (doesn’t work)",
                    $targetStatus['stop']
                );
            }
        }

        $message = <<<HTML
            <b>ℹ️ Target Down Statistic</b>
            HTML;

        if (!empty($statuses)) {
            $message .= "\n\n" . implode("\n", $statuses);
        } else {
            $message .= "\n\n✅ No downtime recorded.";
        }

        return $message;
    }

    public static function controlTargetDown(Target $target)
    {
        return  [
            'text'    => 'Resource available again',
            'message' => $target->url . ' is working again!',
        ];
    }

    public static function controlTargetRestore(Target $target)
    {
        return [
            'text' => 'Resource unavailable',
            'message' => $target->url . ' isn’t working!',
        ];
    }





    public static function testTargetDownMessage(Target $target)
    {

    }
}