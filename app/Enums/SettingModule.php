<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum SettingModule
{
    case GENERAL;
    case MAIL;
    case INVOICE;

    /** Pages */
    case HOME;
    case CONTACT;
    case INQUIRY;
    case POST;
    case CUSTOMER;

    /**
     * Get storage optimized name.
     */
    public function getName(): string
    {
        return Str::of($this->name)->lower();
    }
}
