<?php namespace BizMark\Flexicon\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePrintTypesTable extends Migration
{
    const TABLE_NAME = 'bizmark_flexicon_print_types';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->decimal('coefficient', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
