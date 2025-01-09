<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Traits\apiResponse;
use App\Models\Car;
use App\Models\Order;

class OrderController extends Controller
{
    use apiResponse;
    private $order,$car;

    public function __construct(Order $orderModel, Car $carModel)
    {
        $this->order = $orderModel;
        $this->car = $carModel;
    }

    public function index()
    {
        $orders = $this->order::where('user_id', auth()->id())
            ->select('id', 'car_id', 'start_date', 'end_date', 'total_price', 'payment_status')->get();
        return $this->apiResponse(200, 'Orders retrieved successfully', null, $orders);
    }

    public function store(OrderRequest $request)
    {
        $car = $this->car::find($request->car_id);

        // Check for overlapping bookings
        $overlap = $this->order::where('car_id', $car->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })->exists();

        if ($overlap) {
            return $this->apiResponse(400, 'This car is already booked for the selected dates.');
        }

        $days = (new \DateTime($request->end_date))->diff(new \DateTime($request->start_date))->days;
        $total_price = $days * $car->price_per_day;

        // Apply a 10% discount for rentals longer than 7 days
        if ($days > 7) {
            $discount = $total_price * 0.10;
            $total_price -= $discount;
        }

        $order = $this->order::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $total_price,
            'payment_status' => 'unpaid',
        ]);

        return $this->apiResponse(200, 'Order created successfully', null, $order);
    }
    public function pay($id)
    {
        $order = $this->order::find($id);
        $order->update(['payment_status' => 'paid']);

        return $this->apiResponse(200, 'Payment successful');
    }
}
