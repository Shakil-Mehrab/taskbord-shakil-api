<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\Api\UserResource;
use App\Actions\Fortify\Contracts\UpdatesUserProfileInformation;
use App\Actions\Fortify\Contracts\UpdatesUserPersonalInformation;

class ProfileInformationController extends Controller
{
    public function update(
        Request $request,
        UpdatesUserProfileInformation $updater
    ) {
        $updater->update($request->user(), $request->all());
        return $request->wantsJson()
                    ? new UserResource($request->user())
                    : back()->with('status', 'profile-information-updated');
    }

    /**
    * updatePersonalInfo
    *
    * @param  mixed $user
    * @param  mixed $request
    * @return void
    */
    public function updatePersonalInfo(
        Request $request,
        UpdatesUserPersonalInformation $updater
    ) {
        $user=$updater->update($request->user(), $request->all());

        return new UserResource($user);
    }


    /**
     * updateProfile
     *
     * @param  mixed $request
     * @return void
     */
    public function updateProfile(
        Request $request,
        UpdatesUserProfileInformation $updater
    ) {
        $user=$updater->update($request->user(), $request->all());
        return new UserResource($user);
    }
}
