<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\Category;
use Illuminate\Auth\Access\Response;
use App\Models\Item;
use App\Models\User;

class ItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Item $item): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user , Branch $branch , Category $category):bool
    {
        return $branch->user_id == $user->id && $category->branch_id == $branch->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Branch $branch , Category $category, Item $item):bool
    {
        return $branch->user_id == $user->id && $category->branch_id == $branch->id && $item->category_id == $category->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user,Branch $branch,Category $category, Item $item): bool
    {
        return $branch->user_id == $user->id && $category->branch_id == $branch->id && $item->category_id == $category->id;

    }

    public function deleteImage(User $user,Branch $branch,Category $category, Item $item): bool
    {
        return $branch->user_id == $user->id && $category->branch_id == $branch->id && $item->category_id == $category->id;

    }
    public function updateImage(User $user,Branch $branch,Category $category, Item $item): bool
    {
        return $branch->user_id == $user->id && $category->branch_id == $branch->id && $item->category_id == $category->id;
 
    }

    public function changeAvailable(User $user,Branch $branch,Category $category, Item $item): bool
    {
        return $branch->user_id == $user->id && $category->branch_id == $branch->id && $item->category_id == $category->id;
    }
}
