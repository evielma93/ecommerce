<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const SUCCESS = 1;
    const PENDING = 2;

    protected $guarded = ["id"];

    protected $casts = [
        "status" => "int"
    ];

    protected $appends = [
        "formatted_total_amount",
        "formatted_status"
    ];

    public function orderLines() {
        return $this->hasMany(OrderLine::class);
    }

    public function getFormattedTotalAmountAttribute() {
        if ($this->total_amount) {
            return format_currency_helper($this->total_amount, true);
        }
    }

    public function getFormattedStatusAttribute() {
        return $this->status === self::SUCCESS ? __("Procesado") : __("Pendiente");
    }
}
