<?php

namespace App\Http\Middleware;

use App\Models\Book;
use App\Models\Order;
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
        $permissions = [];
        if (auth()->check()) {
            $permissions = [
                'canViewBooks' => auth()->user()->type === 'customer',
                'canManageBooks' => auth()->user()->type === 'admin',
                'canViewCart' => auth()->user()->type === 'customer',
                'canManageCart' => auth()->user()->type === 'admin',
                'canViewOrders' => auth()->user()->type === 'customer',
                'canManageOrders' => auth()->user()->type === 'admin',
            ];
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'permissions' => $permissions,
            ],
        ];
    }
}
