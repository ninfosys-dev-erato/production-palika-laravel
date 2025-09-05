<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait SessionFlash
{
    use LivewireAlert;

    public function successFlash($message, $title = "Well Done !"): void
    {
        $this->alert('success', __($message), [
            'position' => 'centre',
            'title' => __($title),
            'toast' => false,
            'timer' => 3000,
            'showConfirmButton' => true,
            'confirmButtonText' => __('ok'), // or whatever text you want
            'text'=>$message
        ]);
    }
    public function successToast($message="Caution!"): void
    {
        $this->alert('success', __($message), [
            'position' => 'top-start',
            'title' => __($message),
            'toast' => true,
            'timer' => 3000,
        ]);
    }

    public function errorToast($message="Uh-oh!"): void
    {
        $this->alert('error', __($message), [
            'position' => 'top-start',
            'title' => __($message),
            'toast' => true,
            'timer' => 3000,
        ]);
    }

    public function errorFlash($message, $title = "Uh-oh!"): void
    {
        $this->alert('error', __($message), [
            'position' => 'centre',
            'title' => __($title),
            'toast' => false,
            'timer' => 3000,
            'showConfirmButton' => true,
            'confirmButtonText' => __('ok'), // or whatever text you want
            'text'=>$message
        ]);
    }

    public function warningToast($message = "Caution!"): void
    {
        $this->alert('warning', __($message), [
            'position' => 'top-start',
            'title' => __($message),
            'toast' => true,
            'timer' => 3000,
        ]);
    }

    public function warningFlash($message, $title = "Caution!"): void
    {
        $this->alert('warning', __($message), [
            'position' => 'centre',
            'title' => __($title),
            'toast' => false,
            'timer' => 3000,
            'showConfirmButton' => true,
            'confirmButtonText' => __('ok'), // or whatever text you want
            'text'=>$message
        ]);
    }

    public static function SUCCESS_FLASH($message, $title = "Well Done !"): void
    {
        Session::flash('alert', ['type' => 'success', 'title' => __($title), 'message' => $message]);
    }

    public static function ERROR_FLASH($message, $title = "Uh-oh!"): void
    {
        Session::flash('alert', ['type' => 'danger', 'title' => __($title), 'message' => $message]);
    }

    public static function WARNING_FLASH($message, $title = "Caution!"): void
    {
        Session::flash('alert', ['type' => 'warning', 'title' => __($title), 'message' => $message]);
    }
}
