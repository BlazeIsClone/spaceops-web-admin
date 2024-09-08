<?php

use App\Enums\PostStatus;
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
		Schema::create('posts', function (Blueprint $table) {
			$table->id();
			$table->tinyInteger('status')->default(PostStatus::INACTIVE);

			$table->string('name')->unique();
			$table->string('slug')->unique();

			$table->string('title');
			$table->string('short_description')->nullable();
			$table->string('description')->nullable();

			$table->string('meta_title')->nullable();
			$table->string('meta_description')->nullable();

			$table->foreignId('created_by')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('restrict')->onUpdate('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('posts');
	}
};
