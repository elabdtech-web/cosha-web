<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverIdentityDocument;
use App\Models\DriverLicense;
use App\Models\DriverVehicle;
use App\Models\Role;
use App\Models\User;
use Crypt;
use Flasher\Toastr\Laravel\Facade\Toastr;
use Hash;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::where('is_deleted', 0)->get();

        $title = '<span style="color: white">Delete Driver!</span>';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {

        return view('admin.drivers.create');
    }



    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female',
            'cnic_number' => 'required|string|max:255',
            'age' => 'required|integer',
            'preffered_passenger' => 'required|integer',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vehicle_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vehicle_document' => 'nullable|mimes:pdf|max:5120',
            'cnic_copy_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cnic_copy_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document_number' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'surname' => 'required|string|max:255',
            'given_name' => 'required|string|max:255',
            // Add validation for license
            'license_no' => 'required|string|max:255',
            'type' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'registration_no' => 'required|string|max:255',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $role = Role::where('name', 'driver')->first();
        $user->roles()->attach($role);
        $user->save();


        $imageName = null;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $imageName);
        }

        // Create driver record
        $driver = Driver::create([
            'user_id' => $user->id,
            'name' => $request->driver_name,
            'phone' => $request->phone,
            'license_no' => $request->license_no,
            'cnic_no' => $request->cnic_number,
            'gender' => $request->gender,
            'age' => $request->age,
            'preferred_passenger' => $request->preffered_passenger,
            'profile_image' => $imageName ?? null,
            'is_active' => true,
            'is_deleted' => false,
        ]);


        $vehicleImagePath = null;

        if ($request->hasFile('vehicle_image')) {
            $image = $request->file('vehicle_image');
            $vehicleImagePath = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $vehicleImagePath);
        }

        $vehicleDocumentPath = null;

        if ($request->hasFile('vehicle_document')) {
            $image = $request->file('vehicle_document');
            $vehicleDocumentPath = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $vehicleDocumentPath);
        }

        // Create vehicle record
        DriverVehicle::create([
            'driver_id' => $driver->id,
            'vehicle_name' => $request->vehicle_name,
            'make' => $request->make,
            'model' => $request->model,
            'type' => $request->type,
            'registration_no' => $request->registration_no,
            'vehicle_image' => $vehicleImagePath ?? null,
            'vehicle_document' => $vehicleDocumentPath ?? null,
            'is_approved' => false,
        ]);

        $cnicCopyFront = null;

        if ($request->hasFile('cnic_copy_front')) {
            $image = $request->file('cnic_copy_front');
            $cnicCopyFront = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $cnicCopyFront);
        }

        $cnicCopyBack = null;

        if ($request->hasFile('cnic_copy_back')) {
            $image = $request->file('cnic_copy_back');
            $cnicCopyBack = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $cnicCopyBack);
        }


        $backImage = null;

        if ($request->hasFile('back_image')) {
            $image = $request->file('back_image');
            $backImage = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $backImage);
        }

        $frontImage = null;

        if ($request->hasFile('front_image')) {
            $image = $request->file('front_image');
            $frontImage = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $frontImage);
        }
        // Create identity document record
        DriverIdentityDocument::create([
            'driver_id' => $driver->id,
            'given_name' => $request->given_name,
            'cnic_number' => $request->cnic_number,
            'father_name' => $request->father_name,
            'surname' => $request->surname,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
            'document_number' => $request->document_number,
            'cnic_copy_front' => $cnicCopyFront ?? null,
            'cnic_copy_back' => $cnicCopyBack ?? null,
            'front_image' => $frontImage ?? null,
            'back_image' => $backImage ?? null,
            'is_approved' => false,
        ]);

        // Store driver's license information
        DriverLicense::create([
            'driver_id' => $driver->id,
            'issued_date' => $request->issued_date,
            'license_no' => $request->license_no,
            'name' => $request->name,
            'expiry_date' => $request->expiry_date,
            'is_approved' => false,
        ]);


        return redirect()->route('admin.drivers.index')->with('success', 'Driver created successfully.');

    }


    public function edit(Driver $driver)
    {

        $driver = Driver::with('user', 'vehicles', 'identity_document', 'license')->find($driver->id);
        if (!$driver) {
            return redirect()->route('admin.drivers.index')->with('error', 'Driver not found.');
        }

        return view('admin.drivers.edit', compact('driver'));
    }


    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female',
            'cnic_number' => 'required|string|max:255',
            'age' => 'required|integer',
            'preffered_passenger' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vehicle_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vehicle_document' => 'nullable|mimes:pdf|max:5120',
            'cnic_copy_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cnic_copy_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document_number' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'surname' => 'required|string|max:255',
            'given_name' => 'required|string|max:255',
            'license_no' => 'required|string|max:255',
            'type' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'registration_no' => 'required|string|max:255',
        ]);

        // Find existing driver and user records
        $driver = Driver::with('vehicles', 'identity_document', 'license')->findOrFail($id);
        if (!$driver) {
            Toastr::error('Driver not found.');
            return redirect()->route('admin.drivers.index');
        }
        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $imageName);
            $driver->profile_image = $imageName;
        }

        // Update driver details
        $driver->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'license_no' => $request->license_no,
            'cnic_no' => $request->cnic_number,
            'gender' => $request->gender,
            'age' => $request->age,
            'preferred_passenger' => $request->preffered_passenger,
            'is_active' => true,
            'is_deleted' => false,
        ]);

        // Handle vehicle image and document updates
        if ($request->hasFile('vehicle_image')) {
            $image = $request->file('vehicle_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/drivers', $imageName);
            $driver->vehicles->vehicle_image = $imageName;
        }

        if ($request->hasFile('vehicle_document')) {
            $vehicleDoc = $request->file('vehicle_document');
            $vehicleDocName = time() . '.' . $vehicleDoc->getClientOriginalExtension();
            $vehicleDocPath = $vehicleDoc->storeAs('public/images/drivers', $vehicleDocName);
            $driver->vehicles->vehicle_document = $vehicleDocPath;
        }

        // Update driver vehicle details
        $driver->vehicles->update([
            'vehicle_name' => $request->vehicle_name,
            'make' => $request->make,
            'model' => $request->model,
            'type' => $request->type,
            'registration_no' => $request->registration_no,
        ]);

        // Handle CNIC copies and identity document update
        if ($request->hasFile('cnic_copy_front')) {
            $cnicFront = $request->file('cnic_copy_front');
            $cnicFrontName = time() . '.' . $cnicFront->getClientOriginalExtension();
            $path = $cnicFront->storeAs('public/images/drivers', $cnicFrontName);
            $driver->identity_document->cnic_copy_front = $cnicFrontName;
        }

        if ($request->hasFile('cnic_copy_back')) {
            $cnicBack = $request->file('cnic_copy_back');
            $cnicBackName = time() . '.' . $cnicBack->getClientOriginalExtension();
            $path = $cnicBack->storeAs('public/images/drivers', $cnicBackName);
            $driver->identity_document->cnic_copy_back = $cnicBackName;
        }

        if ($request->hasFile('back_image')) {
            $cnicFront = $request->file('back_image');
            $cnicFrontName = time() . '.' . $cnicFront->getClientOriginalExtension();
            $path = $cnicFront->storeAs('public/images/drivers', $cnicFrontName);
            $driver->identity_document->back_image = $cnicFrontName;
        }

        if ($request->hasFile('front_image')) {
            $cnicBack = $request->file('front_image');
            $cnicBackName = time() . '.' . $cnicBack->getClientOriginalExtension();
            $path = $cnicBack->storeAs('public/images/drivers', $cnicBackName);
            $driver->identity_document->front_image = $cnicBackName;
        }


        // Update identity document details
        $driver->identity_document->update([
            'given_name' => $request->given_name,
            'father_name' => $request->father_name,
            'surname' => $request->surname,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
            'document_number' => $request->document_number,
        ]);

        // Update driver's license details
        $driver->license->update([
            'license_no' => $request->license_no,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully.');
    }


    public function show(Driver $driver)
    {
        $driver = Driver::with('user', 'vehicles', 'identity_document', 'license')->find($driver->id);
        return view('admin.drivers.view', compact('driver'));
    }

    public function destroy(Driver $driver)
    {
        // is deleted
        $driver->is_deleted = 1;
        $driver->save();
        return redirect()->route('admin.drivers.index')->with('success', 'Driver deleted successfully.');
    }
}
