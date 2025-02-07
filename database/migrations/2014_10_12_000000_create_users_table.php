<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('Auto-incrementing ID for users');
            $table->unsignedInteger('role_id')->nullable()->index()->comment('Role ID linked to user_roles table');
            $table->string('username', 100)->nullable()->unique();
            $table->string('email', 50)->nullable()->unique();
            $table->string('password', 255)->comment('User password (hashed)');
            $table->string('secondary_password', 255)->comment('User secondary password (hashed)');
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('alter_phone_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 70)->nullable();
            $table->string('state', 30)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->string('timezone', 70)->nullable();
            $table->enum('user_type', ['Super Admin', 'User'])->default('User')->comment('User type');
            $table->enum('can_login', ['Yes', 'No'])->default('Yes')->comment('Whether the user can log in');
            $table->string('profile_picture', 100)->nullable();
            $table->boolean('email_verified')->default(false);
            $table->string('last_login_ip', 45)->nullable();
            $table->string('refresh_token', 255)->nullable()->comment('User refresh token'); // New column for refresh token
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->comment('User status');
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
