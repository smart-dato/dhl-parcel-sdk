<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class VasCashOnDeliveryData extends Data
{
    public function __construct(
        public string $transferNote1,
        public ?ValueData $amount = null,
        public ?BankAccountData $bankAccount = null,
        public ?string $accountReference = null,
        public ?string $transferNote2 = null,
    ) {}
}
