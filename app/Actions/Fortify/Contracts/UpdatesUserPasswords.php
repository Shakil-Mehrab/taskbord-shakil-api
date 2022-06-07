<?php

namespace App\Actions\Fortify\Contracts;

interface UpdatesUserPasswords
{
    public function update($user, array $input);
}
