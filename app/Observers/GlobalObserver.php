<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GlobalObserver
{
    public function created(Model $model)
    {
        activity('model-changes')
            ->performedOn($model)
            ->causedBy(Auth::user())
            ->withProperties(['attributes' => $model->getAttributes()])
            ->log('created');
    }

    public function updated(Model $model)
    {
        activity('model-changes')
            ->performedOn($model)
            ->causedBy(Auth::user())
            ->withProperties(['attributes' => $model->getChanges()])
            ->log('updated');
    }

    public function deleted(Model $model)
    {
        activity('model-changes')
            ->performedOn($model)
            ->causedBy(Auth::user())
            ->log('deleted');
    }
}
