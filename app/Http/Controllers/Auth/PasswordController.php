<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\Api\UserResource;
use App\Actions\Fortify\Contracts\UpdatesUserPasswords;
use App\Actions\Fortify\Contracts\PasswordUpdateResponse;

class PasswordController extends Controller
{
    public function update(Request $request, UpdatesUserPasswords $updater)
    {
        $user=$updater->update($request->user(), $request->all());

        // return app(PasswordUpdateResponse::class);
        return new UserResource($user);
    }
}
