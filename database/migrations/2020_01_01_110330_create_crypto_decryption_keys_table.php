<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoPublicKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_decryption_keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('key');
            $table->string('algorithm')->nullabe();
            $table->nullableMorphs('user');
            $table->timestamp('expired_at')->nullable();
            $table->unsignedBigInteger('crypto_encryption_key_id')->nullable();
            $table->timestamps();

            $table
                ->foriegn('crypto_encryption_key_id')
                ->references('id')
                ->on('crypto_encryption_keys')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_decryption_keys');
    }
}
