<?php

use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RecoveryCodeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorQrCodeController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ProfileInformationController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmedPasswordStatusController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\TwoFactorAuthenticatedSessionController;

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest:'.config('fortify.guard'),
        $limiter ? 'throttle:'.$limiter : null,
    ]));



    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.email');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.update');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        Route::post('/register', [RegisteredUserController::class, 'store']);
        // ->middleware(['guest:'.config('fortify.guard')]);
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'signed', 'throttle:'.$verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'throttle:'.$verificationLimiter])
            ->name('verification.send');
    }

    // Profile Information...
    // if (Features::enabled(Features::updateProfileInformation())) {
    //     Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
    //         ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
    //         ->name('user-profile-information.update');
    // }

    // shakil
    Route::put('/users/personal-info', [ProfileInformationController::class, 'updatePersonalInfo'])
    ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')]);

    // shakil
    Route::post('/users/profile', [ProfileInformationController::class, 'updateProfile'])
    ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')]);

    // Passwords Change
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/users/password', [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('user-password.update');
    }

    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')]);

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:'.config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
            ]));

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'password.confirm']
            : [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')];

        Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable');

        Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes');

        Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware);
    }
});
