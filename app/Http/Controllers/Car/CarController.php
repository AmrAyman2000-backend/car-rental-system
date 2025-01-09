<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CarRequest;
use App\Http\Traits\apiResponse;
use App\Http\Traits\FileUploader;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CarController extends Controller implements HasMiddleware
{
    use apiResponse,FileUploader;
    private $car;
    public function __construct(Car $carModel)
    {
        $this->car = $carModel;
    }
    public static function middleware(): array
    {
        return [
            new Middleware('admin', only: ['store','markAsUnavailable']),
        ];
    }

    public function index(Request $request)
    {
        $cars = $this->car::query();

        if ($request->has('name')) {
            $cars->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('type')) {
            $cars->where('type', $request->type);
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $cars->whereBetween('price_per_day', [$request->price_min, $request->price_max]);
        }

        if ($request->has('availability_status')) {
            $cars->where('availability_status', $request->availability_status);
        }
        $carsList = $cars->select('id', 'name', 'type', 'price_per_day', 'availability_status', 'image')->get();

        return $this->apiResponse(200, 'Cars retrieved successfully', null, $carsList);
    }

    public function store(CarRequest $request)
    {
        $image = $request->hasFile('image') ? $this->uploadFile($request->image, $this->car::PATH) : null;
      $car = $this->car::create([
            'name' => $request->name,
            'type' => $request->type,
            'price_per_day' => $request->price_per_day,
            'availability_status' => $request->availability_status ?? 'available',
            'image' => $image
        ]);
        return $this->apiResponse(200, 'Car added successfully', null, $car);
    }
    public function markAsUnavailable($id)
    {
        $car = $this->car::find($id);
        $car->update(['availability_status' => 'unavailable']);

        return $this->apiResponse(200, 'Car marked as unavailable for maintenance.');
    }
}
