<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tablet_status')->nullable();
            $table->string('is_checked')->nullable()->default(0)->comment = '0-For checking, 1-Already Checked';
            $table->string('asset_tag')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('capacity')->nullable();
            $table->string('department')->nullable();
            $table->string('section')->nullable();
            $table->string('assigned_user')->nullable();
            $table->string('supervisor_user')->nullable()->comment = 'Employee email';
            $table->string('disposition')->nullable();
            $table->string('date_of_disposal')->nullable();
            $table->string('date_of_purchase')->nullable();
            $table->string('remarks_1')->nullable();
            $table->string('remarks_2')->nullable();
            $table->string('approval_status')->nullable()->default(0)->comment = '0-For Approval, 1-Approved, 2-Disapproved';
            $table->string('approved_by')->nullable();
            $table->string('approved_date')->nullable();
            $table->string('approval_remarks')->nullable();

            // Defaults
            $table->bigInteger('is_deleted')->nullable()->default(0)->comment = '0-active, 1-deleted';
            $table->bigInteger('created_by')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tablets');
    }
}
