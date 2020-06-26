<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function coursesPurchased() {
        $orders = $this
        ->orders()
        ->where("status", Order::SUCCESS)
        ->with("orderLines")
        ->get();
        $productIds = [];
        if ($orders->count()) {
            foreach ($orders as $order) {
                foreach ($order->orderLines as $orderLine) {
                    array_push($productIds, $orderLine->product_id);
                }
            }
        }
        return $productIds;
    }
}
