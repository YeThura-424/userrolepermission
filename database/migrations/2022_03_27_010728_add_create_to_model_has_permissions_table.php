    <?php

		use Illuminate\Database\Migrations\Migration;
		use Illuminate\Database\Schema\Blueprint;
		use Illuminate\Support\Facades\Schema;

		class AddCreateToModelHasPermissionsTable extends Migration
		{
			/**
			 * Run the migrations.
			 *
			 * @return void
			 */
			public function up()
			{
				Schema::table('model_has_permissions', function (Blueprint $table) {
					$table->string('create');
					$table->string('read');
					$table->string('update');
					$table->string('delete');
				});
			}

			/**
			 * Reverse the migrations.
			 *
			 * @return void
			 */
			public function down()
			{
				Schema::table('model_has_permissions', function (Blueprint $table) {
					//
				});
			}
		}
