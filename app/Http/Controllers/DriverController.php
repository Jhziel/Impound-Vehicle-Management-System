<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{

    public function index(Request $request)
    {
        $drivers = Driver::query()->when($request->input('search'), function ($query, $search) {
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('license_no', 'like', "%{$search}%");
        })->paginate(4)->withQueryString();
        return Inertia::render('Drivers/Index', [
            'drivers' => $drivers,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //get all countries

        $nationality = $this->getNationality();
        $locations = $this->getLocations();
        return Inertia::render('Drivers/Create', [
            'locations' => $locations,
            'nationality' => $nationality
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Perform validation
            $data = $request->validate([
                'license_no' => [
                    'required',
                    'string',
                    Rule::unique('drivers')->where(function ($query) {
                        return $query->where('license_no', '!=', 'N/A');
                    }),
                ],
                'license_type' => ['required', 'string'],
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'middle_name_initial' => ['required', 'string', 'max:3'],
                'street_address' => ['required', 'string'],
                'province' => ['required', 'string'],
                'municipality' => ['required', 'string'],
                'barangay' => ['required', 'string'],
                'postal_code' => ['required', 'integer'],
                'contact_no' => ['required', 'integer'],
                'nationality' => ['required', 'string'],
                'civil_status' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'date_of_birth' => ['required', 'string'],
            ]);

            // Create the driver
            Driver::create($data);

            // Redirect with success message
            return redirect('/drivers')->with([
                'message' => 'Successfully Created the Driver',
                'message_type' => 'success' // This will indicate a success
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput() // Keep input data to help the user fix errors
                ->with([
                    'message' => 'There were errors with your submission.',
                    'message_type' => 'error' // This will indicate an error
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        $nationality = $this->getNationality();
        $locations = $this->getLocations();
        return Inertia::render('Drivers/Edit', [
            'driver' => $driver,
            'locations' => $locations,
            'nationality' => $nationality
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        try {
            // Perform validation
            $data = $request->validate([
                'license_no' => [
                    'required',
                    'string',
                    Rule::unique('drivers')->ignore($driver->id)->where(function ($query) {
                        return $query->where('license_no', '!=', 'N/A');
                    }),
                ],
                'license_type' => ['required', 'string'],
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'middle_name_initial' => ['required', 'string', 'max:3'],
                'street_address' => ['required', 'string'],
                'province' => ['required', 'string'],
                'municipality' => ['required', 'string'],
                'barangay' => ['required', 'string'],
                'postal_code' => ['required', 'integer'],
                'contact_no' => ['required', 'integer'],
                'nationality' => ['required', 'string'],
                'civil_status' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'date_of_birth' => ['required', 'string'],
            ]);

            // Create the driver
            $driver->update($data);

            // Redirect with success message
            return redirect('/drivers')->with([
                'message' => 'Successfully Updated the Driver',
                'message_type' => 'success' // This will indicate a success
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput() // Keep input data to help the user fix errors
                ->with([
                    'message' => 'There were errors with your submission.',
                    'message_type' => 'error' // This will indicate an error
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        try {
            $driver->delete();
            return redirect('/drivers')->with([
                'message' => 'Successfully Deleted the Driver',
                'message_type' => 'success' // This will indicate a success
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {   // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->with([
                    'message' => 'There were errors with your submission.',
                    'message_type' => 'error' // This will indicate an error
                ]);
        }
    }

    /**
     * Load and return the list of countries from a PHP file.
     *
     * This method includes a PHP file from the storage directory that returns
     * an array of countries. Each country in the array has details like codes
     * and names.
     *
     * @return array The array of countries from the PHP file.
     */
    public function getCountries(): array
    {
        // Include the PHP file and store the returned data in $countries
        $countries = include(storage_path('countries.php'));

        // Ensure the returned data is an array; if not, return an empty array
        return is_array($countries) ? $countries : [];
    }

    public function getNationality(): array
    {

        $countries = $this->getCountries();
        $newArray = Arr::map($countries, function (array $value, string $key) {
            return [
                'nationality' => $value['nationality']
            ];
        });
        $newArray = Arr::flatten($newArray);
        return $newArray;
    }

    public function getLocations()
    {
        // Load the JSON file from the storage directory
        $jsonFile = storage_path('philippine_provinces_cities_municipalities_and_barangays_2019v2.json');

        // Decode the JSON file to a PHP array
        $data = json_decode(file_get_contents($jsonFile), true);

        return $data;
    }
}
