<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class BankAccountData extends Data
{
    public function __construct(
        public string $accountHolder,
        public string $iban,
        public ?string $bankName = null,
        public ?string $bic = null,
    ) {}
}
