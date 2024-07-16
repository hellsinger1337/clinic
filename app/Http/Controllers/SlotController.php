<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Clinic API Documentation",
 *     description="API Documentation for Clinic management system",
 *     @OA\Contact(
 *         email="support@clinic.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Tag(
 *     name="Slots",
 *     description="API Endpoints of Slots"
 * )
 */
class SlotController extends Controller
{
      /**
     * @OA\Get(
     *     path="/api/slots",
     *     tags={"Slots"},
     *     summary="Get list of slots",
     *     description="Returns list of slots",
     *     @OA\Parameter(
     *         name="client_id",
     *         in="query",
     *         description="Client ID to filter slots",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="doctor_id",
     *         in="query",
     *         description="Doctor ID to filter slots",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status to filter slots",
     *         required=false,
     *         @OA\Schema(type="string", enum={"available", "booked", "missed", "done"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Slot")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Slot::query();

        if ($request->has('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->input('doctor_id'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        return $query->get();
    }

    /**
     * @OA\Get(
     *     path="/api/slots/{id}",
     *     tags={"Slots"},
     *     summary="Get slot by ID",
     *     description="Returns a single slot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of slot to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Slot")
     *     ),
     *     @OA\Response(response=404, description="Slot not found")
     * )
     */
    public function show($id)
    {
        return Slot::find($id);
    }

    /**
     * @OA\Post(
     *     path="/api/slots",
     *     tags={"Slots"},
     *     summary="Create a new slot",
     *     description="Create a new slot",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Slot")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Slot created",
     *         @OA\JsonContent(ref="#/components/schemas/Slot")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $slot = Slot::create($request->all());
        return response()->json($slot, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/slots/{id}",
     *     tags={"Slots"},
     *     summary="Update an existing slot",
     *     description="Update an existing slot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of slot to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Slot")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Slot updated",
     *         @OA\JsonContent(ref="#/components/schemas/Slot")
     *     ),
     *     @OA\Response(response=404, description="Slot not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $slot = Slot::findOrFail($id);
        $slot->update($request->all());
        return response()->json($slot, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/slots/{id}",
     *     tags={"Slots"},
     *     summary="Delete a slot",
     *     description="Delete a slot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of slot to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Slot deleted"),
     *     @OA\Response(response=404, description="Slot not found")
     * )
     */
    public function delete($id)
    {
        Slot::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
