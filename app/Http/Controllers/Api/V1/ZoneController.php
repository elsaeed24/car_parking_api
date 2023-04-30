<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResource;


/**
 * @group Zones
 */
class ZoneController extends Controller
{
    //Although there is one method, I don't use a Single Action Controller here with __invoke(), because it's a pretty big probability that there would be more methods in the future
    public function index()
    {
        return ZoneResource::collection(Zone::all());
    }
}
