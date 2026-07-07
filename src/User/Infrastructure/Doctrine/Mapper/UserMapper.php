<?php

namespace App\User\Infrastructure\Doctrine\Mapper;

use App\User\Domain\Entity\User;
use App\User\Infrastructure\Doctrine\Entity\UserRecord;

final class UserMapper
{
    public static function toDomain(UserRecord $record): User
    {
        return new User(
            $record->id(),
            $record->name(),
            $record->email(),
            $record->password()
        );
    }

    public static function toRecord(User $user): UserRecord
    {
        $record = new UserRecord();

        $record->changeName($user->name());
        $record->changeEmail($user->email());
        $record->changePassword($user->password());

        return $record;
    }
}
