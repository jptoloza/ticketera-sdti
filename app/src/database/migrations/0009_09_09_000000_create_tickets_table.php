<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Status;
use App\Models\Priority;
use App\Models\User;
use App\Models\Queue;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void 
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Status::class)->constrained('status');
            $table->foreignIdFor(Priority::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Queue::class)->constrained();
            $table->string('subject');
            $table->text('message')->nullable();
            $table->json('files')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'assigned_agent')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
