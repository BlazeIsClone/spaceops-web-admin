<?php

use App\Models\Post;
use App\Models\PostCategory;
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
		Schema::create('post_has_category', function (Blueprint $table) {
			$table->id();

			$table->foreignIdFor(Post::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
			$table->foreignIdFor(PostCategory::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('post_has_category');
	}
};
