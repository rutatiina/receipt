<?php

namespace Rutatiina\Receipt\Services;

use Rutatiina\Receipt\Models\ReceiptItem;
use Rutatiina\Receipt\Models\ReceiptItemTax;
use Rutatiina\Receipt\Models\ReceiptLedger;

class ReceiptLedgersService
{
    public static $errors = [];

    public function __construct()
    {
        //
    }

    public static function store($data)
    {
        foreach ($data['ledgers'] as &$ledger)
        {
            $ledger['retainer_invoice_id'] = $data['id'];
            ReceiptLedger::create($ledger);
        }
        unset($ledger);

    }

}
