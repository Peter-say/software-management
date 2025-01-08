<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelModulePreference;
use App\Models\HotelSoftware\ModulePreference;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ModulePreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = AppConstants::MODULE_NAMES;
        return view('dashboard.hotel.module-preference.create', [
            'modules' => $modules,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $hotel_id = User::getAuthenticatedUser()->hotel->id;
            $selected_modules = explode(',', $data['selected_modules']);
            foreach ($selected_modules as $module_name) {
                $module_preference = ModulePreference::create([
                    'hotel_id' => $hotel_id,
                    'name' => $module_name,
                    'slug' => Str::slug($module_name),
                ]);
                HotelModulePreference::create([
                    'hotel_id' =>  $hotel_id,
                    'module_preference_id' => $module_preference->id,
                ]);
            }
            return redirect()->route('dashboard.home')->with('success_message', 'App set-up completed successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while creating the modules.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $modules = AppConstants::MODULE_NAMES;
        $hotel = User::getAuthenticatedUser()->hotel;
        $selected_modules = $hotel->modulePreferences->pluck('name')->toArray();

        // dd( $selected_modules,  $selected_modules, $hotel);
        return view('dashboard.hotel.module-preference.create', [
            'modules' => $modules,
            'selected_modules' => $selected_modules
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $hotel_id = User::getAuthenticatedUser()->hotel->id;
            $selected_modules = explode(',', $request->input('selected_modules'));
            $existing_preferences = ModulePreference::where('hotel_id', $hotel_id)
                ->get();
            $existing_module_names = $existing_preferences->map(function ($preference) {
                return $preference->name;
            })->toArray();
            $modules_to_add = array_diff($selected_modules, $existing_module_names);
            $modules_to_remove = array_diff($existing_module_names, $selected_modules);
            foreach ($modules_to_remove as $module_name) {
                if (!in_array($module_name, $existing_module_names)) {
                    throw new Exception("Module '{$module_name}' is missing or has already been deleted.");
                }
            }
            foreach ($modules_to_remove as $module_name) {
                $module = ModulePreference::where('name', $module_name)->first();
                if ($module) {
                    $module->delete();
                }
            }
            foreach ($modules_to_add as $module_name) {
                $module = ModulePreference::firstOrCreate([
                    'hotel_id' => $hotel_id,
                    'name' => $module_name,
                    'slug' => Str::slug($module_name),
                ]);

                HotelModulePreference::create([
                    'hotel_id' => $hotel_id,
                    'module_preference_id' => $module->id,
                ]);
            }
            return redirect()->back()->with('success_message', 'Modules preference updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while updating the modules.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
