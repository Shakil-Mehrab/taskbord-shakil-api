<?php
namespace App\Http\Controllers\Auth;

use App\Teamstation\Teamstation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        return  [
            'tokens' => $request->user()->tokens->map(
                function ($token) {
                    return $token->toArray() + [
                        'last_used_ago' => optional($token->last_used_at)->diffForHumans(),
                    ];
                }
            ),
        ];
    }
    /**
     * Create a new API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $token = $request->user()->createToken(
            $request->name
        );

        return $token;
    }

    /**
     * Update the given API token's permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tokenId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $tokenId)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);

        $token = $request->user()->tokens()->where('id', $tokenId)->firstOrFail();

        // $token->forceFill([
        //     'abilities' => Teamstation::validPermissions($request->input('permissions', [])),
        // ])->save();

        return $token;
    }

    /**
     * Delete the given API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tokenId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $tokenId)
    {
        return $request->user()->tokens()->where('id', $tokenId)->first()->delete();
    }
}