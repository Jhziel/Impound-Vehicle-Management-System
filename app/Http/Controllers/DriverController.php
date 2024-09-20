<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Arr;

class DriverController extends Controller
{

    public function index(Request $request)
    {
        $users = User::query()->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(4)->withQueryString();
        return Inertia::render('Drivers/Index', [
            'users' => $users,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //get all countries
        $countries = $this->getCountries();
        $nationality = $this->getNationality($countries);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        //
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

    public function getNationality($array): array
    {

        $newArray = Arr::map($array, function (array $value, string $key) {
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
