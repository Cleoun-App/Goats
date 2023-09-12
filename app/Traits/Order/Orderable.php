<?php

namespace App\Traits\Order;

use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\OrderNotification;

trait Orderable
{
    public function orders() {
        if($this instanceof Service) {
            return $this->hasMany(Order::class, 'service_id');
        }
    }

    public function bookingBy(User $user, $name, $message): Order
    {
        if($this instanceof Service) {
            $order = new Order();

            $partner = $this->user;

            $key = md5($user->id . $partner->id . $this->id . time());

            $order->customer()->associate($user);
            $order->service()->associate($this);
            $order->partner()->associate($partner);

            $order->expired_at = Carbon::now()->addDays(2);

            $order->key = $key;
            $order->name = $name;
            $order->message = $message;
            $order->status = "pending";
            $order->total_price = calculate_order_price($this->price);

            $order->save();

            // send notification
            $user->notify(new OrderNotification(
                "Pemesanan Layanan Berhasil",
                "Pemesanan akan dilanjutkan setelah menerima konfirmasi dari mitra",
            ));

            $partner->notify(new OrderNotification(
                "Pesanan masuk",
                "Terdapat pesanan masuk oleh penggguna @" . $user->username,
            ));

            return $order;
        }

        throw new \Exception(get_class($this) . " : This Trait Must be instance of " . Service::class);
    }
}
