<?php namespace BizMark\Flexicon\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateOrdersTypeTable extends Migration
{
    const TABLE_NAME = 'bizmark_flexicon_orders';

    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable(self::TABLE_NAME)) {
            Schema::table(self::TABLE_NAME, function (Blueprint $table) {
                if (!Schema::hasColumn(self::TABLE_NAME, 'type')) $table->string('type');
            });
        }
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        if (Schema::hasTable(self::TABLE_NAME)) {
            Schema::table(self::TABLE_NAME, function (Blueprint $table) {
                if (Schema::hasColumn(self::TABLE_NAME, 'type')) $table->dropColumn('type');
            });
        }
    }
}
