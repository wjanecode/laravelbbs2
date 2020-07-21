<?php
namespace Tests\Traits;

use App\Models\User;
trait JWTToken
{
    public function headerWithToken( User $user ) {
        $token = auth('api')->fromUser($user);
        $this->withHeaders(['Authorization'=>'Bearer ' . $token]);
        return $this;
    }
}
