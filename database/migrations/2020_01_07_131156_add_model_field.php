<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModelField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $queries    = array(
            "INSERT IGNORE INTO `modules` (`id`, `name`, `is_primary`, `is_active`, `created_at`, `updated_at`) VALUES (5, 'Attendance', '0', '1', CURRENT_DATE(), CURRENT_DATE());",
            "UPDATE `modules` SET `model_name` = 'Reservation' WHERE `modules`.`name` = 'Vehicle Reservation';",
            "UPDATE `modules` SET `model_name` = 'Travel' WHERE `modules`.`name` = 'Travel Order';",
            "UPDATE `modules` SET `model_name` = 'Offset' WHERE `modules`.`name` = 'Offset';",
            "UPDATE `modules` SET `model_name` = 'OvertimeRequest' WHERE `modules`.`name` = 'Overtime Request';",
            "UPDATE `modules` SET `model_name` = 'Attendance' WHERE `modules`.`name` = 'Attendance';"
        );
        foreach($queries as $query) {
            DB::statement($query);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
