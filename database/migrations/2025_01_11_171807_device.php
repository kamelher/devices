<?php

namespace database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kamelher\Devices\Enums\DeviceStatus;
use Kamelher\Devices\Enums\DeviceTypes;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mac_address')->unique();
            $table->string('uuid')->unique();
            $table->string('status')->default(DeviceStatus::Unverified->value);
            $table->string('device_type')->default(DeviceTypes::Desktop->value);
            $table->string('device_model')->nullable();
            $table->json('metadata')->nullable();
            $table->morphs('deviceable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
