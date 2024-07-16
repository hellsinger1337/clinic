<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->enum('status', ['available', 'booked', 'missed', 'done'])->default('available');
            $table->timestamps();
        });

        DB::statement('
            CREATE OR REPLACE FUNCTION prevent_overlapping_slots()
            RETURNS trigger AS $$
            BEGIN
                IF EXISTS (
                    SELECT 1
                    FROM slots
                    WHERE doctor_id = NEW.doctor_id
                    AND tstzrange(start_time, end_time) && tstzrange(NEW.start_time, NEW.end_time)
                ) THEN
                    RAISE EXCEPTION \'Doctor slot overlaps with an existing slot.\';
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::statement('
            CREATE TRIGGER prevent_overlapping_slots_trigger
            BEFORE INSERT OR UPDATE ON slots
            FOR EACH ROW
            EXECUTE FUNCTION prevent_overlapping_slots();
        ');
    }

    public function down()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['client_id']);
        });

        Schema::dropIfExists('slots');

        DB::statement('DROP TRIGGER IF EXISTS prevent_overlapping_slots_trigger ON slots;');
        DB::statement('DROP FUNCTION IF EXISTS prevent_overlapping_slots();');
    }
}