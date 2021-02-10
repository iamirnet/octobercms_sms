<?php namespace iAmirNet\SMS\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UserAddVerifyMobileField extends Migration
{
    public function up()
    {
        if (Schema::hasColumns('users', ['mobile_verify_time','mobile_verified_time','mobile_verify_code','mobile_verified_num','mobile_verify_count'])) {
            return;
        }

        Schema::table('users', function($table)
        {
            $table->string('mobile_verified_num', 191)->after('mobile')->nullable();
            $table->string('mobile_verify_time', 191)->after('mobile_verified_num')->nullable();
            $table->string('mobile_verified_time', 191)->after('mobile_verify_time')->nullable();
            $table->string('mobile_verify_code', 191)->after('mobile_verified_time')->nullable();
            $table->string('mobile_verify_count', 191)->after('mobile_verify_code')->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function ($table) {
                $table->dropColumn(['mobile_verified_num']);
                $table->dropColumn(['mobile_verify_time']);
                $table->dropColumn(['mobile_verified_time']);
                $table->dropColumn(['mobile_verify_code']);
                $table->dropColumn(['mobile_verify_count']);
            });
        }
    }
}
