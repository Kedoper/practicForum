<?php


class Privileges
{

    /* Общие права */
    const THREADS_READ = 1 << 0;
    const THREADS_LIKE = 1 << 1;
    const THREADS_DISLIKE = 1 << 2;
    const THREADS_ADDTOFAV = 1 << 3;
    const THREADS_REPORT = 1 << 4;
    const THREADS_COMMENT = 1 << 5;

    /* Пользовательские права */
    protected const USER_THREADS_CREATE = 1 << 6;
    protected const USER_THREADS_EDIT = 1 << 7;


    static function getDefaultMask(): int
    {
        return
            self::THREADS_READ |
            self::THREADS_LIKE |
            self::THREADS_DISLIKE |
            self::THREADS_ADDTOFAV |
            self::THREADS_REPORT |
            self::THREADS_COMMENT |
            self::USER_THREADS_CREATE |
            self::USER_THREADS_EDIT;
    }

    static function getMask($privilegesList = []): int
    {
        $tmpMask = 0;
        foreach ($privilegesList as $item) {
            $tmpMask = $item | $tmpMask;
        }
        return $tmpMask;
    }
}

