<?php

namespace LoopyLabs\CreditFinancing\Policies;

use App\Models\User;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreditApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('credit.applications.view');
    }

    public function view(User $user, CreditApplication $application): bool
    {
        return $user->hasPermissionTo('credit.applications.view') ||
               $this->isOwner($user, $application);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('credit.applications.create');
    }

    public function update(User $user, CreditApplication $application): bool
    {
        if (!$application->canBeEdited()) {
            return false;
        }

        return $user->hasPermissionTo('credit.applications.update') ||
               $this->isOwner($user, $application);
    }

    public function delete(User $user, CreditApplication $application): bool
    {
        if (!$application->canBeDeleted()) {
            return false;
        }

        return $user->hasPermissionTo('credit.applications.delete') ||
               $this->isOwner($user, $application);
    }

    public function approve(User $user, CreditApplication $application): bool
    {
        return $user->hasPermissionTo('credit.applications.approve');
    }

    public function deny(User $user, CreditApplication $application): bool
    {
        return $user->hasPermissionTo('credit.applications.approve');
    }

    public function submit(User $user, CreditApplication $application): bool
    {
        if ($application->status !== 'draft') {
            return false;
        }

        return $user->hasPermissionTo('credit.applications.update') ||
               $this->isOwner($user, $application);
    }

    protected function isOwner(User $user, CreditApplication $application): bool
    {
        return $application->created_by === $user->id;
    }
}