<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Actions\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'bio' => ['string']
        ])->validate();

        if (request()->hasFile('thumb')) {
            $user->updateProfilePhoto($input['thumb']);
        }

        $user->forceFill([
                'bio' => $input['bio'],
            ])->save();

        return $user;
    }
}
