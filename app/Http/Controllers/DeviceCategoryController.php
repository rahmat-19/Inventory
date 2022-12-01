<?php

namespace App\Http\Controllers;

use App\Models\DeviceCategory;
use App\Models\JenisDevice;
use Illuminate\Http\Request;


class DeviceCategoryController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', DeviceCategory::class);
        return view('device.index', [
            'title' => 'Device',
            'datas' => DeviceCategory::all(),
            'jenis' => JenisDevice::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', DeviceCategory::class);
        $validated = $request->validate([
            'name' => 'required',
            'jenis_id' => 'required',
        ]);

        $valid = DeviceCategory::create($validated);

        if ($valid) {
            return redirect(Route('device.index'));
        } else {
            return redirect(Route('device.index'));
        }
    }

    public function destroy(DeviceCategory $device)
    {
        $this->authorize('delete', $device);
        $valid = DeviceCategory::destroy($device->id);
        if ($valid) {
            return redirect(Route('device.index'));
        }
    }
}
