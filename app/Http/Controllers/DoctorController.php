<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Doctors",
 *     description="API Endpoints of Doctors"
 * )
 */
class DoctorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/doctors",
     *     tags={"Doctors"},
     *     summary="Get list of doctors",
     *     description="Returns list of doctors",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Doctor")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Doctor::all();
    }

    /**
     * @OA\Get(
     *     path="/api/doctors/{id}",
     *     tags={"Doctors"},
     *     summary="Get doctor by ID",
     *     description="Returns a single doctor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of doctor to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     ),
     *     @OA\Response(response=404, description="Doctor not found")
     * )
     */
    public function show($id)
    {
        return Doctor::find($id);
    }

    /**
     * @OA\Post(
     *     path="/api/doctors",
     *     tags={"Doctors"},
     *     summary="Create a new doctor",
     *     description="Create a new doctor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Doctor created",
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $doctor = Doctor::create($request->all());
        return response()->json($doctor, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/doctors/{id}",
     *     tags={"Doctors"},
     *     summary="Update an existing doctor",
     *     description="Update an existing doctor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of doctor to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor updated",
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     ),
     *     @OA\Response(response=404, description="Doctor not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());
        return response()->json($doctor, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/doctors/{id}",
     *     tags={"Doctors"},
     *     summary="Delete a doctor",
     *     description="Delete a doctor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of doctor to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Doctor deleted"),
     *     @OA\Response(response=404, description="Doctor not found")
     * )
     */
    public function delete($id)
    {
        Doctor::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}