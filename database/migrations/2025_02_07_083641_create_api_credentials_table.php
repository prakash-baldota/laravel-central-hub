<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); 
            $table->string('password')->nullable(); 
            $table->string('api_key')->nullable()->unique(); 
            $table->unsignedBigInteger('project_id')->default(0); // Reference to the project
            $table->enum('access_type', ['authenticate'])->default('authenticate'); // Enum for authentication method
            $table->timestamp('last_used_at')->nullable(); // Timestamp of when the credentials were last used
            $table->string('refresh_token', 255)->nullable()->comment('User refresh token'); // New column for refresh token
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->comment('User status');
            $table->unsignedBigInteger('created_by')->nullable(); // User ID who created the credentials
            $table->unsignedBigInteger('updated_by')->nullable(); // User ID who last updated the credentials
            $table->timestamps(); // For tracking creation and update times
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_credentials');
    }
}
