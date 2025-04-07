<?php

namespace App\Core;

class FlashView {
    public static function render(): void {
        Session::start();
        $types = ['success', 'error', 'warning', 'info'];
        $colors = [
            'error' => 'bg-danger bg-soft border-danger',
            'warning' => 'bg-warning bg-soft border-warning',
            'info' => 'bg-info bg-soft border-info',
            'success' => 'bg-success bg-soft border-success',
        ];
        
        foreach ($types as $type) {
            $message = Session::getFlash($type);
            $color = $colors[$type];
            if ($message) {
                echo "<div class='alert alert-{$type} $color m-0'>{$message}</div>";
            }
        }
    }
}
