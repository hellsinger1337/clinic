<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Slot",
 *     type="object",
 *     title="Slot",
 *     required={"doctor_id", "start_time", "end_time", "status"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="doctor_id", type="integer"),
 *     @OA\Property(property="client_id", type="integer"),
 *     @OA\Property(property="start_time", type="string", format="date-time"),
 *     @OA\Property(property="end_time", type="string", format="date-time"),
 *     @OA\Property(property="status", type="string", enum={"available", "booked", "missed", "done"}),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */
class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'client_id',
        'start_time',
        'end_time',
        'status'
    ];
}