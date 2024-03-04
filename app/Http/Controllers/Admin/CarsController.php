<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarProperty;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @OA\Info(
 *      title="Car Management API",
 *      version="1.0.0",
 *      description="API for managing cars"
 * )
 */
class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/admin/cars",
     *     summary="Get all cars",
     *     tags={"Cars"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Car")
     *         )
     *     )
     * )
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cars = Car::orderBy('created_at', 'desc')->get();
        return view('admin.cars.index', [
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @OA\Post(
     *     path="/api/admin/cars",
     *     summary="Create a new car",
     *     tags={"Cars"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Car created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     )
     * )
     */
    public function create(Request $request)
    {
        try {
            $carName = $request->input('carName');
            $properties = $request->input('carProperties');


            $car = Car::query()->create([
                'name' => $carName
            ]);

            foreach ($properties as $property) {
                $car->properties()->create([
                    'typeApp' => $property['typeApp'],
                    'name' => $property['name'],
                    'value' => $property['value'],
                ]);
            }


        } catch (Exception $e) {


        }


        return view('admin.cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/admin/cars/store",
     *     summary="Store a newly created car",
     *     tags={"Cars"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car stored successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $new_car = new Car();
        $new_car->id = Str::uuid();
        $new_car->name = $request->input('name');
        $new_car->company = $request->input('company');
        $new_car->save();

        $vin_property = new CarProperty();
        $vin_property->id = Str::uuid();
        $vin_property->typeApp = 1;
        $vin_property->name = 'vin';
        $vin_property->value = $request->input('vin');
        $vin_property->car_id = $new_car->id;
        $vin_property->save();

        $registration_property = new CarProperty();
        $registration_property->id = Str::uuid();
        $registration_property->typeApp = 2;
        $registration_property->name = 'VehicleRegNumber';
        $registration_property->value = $request->input('registration');
        $registration_property->car_id = $new_car->id;
        $registration_property->save();

        return redirect()->back()->withSuccess('All data was successfully saved!');
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/admin/cars/{id}",
     *     summary="Get a specific car",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the car",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit', [
            'car' => $car,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->update($request->only('name'));


            $car->update($request->only('company'));


            $vinProperty = $car->properties->where('name', 'vin')->first();
            if ($vinProperty) {
                $vinProperty->update(['value' => $request->input('vin')]);
            }


            $regProperty = $car->properties->where('name', 'VehicleRegNumber')->first();
            if ($regProperty) {
                $regProperty->update(['value' => $request->input('registration')]);
            }

            return redirect()->back()->withSuccess('All data was successfully updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withError('An error occurred while updating the data: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::find($id);

        if ($car) {
            $car->delete();
            return redirect()->back()->withSuccess('Car successfully deleted!');
        } else {
            return response()->json()->setStatusCode(404, 'Car not found');
        }
    }
}
