<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Actions\Fortify\Contracts\UpdatesUserPersonalInformation;

class UpdateUserPersonalInformation implements UpdatesUserPersonalInformation
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
            'name' => ['required', 'string', 'max:255'],
            'display_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validate();



        // if ($input['email'] !== $user->email &&
        //     $user instanceof MustVerifyEmail) {
        //     $this->updateVerifiedUser($user, $input);
        // } else {
        $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'display_name' => $input['display_name'],
                'phone_number' => $input['phone_number'],
            ])->save();
        // }
        return $user;
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
