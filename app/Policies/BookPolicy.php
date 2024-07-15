<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->type === 'admin';
    }

    public function view(User $user, Book $book): bool
    {
        return $user->type === 'admin' || $user->type === 'customer';
    }

    public function create(User $user): bool
    {
        return $user->type !== 'admin';
    }

    public function update(User $user, Book $book): bool
    {
        return $user->type === 'admin';
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->type === 'admin';
    }

    public function restore(User $user, Book $book): bool
    {
    }

    public function forceDelete(User $user, Book $book): bool
    {
    }
}
