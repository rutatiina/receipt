<?php

namespace Rutatiina\Receipt\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Rutatiina\Tenant\Scopes\TenantIdScope;

class ReceiptItemTax extends Model
{
    use LogsActivity;

    protected static $logName = 'TxnItem';
    protected static $logFillable = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at'];
    protected static $logOnlyDirty = true;

    protected $connection = 'tenant';

    protected $table = 'rg_receipt_item_taxes';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantIdScope);
    }

    public function getTaxesAttribute($value)
    {
        $_array_ = json_decode($value);
        if (is_array($_array_)) {
            return $_array_;
        } else {
            return [];
        }
    }

    public function tax()
    {
        return $this->hasOne('Rutatiina\Tax\Models\Tax', 'code', 'tax_code');
    }

    public function receipt()
    {
        return $this->belongsTo('Rutatiina\Receipt\Models\Receipt', 'receipt_id', 'id');
    }

    public function receipt_item()
    {
        return $this->belongsTo('Rutatiina\Receipt\Models\ReceiptItem', 'receipt_item_id', 'id');
    }

}
