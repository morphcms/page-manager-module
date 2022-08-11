<?php

namespace Modules\PageManager\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\PageManager\Enums\PagePermission;
use Modules\PageManager\Enums\PageStatus;
use Modules\PageManager\Models\Page;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return ! $user || $user->can(PagePermission::ViewAny->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Page $page): bool
    {
        if (! $user) {
            return $page->status === PageStatus::Published;
        }

        return $user->can(PagePermission::View->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(PagePermission::Create->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Page $page): bool
    {
        return $user->can(PagePermission::Update->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Page $page): bool
    {
        return $user->can(PagePermission::Delete->value);
    }

    public function replicate(User $user, Page $page): bool
    {
        return $user->can(PagePermission::Replicate->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Page $page): bool
    {
        return $user->can(PagePermission::Restore->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Page $page): bool
    {
        return $user->can(PagePermission::Delete->value);
    }
}
