<?php namespace iAmirNet\SMS\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateIAmirSmsBridges extends Migration
{
    public function up()
    {
        if (Schema::hasTable('i_amir_sms_bridges'))
            return;
        Schema::create('i_amir_sms_bridges', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('method')->nullable()->default('mobile');
            $table->string('code');
            $table->string('receiver');
            $table->longText('hash');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('i_amir_sms_bridges');
    }
}
