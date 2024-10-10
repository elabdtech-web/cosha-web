<?php

namespace App\Http\Controllers\Api;

use App\Events\CreateRide;
use App\Events\DriverOffer;
use App\Events\Offer;
use App\Events\OfferAccepted;
use App\Events\OfferData;
use App\Events\PostRide;
use App\Events\RemoveRide;
use App\Http\Controllers\Controller;
use App\Http\Resources\RideOfferResource;
use App\Http\Resources\RideResource;
use App\Models\Driver;
use App\Models\Passenger;
use App\Models\Ride;
use App\Models\RideOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RideController extends Controller
{
    protected function broadcastOfferAccepted(Ride $ride)
    {
        OfferAccepted::dispatch($ride); // Dispatch the event
    }

    protected function broadcastRideRemoved(Ride $ride)
    {
        RemoveRide::dispatch($ride);
    }

    public function createRide(Request $request)
    {

        try {
            // Validate incoming request
            $request->validate([
                'type' => 'required|in:daily,shared,night',
                'pickup_location' => 'required|string',
                'pickup_latitude' => 'required',
                'pickup_longitude' => 'required',
                'dropoff_location' => 'required|string',
                'dropoff_latitude' => 'required',
                'dropoff_longitude' => 'required',
                'estimated_price' => 'required|numeric',
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
                'estimated_price' => $request->estimated_price,
                'no_passengers' => $request->no_passengers,
                'distance' => $request->distance,
            ]);

            $rides = new RideResource($ride);

            // Fire an event for Pusher or Broadcasting
            PostRide::dispatch($rides);
            return response()->json([
                'status' => true,
                'message' => 'Ride created successfully',
                'data' => $rides
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while creating a ride',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function listRides()
    {
        $rides = Ride::where('status', 'pending')
            ->with('passenger', 'driver')
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Rides retrieved successfully',
            'data' => RideResource::collection($rides)
        ]);
    }

    public function sendOffer(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'distance' => 'required',
            'time' => 'required|string',
            'offered_price' => 'required|numeric',
        ]);

        $driver = Driver::with('vehicles')
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$driver->vehicles) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot send an offer without submitting your vehicle.',
            ], 400); // Return a 400 Bad Request status
        }
        $offer = RideOffer::create([
            'ride_id' => $request->ride_id,
            'time' => $request->time,
            'distance' => $request->distance,
            'driver_id' => $driver->id,
            'offered_price' => $request->offered_price,
            'status' => 'offered',
        ]);

        $ride = Ride::find($request->ride_id);
        // Combine ride and offer data into one array
        $offerData = [
            'id' => $offer->id,
            'driver_id' => $driver->id,
            'name' => $driver->name,
            'vehicle_name' => $driver->vehicles->vehicle_name ?? null,
            'distance' => $request->distance,
            'time' => $request->time,
            'offered_price' => $request->offered_price,
            'pickup_location' => $ride->pickup_location,
            'dropoff_location' => $ride->dropoff_location,
            'no_passengers' => $ride->no_passengers,
            'ride_uuid' => $ride->uuid,
            'vehicle_image' => Storage::url('drivers/' . $driver->vehicles->vehicle_image) ?? Storage::url('default.png'),
            'profile' => Storage::url('profile_images/' . $driver->profile_image) ?? Storage::url('default.png')
        ];
        // Dispatch the offer event with the offer and ride data
        OfferData::dispatch($offerData);

        return response()->json([
            'status' => true,
            'message' => 'Offer sent successfully',
            'data' => $offerData,
        ]);
    }

    public function acceptRideOffer(Request $request)
    {
        $request->validate([
            'ride_offer_id' => 'required|exists:ride_offers,id',
        ]);

        // find the ride offer
        $rideOffer = RideOffer::where('id', $request->ride_offer_id)
            ->where('status', 'offered')
            ->first();

        if (!$rideOffer) {
            return response()->json([
                'status' => false,
                'message' => 'Ride offer not found or already withdrawn.',
            ], 404);
        }

        // get the ride related to this offer

        $ride = Ride::find($rideOffer->ride_id);

        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found.',
            ], 404);
        }


        // Get the driver's vehicle details (assuming driver's vehicle details are stored somewhere)

        $driver = Driver::with('vehicles')->find($rideOffer->driver_id);

        if (!$driver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver not found.',
            ], 404);
        }

        $ride->update([
            'status' => 'accepted',
            'driver_id' => $rideOffer->driver_id,
            'vehicle_name' => $driver->vehicles->vehicle_name, // Example: vehicle_name
            'make' => $driver->vehicles->make,         // Example: make
            'model' => $driver->vehicles->model,       // Example: model
            'registration_no' => $driver->vehicles->registration_no, // Example: registration_no
            'vehicle_type' => $driver->vehicles->type, // Example: vehicle_type
        ]);

        // Change the ride offer status to accepted
        $rideOffer->update([
            'status' => 'accepted',
        ]);

        // Change the status of all other ride offers to rejected
        RideOffer::where('ride_id', $rideOffer->ride_id)
            ->where('id', '!=', $rideOffer->id)
            ->where('status', 'offered')
            ->update(['status' => 'rejected']);

        // Broadcast event to remove or unsubscribe from the offer channel
        $this->broadcastOfferAccepted($ride);

        // remove ride from rides Channel

        $this->broadcastRideRemoved($ride);

        return response()->json([
            'status' => true,
            'message' => 'Ride offer accepted successfully',
            'ride' => $ride,
            'offer' => $rideOffer,
        ]);
    }

    public function listOffers()
    {
        $offers = RideOffer::with('ride')->where('status', 'offered')
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Offers retrieved successfully',
            'data' => RideOfferResource::collection($offers)
        ]);
    }

    public function offerDetails(Request $request)
    {
        $request->validate([
            'ride_offer_id' => 'required|exists:ride_offers,id',
        ]);

        $offer = RideOffer::where('id', $request->ride_offer_id)
            ->where('status', 'offered')
            ->first();

        if (!$offer) {
            return response()->json([
                'status' => false,
                'message' => 'Ride offer not found or already withdrawn.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Offer details retrieved successfully',
            'data' => new RideOfferResource($offer)
        ]);
    }
}
