<?php

namespace Rutatiina\Receipt\Services;

use Rutatiina\Receipt\Models\ReceiptItem;
use Rutatiina\Receipt\Models\ReceiptItemTax;

class ReceiptItemService
{
    public static $errors = [];

    public function __construct()
    {
        //
    }

    public static function store($data)
    {
        //print_r($data['items']); exit;

        //Save the items >> $data['items']
        foreach ($data['items'] as &$item)
        {
            $item['receipt_id'] = $data['id'];

            $itemTaxes = (is_array($item['taxes'])) ? $item['taxes'] : [] ;
            unset($item['taxes']);

            $itemModel = ReceiptItem::create($item);

            foreach ($itemTaxes as $tax)
            {
                //save the taxes attached to the item
                $itemTax = new ReceiptItemTax;
                $itemTax->tenant_id = $item['tenant_id'];
                $itemTax->receipt_id = $item['receipt_id'];
                $itemTax->receipt_item_id = $itemModel->id;
                $itemTax->tax_code = $tax['code'];
                $itemTax->amount = $tax['total'];
                $itemTax->taxable_amount = $tax['total']; //todo >> this is to be updated in future when taxes are propelly applied to receipts
                $itemTax->inclusive = $tax['inclusive'];
                $itemTax->exclusive = $tax['exclusive'];
                $itemTax->save();
            }
            unset($tax);
        }
        unset($item);

    }

}
