<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mongodb';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->table('people', function (Blueprint $collection)
            {
                $collection->id();
                $collection->string('name');
                $collection->dateTime('birthday');
                $collection->string('timezone');
                $collection->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)
            ->table('people', function (Blueprint $collection)
            {
                $collection->drop();
            });
    }
};
