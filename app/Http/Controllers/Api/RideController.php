<?php

namespace App\Http\Controllers\Api;

use App\Events\AcceptRide;
use App\Events\CompleteEvent;
use App\Events\DriverLocation;
use App\Events\JoinEvent;
use App\Events\LeaveEvent;
use App\Events\Location;
use App\Events\PostRide;
use App\Events\StartedEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\RideResource;
use App\Models\Driver;
use App\Models\Passenger;
use App\Models\Review;
use App\Models\Ride;
use App\Models\RideDaily;
use App\Models\SharedRide;
use App\RideStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    public const PER_KM_PRICE = 15;
    public const STARTER_DISCOUNT_PERCENT = 25;
    public const DISCOUNT_INCREMENT_PER_RIDER = 5;
    public const START_KM = 1;
    public const IS_PASSENGER = 1;
    public const RADIUS = 10;

    protected function broadcastOfferAccepted(Ride $ride)
    {
        AcceptRide::dispatch($ride); // Dispatch the event
    }

    public function createRide(Request $request)
    {

        try {
            // Validate incoming request
            $request->validate([
                'type' => 'required',
                'pickup_location' => 'required|string',
                'pickup_latitude' => 'required',
                'pickup_longitude' => 'required',
                'dropoff_location' => 'required|string',
                'dropoff_latitude' => 'required',
                'dropoff_longitude' => 'required',
                'ride_price' => 'required|numeric',
                'no_passengers' => 'required|integer',
                'distance' => 'required|numeric',
            ]);

            // uuid create alpha number 8 character
            $ride_uuid = 'RIDE-' . strtoupper(substr(md5(time()), 0, 8));

            $passenger = Passenger::where('user_id', auth('api')->user()->id)->first();
            if (!$passenger) {
                return response()->json([
                    'status' => false,
                    'message' => 'Passenger not found',
                ]);
            }

            // Create Ride
            $ride = Ride::create([
                'uuid' => $ride_uuid,
                'type' => $request->type,
                'pickup_location' => $request->pickup_location,
                'pickup_latitude' => $request->pickup_latitude,
                'pickup_longitude' => $request->pickup_longitude,
                'dropoff_location' => $request->dropoff_location,
                'dropoff_latitude' => $request->dropoff_latitude,
                'dropoff_longitude' => $request->dropoff_longitude,
                'passenger_id' => $passenger->id,
                'ride_price' => $request->ride_price,
                'no_passengers' => $request->no_passengers,
                'distance' => $request->distance,
            ]);

            $rides = new RideResource($ride);

            // Fire an event for Pusher or Broadcasting
            // PostRide::dispatch($rides);
            broadcast(new PostRide($rides))->toOthers();
            return response()->json([
                'status' => true,
                'message' => 'Ride created successfully',
                'data' => $rides
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function listRides(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = self::RADIUS;

        // Use Haversine formula to calculate distance and filter rides within 10 KM
        $rides = Ride::where('status', RideStatus::PENDING->value)
            ->with('passenger', 'driver')
            ->whereRaw("
            (6371 * acos(
                cos(radians(?)) * cos(radians(pickup_latitude)) * cos(radians(pickup_longitude) - radians(?))
                + sin(radians(?)) * sin(radians(pickup_latitude))
            )) < ?
        ", [$latitude, $longitude, $latitude, $radius])
            ->get();

        if (!$rides) {
            return response()->json([
                'status' => false,
                'message' => 'Rides not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Rides retrieved successfully',
            'data' => RideResource::collection($rides)
        ]);
    }

    public function acceptRideOffer(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
        ]);

        // find ride id from Ride  model
        $ride = Ride::find($request->ride_id);

        if ($ride->status != RideStatus::PENDING->value) {
            return response()->json([
                'status' => false,
                'message' => 'Ride is not pending',
            ]);
        }


        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found',
            ], 404);
        }

        $driver = Driver::with('vehicles')
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$driver->vehicles) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot send an offer without submitting your vehicle.',
            ], 400); // Return a 400 Bad Request status
        }


        $ride->update([
            'distance' => $ride->distance,
            'driver_id' => $driver->id,
            'ride_price' => $ride->ride_price,
            'vehicle_name' => $driver->vehicles->vehicle_name, // Example: vehicle_name
            'make' => $driver->vehicles->make,         // Example: make
            'model' => $driver->vehicles->model,       // Example: model
            'registration_no' => $driver->vehicles->registration_no, // Example: registration_no
            'vehicle_type' => $driver->vehicles->type, // Example: vehicle_type
            'status' => RideStatus::ACCEPTED->value,
        ]);

        // Dispatch the offer event with the offer and ride data
        AcceptRide::dispatch($ride->toArray());

        return response()->json([
            'status' => true,
            'message' => 'Offer sent successfully',
            'data' => $ride,
        ]);
    }

    public function startRide(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
        ]);

        $driver_id = Auth::user()->id;
        $driver = Driver::where('user_id', $driver_id)->first();

        $ride = Ride::where('id', $request->ride_id)
            ->where('driver_id', $driver->id)
            ->where('status', RideStatus::ACCEPTED->value)
            ->first();


        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found or already started.',
            ], 404);
        }

        // Switch condition for ride types
        switch ($ride->type) {
            case 'not_shared':
                $ride->update([
                    'status' => RideStatus::STARTED->value,
                ]);
                break;

            case 'shared':
                // Handle RideShared start
                $rideShared = SharedRide::create([
                    'ride_id' => $ride->id,
                    'passenger_id' => $ride->passenger_id,
                    'join_km' => self::START_KM,
                    'leave_km' => $ride->distance,
                    'cost' => $ride->ride_price,
                    'status' => 'joining',
                    'is_main_passenger' => self::IS_PASSENGER,
                    'pickup_latitude' => $ride->pickup_latitude,
                    'pickup_longitude' => $ride->pickup_longitude,
                    'dropoff_latitude' => $ride->dropoff_latitude,
                    'dropoff_longitude' => $ride->dropoff_longitude,
                ]);
                $ride->update([
                    'status' => RideStatus::STARTED->value,
                ]);
                break;

            default:
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid ride type.',
                ], 400);
        }

        // dd($ride);
        // Dispatch the start event with the ride data

        // StartedEvent::dispatch($ride);
        event(new StartedEvent($ride));

        return response()->json([
            'status' => true,
            'message' => 'Ride started successfully',
            'data' => $ride->status,
        ], 200);
    }

    public function joinRide(Request $request)
    {
        $request->validate([
            'ride_id' => "required|exists:rides,id",
            'passenger_id' => 'required|exists:passengers,id',
            "join_km" => "required",
            "leave_km" => "required",
        ]);

        $ride = Ride::find($request->ride_id);

        if ($ride->type != 'shared') {
            return response()->json([
                'status' => false,
                'message' => 'This is not a shared ride.'
            ], 400);
        }

        // Add passenger to the shared ride
        $passengerRide = SharedRide::create([
            'ride_id' => $ride->id,
            'passenger_id' => $request->passenger_id,
            'join_km' => $request->join_km,
            'leave_km' => $request->leave_km,
            'status' => 'joining',
            'pickup_latitude' => $request->pickup_latitude,
            'pickup_longitude' => $request->pickup_longitude,
            'dropoff_latitude' => $request->dropoff_latitude,
            'dropoff_longitude' => $request->dropoff_longitude
        ]);

        // Calculate ride price dynamically based on Cosha concept
        $this->ridePrices($ride);

        JoinEvent::dispatch($ride);

        return response()->json([
            'status' => true,
            'message' => 'Passenger joined successfully.',
            'data' => $passengerRide
        ], 200);
    }

    public function leaveRide(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'passenger_id' => 'required|exists:passengers,id',
        ]);

        $ride = Ride::find($request->ride_id);

        if ($ride->type != 'shared') {
            return response()->json([
                'status' => false,
                'message' => 'This is not a shared ride.'
            ], 400);
        }

        // Remove passenger from shared ride
        $passengerRide = SharedRide::where('ride_id', $request->ride_id)
            ->where('passenger_id', $request->passenger_id)
            ->first();

        if (!$passengerRide) {
            return response()->json([
                'status' => false,
                'message' => 'Passenger not found in this ride.'
            ], 404);
        }

        $passengerRide->update([
            'status' => 'leaving'
        ]);

        LeaveEvent::dispatch($ride);
        // Recalculate ride price after passenger leaves
        // $this->calculateRideCost($ride->id);

        return response()->json([
            'status' => true,
            'message' => 'Passenger left successfully.',
            'fare' => $passengerRide->cost
        ], 200);
    }

    public function ridePrices(Ride $ride): void
    {
        $riders = $ride->sharedRides;

        if ($riders->count() < 2) {
            [
                [
                    'passenger_id' => $ride->sharedRides->first()->passenger_id,
                    'total' => $ride->sharedRides->first()->leave_km * self::PER_KM_PRICE
                ]
            ];
        }

        $mainPassengerRide = $ride->sharedRides
            ->where('is_main_passenger', true)
            ->first();

        $passengerMetrics = $ride->sharedRides
            ->select('join_km', 'leave_km')
            ->toArray();
        // dd($mainPassengerRide);
        $perKmPrices = collect([]);

        for ($i = $mainPassengerRide->join_km; $i <= $mainPassengerRide->leave_km; $i++) {
            $perKmPrices->push([
                'km_no' => $i,
                'discount' => self::findDiscount($passengerMetrics, km_no: $i)
            ]);
        }

        //calculate cost for all passenger
        foreach ($ride->sharedRides as $sharedRide) {
            $cost = 0;

            $priceData = $perKmPrices->where('km_no', $i)->first();

            $discount_percentage = $priceData ? $priceData['discount'] : 0;

            for ($i = $sharedRide->join_km ?? 1; $i <= $sharedRide->leave_km ?? 3; $i++) {
                $discount = self::PER_KM_PRICE * $discount_percentage / 100;

                $cost += self::PER_KM_PRICE - $discount;
            }

            $sharedRide->cost = $cost;
            $sharedRide->save();
        }
    }
    /**
     * Summary of findDiscount
     */
    private static function findDiscount(array $metrics, int $km_no): int
    {
        $rep = 0;

        foreach ($metrics as $kmRange) {
            //check if between
            if ($km_no >= $kmRange['join_km'] && $km_no <= $kmRange['leave_km']) {
                $rep++;
            }
        }

        if ($rep <= 1) {
            return 0; //discount will be 0 for no share
        }

        return ($rep - 2) * self::DISCOUNT_INCREMENT_PER_RIDER + self::STARTER_DISCOUNT_PERCENT; // x
        // return (2 - 2) * 5 + 25; // 25
        // return (3 - 2) * 5 + 25; // 30
        // return (4 - 2) * 5 + 25; // 40
        // return (5 - 2) * 5 + 25; // 45
    }

    public function calculateRideCost($ride_id)
    {
        $ride = Ride::find($ride_id);
        $passengerRides = SharedRide::where('ride_id', $ride_id)->get();

        $totalDistance = $ride->distance; // Assuming this is stored in the ride table
        $pricePerKm = 15; // Example price

        $totalCost = [];
        $passengerCount = $passengerRides->count();

        foreach ($passengerRides as $passengerRide) {
            $passengerDistance = $passengerRide->leave_km - $passengerRide->join_km;

            // Apply dynamic pricing based on the number of passengers
            if ($passengerCount == 2) {
                $pricePerKm *= 0.75; // 25% discount
            } elseif ($passengerCount >= 3) {
                $pricePerKm *= 0.70; // 30% discount
            }

            $cost = $passengerDistance * $pricePerKm;
            $totalCost[$passengerRide->passenger_id] = $cost;
        }

        // Save the calculated costs in SharedRide model or somewhere else
        foreach ($totalCost as $passenger_id => $cost) {
            SharedRide::where('ride_id', $ride_id)
                ->where('passenger_id', $passenger_id)
                ->update(['cost' => $cost]);
        }
    }
    // complete ride from driver side

    public function completeRide(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
        ]);

        $driver_id = Auth::user()->id;
        $driver = Driver::where('user_id', $driver_id)->first();

        $ride = Ride::where('id', $request->ride_id)
            ->where('driver_id', $driver->id)
            ->where('status', RideStatus::STARTED->value)
            ->first();

        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found or already completed.',
            ], 404);
        }

        $ride->update([
            'status' => RideStatus::COMPLETED->value,
        ]);

        CompleteEvent::dispatch($ride);

        return response()->json([
            'status' => true,
            'message' => 'Ride completed successfully',
        ], 200);
    }
    // cancel ride before started from driver side

    public function cancelRide(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
        ]);

        $driver_id = Auth::user()->id;
        $driver = Driver::where('user_id', $driver_id)->first();

        $ride = Ride::where('id', $request->ride_id)
            ->where('driver_id', $driver->id)
            ->where('status', RideStatus::ACCEPTED->value)
            ->first();

        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found or already cancelled.',
            ], 404);
        }

        // Check the number of cancellations in the last 30 days
        $thiryDaysAgo = Carbon::now()->subDays(30);
        $cancellationLimit = 5;

        $cancellationsCount = Ride::where('driver_id', $driver->id)
            ->where('status', RideStatus::CANCELLED->value)
            ->where('updated_at', '>=', $thiryDaysAgo)
            ->count();
        // If cancellations exceed the limit, return an error
        if ($cancellationsCount >= $cancellationLimit) {
            return response()->json([
                'status' => false,
                'message' => 'You have exceeded the cancellation limit.',
            ], 400);
        }


        $ride->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Ride cancelled successfully',
            'cancellation' => $cancellationsCount
        ], 200);
    }

    public function cancelRidePassenger(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
        ]);

        $user_id = Auth::user()->id;

        $passenger = Passenger::where('user_id', $user_id)->first();

        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Passenger not found.',
            ], 404);
        }

        $ride = Ride::where('id', $request->ride_id)
            ->where('passenger_id', $passenger->id)
            ->where('status', RideStatus::ACCEPTED->value)
            ->first();

        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found or already cancelled.',
            ], 404);
        }

        $ride->update([
            'status' => RideStatus::CANCELLED->value,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Ride cancelled successfully',
        ], 200);
    }

    public function postReview(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'rating' => 'required|numeric',
            'review' => 'required|string',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $user = Auth::user();

        $passenger = Passenger::where('user_id', $user->id)->first();

        if (!$passenger) {
            return response([
                'status' => false,
                'message' => 'Passenger not found.',
            ], 404);
        }

        $ride = Ride::where('id', $request->ride_id)
            ->where('passenger_id', $passenger->id)
            ->where('status', RideStatus::COMPLETED->value)
            ->first();

        if (!$ride) {
            return response([
                'status' => false,
                'message' => 'Ride not found or already completed.',
            ], 404);
        }

        $review = Review::create([
            'ride_id' => $ride->id,
            'driver_id' => $request->driver_id,
            'passenger_id' => $passenger->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response([
            'status' => true,
            'message' => 'Review posted successfully.',
        ], 200);
    }
    // Shared Ride List
    public function sharedRideList(Request $request)
    {
        $request->validate([
            'pickup_latitude' => 'required',
            'pickup_longitude' => 'required',
            'dropoff_latitude' => 'required',
            'dropoff_longitude' => 'required',
            'no_passengers' => 'required',
        ]);


        $pickup_latitude = $request->pickup_latitude;
        $pickup_longitude = $request->pickup_longitude;
        $dropoff_latitude = $request->dropoff_latitude;
        $dropoff_longitude = $request->dropoff_longitude;

        // Query rides that match the conditions for shared rides:
        $rides = Ride::where('status', RideStatus::STARTED->value)
            ->where('type', 'shared')
            ->with('sharedRides')->get();
        // ->where(function ($query) use ($pickup_latitude, $pickup_longitude, $dropoff_latitude, $dropoff_longitude) {
        //     // Pickup should be at or before the requested pickup point (latitude and longitude)
        //     $query->where('pickup_latitude', '<=', $pickup_latitude)
        //         ->where('pickup_longitude', '<=', $pickup_longitude);

        //     // Dropoff should be at or after the requested dropoff point (latitude and longitude)
        //     $query->where('dropoff_latitude', '>=', $dropoff_latitude)
        //         ->where('dropoff_longitude', '>=', $dropoff_longitude);
        // })


        if (!$rides) {
            return response([
                'status' => false,
                'message' => 'No shared rides found.',
            ]);
        }

        // Return the response as JSON
        return response()->json([
            'status' => true,
            'message' => 'Shared rides list retrieved successfully.',
            'data' => $rides
        ], 200);
    }


    public function driverLocation(Request $request)
    {
        $validatedData = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'uuid' => 'required',
        ]);

        Location::dispatch($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Location updated successfully.',
        ]);

    }


    public function rideDetails(Request $request)
    {

        $request->validate([
            'ride_id' => 'required|exists:rides,id',
        ]);


        $ride = Ride::where('id', $request->ride_id)
            ->with('sharedRides.passenger')
            ->first();


        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found.',
            ], 404);
        }


        return response()->json([
            'status' => true,
            'message' => 'Ride details retrieved successfully.',
            'data' => $ride
        ], 200);
    }
}
