<?php

namespace Rutatiina\Receipt\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Rutatiina\Tenant\Scopes\TenantIdScope;

class ReceiptItem extends Model
{
    use LogsActivity;

    protected static $logName = 'TxnItem';
    protected static $logFillable = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at'];
    protected static $logOnlyDirty = true;

    protected $connection = 'tenant';

    protected $table = 'rg_receipt_items';

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

    public function receipt()
    {
        return $this->hasOne('Rutatiina\Receipt\Models\Receipt', 'id', 'receipt_id');
    }

    public function invoice()
    {
        return $this->hasOne('Rutatiina\Invoice\Models\Invoice', 'id', 'invoice_id');
    }

    public function taxes()
    {
        return $this->hasMany('Rutatiina\Receipt\Models\ReceiptItemTax', 'receipt_item_id', 'id');
    }

}
