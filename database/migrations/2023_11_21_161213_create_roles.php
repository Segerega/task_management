<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;


return new class extends Migration
{
    public function up()
    {
        // Create the 'admin' role
        Role::create(['name' => 'admin']);
    }

    public function down()
    {
        Role::where('name', 'admin')->delete();
    }
};
