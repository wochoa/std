<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MesaElectronica\Holiday;

class HolidaysController extends Controller
{

    public function index()
    {
        return Holiday::query()->get();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        foreach ($request->holidays as $holiday) {
            $newHoliday = new Holiday();
            $newHoliday->holiday = $holiday['holiday'];
            $newHoliday->status = $holiday['status'];
            $newHoliday->user_id = auth()->user()->id;
            $newHoliday->save();
        }
        return $request->holidays;
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $holiday = Holiday::find($request->id);
        $holiday->status = $request->status;
        $holiday->save();
    }

    public function destroy($id)
    {
        //
    }
}
