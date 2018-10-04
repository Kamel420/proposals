<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UlterProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function(Blueprint $table) {
            $table->string('proposal_type');
            $table->string('technical_approver');
            $table->string('client_source');
            $table->string('sales_agent');
            $table->string('proposal_number'); // because it has zero on left
        });
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
