<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class CreateUpdateDeleteObserver
{
    public function creating(Model $model)
    {
        if (Auth::check()) {
            $model->created_by = Auth::id();
        }
    }

    public function updating(Model $model)
    {
        if (Auth::check() && ! app()->runningInConsole()) {
            // Check if the update is not caused by the deleting method
            $model->updated_by = Auth::id();
        }
    }

    public function deleting(Model $model)
    {
        if (Auth::check()) {
            $model->deleted_by = Auth::id();
            $model->save(); // Save the model when using soft deletes
        }

        // Delete related models if specified
        if (method_exists($model, 'deleteRelatedModels')) {
            $model->deleteRelatedModels(); // Use delete method on the relationship
        }
    }
}
