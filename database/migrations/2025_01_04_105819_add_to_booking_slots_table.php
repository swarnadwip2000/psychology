<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToBookingSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_slots', function (Blueprint $table) {
            $table->string('meeting_start_time')->nullable()->after('time');
            $table->string('meeting_end_time')->nullable()->after('meeting_start_time');
            $table->boolean('meeting_status')->default(0)->after('meeting_end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_slots', function (Blueprint $table) {
            $table->dropColumn('meeting_start_time');
            $table->dropColumn('meeting_end_time');
            $table->dropColumn('meeting_status');
        });
    }
}
