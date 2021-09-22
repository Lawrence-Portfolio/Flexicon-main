<?php namespace BizMark\Flexicon\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddSortableTable extends Migration
{
    const BOX_TYPE_TABLE_NAME = 'bizmark_flexicon_box_names';
    const BOX_NAME_TABLE_NAME = 'bizmark_flexicon_box_types';

    const PAPER_TYPE_TABLE_NAME = 'bizmark_flexicon_paper_types';
    const PAPER_NAME_TABLE_NAME = 'bizmark_flexicon_paper_names';

    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable(self::BOX_TYPE_TABLE_NAME)) {
            Schema::table(self::BOX_TYPE_TABLE_NAME, function (Blueprint $table) {
                if (!Schema::hasColumn(self::BOX_TYPE_TABLE_NAME, 'sort_order')) $table->integer('sort_order')->nullable();
            });
        }
        if (Schema::hasTable(self::BOX_NAME_TABLE_NAME)) {
            Schema::table(self::BOX_NAME_TABLE_NAME, function (Blueprint $table) {
                if (!Schema::hasColumn(self::BOX_NAME_TABLE_NAME, 'sort_order')) $table->integer('sort_order')->nullable();
            });
        }

        if (Schema::hasTable(self::PAPER_TYPE_TABLE_NAME)) {
            Schema::table(self::PAPER_TYPE_TABLE_NAME, function (Blueprint $table) {
                if (!Schema::hasColumn(self::PAPER_TYPE_TABLE_NAME, 'sort_order')) $table->integer('sort_order')->nullable();
            });
        }
        if (Schema::hasTable(self::PAPER_NAME_TABLE_NAME)) {
            Schema::table(self::PAPER_NAME_TABLE_NAME, function (Blueprint $table) {
                if (!Schema::hasColumn(self::PAPER_NAME_TABLE_NAME, 'sort_order')) $table->integer('sort_order')->nullable();
            });
        }
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        if (Schema::hasTable(self::BOX_TYPE_TABLE_NAME)) {
            Schema::table(self::BOX_TYPE_TABLE_NAME, function (Blueprint $table) {
                if (Schema::hasColumn(self::BOX_TYPE_TABLE_NAME, 'sort_order')) $table->dropColumn('sort_order');
            });
        }
        if (Schema::hasTable(self::BOX_NAME_TABLE_NAME)) {
            Schema::table(self::BOX_NAME_TABLE_NAME, function (Blueprint $table) {
                if (Schema::hasColumn(self::BOX_NAME_TABLE_NAME, 'sort_order')) $table->dropColumn('sort_order');
            });
        }

        if (Schema::hasTable(self::PAPER_TYPE_TABLE_NAME)) {
            Schema::table(self::PAPER_TYPE_TABLE_NAME, function (Blueprint $table) {
                if (Schema::hasColumn(self::PAPER_TYPE_TABLE_NAME, 'sort_order')) $table->dropColumn('sort_order');
            });
        }
        if (Schema::hasTable(self::PAPER_NAME_TABLE_NAME)) {
            Schema::table(self::PAPER_NAME_TABLE_NAME, function (Blueprint $table) {
                if (Schema::hasColumn(self::PAPER_NAME_TABLE_NAME, 'sort_order')) $table->dropColumn('sort_order');
            });
        }
    }
}
