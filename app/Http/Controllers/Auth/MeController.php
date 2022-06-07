<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\UpdateProfileInformation;
use App\Actions\Fortify\UpdateUserPersonalInformation;

class MeController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * me
     *
     * @return void
     */
    public function me()
    {
        return new UserResource(auth()->user());
    }
}
