<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $array = array_merge(parent::share($request), [
            'jetstream' => '',
            'user' => $request->user() ?
                array_merge($request->user()->only('id', 'first_name', 'last_name', 'email'),
                    [
                        'district' => $request->user()->district->name,
                        'permissions' => $request->user()->getAllPermissions()->map(fn ($item) => $item->name)->all()
                    ]) : null,
            'flash' => [
                'event' => fn () => $request->session()->get('event'),
                'message' => fn () => $request->session()->get('message')
            ],
        ]);

        return $array;
    }
}
