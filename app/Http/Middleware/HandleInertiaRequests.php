<?php

namespace App\Http\Middleware;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'permissions' => [
                    'canViewBooks' => Gate::allows('view', [User::class, Book::class]),
                    'canCreateBooks' => Gate::allows('create', Book::class),
                    'canUpdateBooks' => Gate::allows('update', [ User::class, Book::class]),
                    'canDeleteBooks' => Gate::allows('delete', [ User::class, Book::class]),
                ],
            ],
        ];
    }
}
