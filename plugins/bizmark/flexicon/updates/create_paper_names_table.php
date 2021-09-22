<?php namespace BizMark\Flexicon\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePaperNamesTable extends Migration
{
    const TABLE_NAME = 'bizmark_flexicon_paper_names';
    const RELATION_TABLE_NAME = 'bizmark_flexicon_paper_types';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        if (Schema::hasTable(self::RELATION_TABLE_NAME)) {
            Schema::table(self::RELATION_TABLE_NAME, function (Blueprint $table) {
                if (!Schema::hasColumn(self::RELATION_TABLE_NAME, 'paper_name_id')) $table->integer('paper_name_id')->after('id')->unsigned()->index();
                if (Schema::hasColumn(self::RELATION_TABLE_NAME, 'name')) $table->dropColumn('name');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
        if (Schema::hasTable(self::RELATION_TABLE_NAME)) {
            Schema::table(self::RELATION_TABLE_NAME, function (Blueprint $table) {
                if (!Schema::hasColumn(self::RELATION_TABLE_NAME, 'name')) $table->string('name')->after('id');
                if (Schema::hasColumn(self::RELATION_TABLE_NAME, 'paper_name_id')) $table->dropColumn('paper_name_id');
            });
        }
    }
}
