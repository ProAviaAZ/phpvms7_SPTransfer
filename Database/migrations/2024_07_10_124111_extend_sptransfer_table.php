<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        // Insert the column airline
        if (Schema::hasTable('sptransfer')) {
            Schema::table('sptransfer', function (Blueprint $table) {
                $table->integer('airline')->after('state')->default(0);
            });
        }
    }
};
