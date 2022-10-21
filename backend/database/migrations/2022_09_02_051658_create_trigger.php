<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE OR REPLACE FUNCTION uuid()
            RETURNS text AS $BODY$
                DECLARE
                    vUUID VARCHAR(50);
                    vReturn VARCHAR(32);
                    BEGIN
                        SELECT INTO vUUID CAST(md5(current_database()|| user ||current_timestamp ||random()) as uuid);
                        vReturn := replace(vUUID,\'-\',\'\');
                        RETURN vReturn;
                    END
            $BODY$
            LANGUAGE plpgsql VOLATILE COST 100;
            ALTER FUNCTION uuid() OWNER TO postgres;

        CREATE OR REPLACE FUNCTION insert_anggota()
            RETURNS trigger AS $BODY$
                DECLARE
                    i_cif INTEGER;
                    i_count INTEGER;
                    i_new_cif INTEGER;
                    v_branch_code VARCHAR(5);
                    v_cif_no VARCHAR(20);
                    v_nomor VARCHAR(8);
                    BEGIN
                        v_branch_code = NEW.kode_cabang;
                        SELECT INTO i_count COUNT(*) FROM kop_cabang_serial WHERE kode_cabang = NEW.kode_cabang;
                        SELECT INTO i_cif no_serial FROM kop_cabang_serial WHERE kode_cabang = NEW.kode_cabang;
                        IF i_count = 0 THEN
                            INSERT INTO kop_cabang_serial(kode_cabang,no_serial) VALUES (NEW.kode_cabang,1);
                            i_new_cif = 1;
                        ELSE
                            UPDATE kop_cabang_serial SET no_serial = no_serial + 1 WHERE kode_cabang = NEW.kode_cabang;
                            i_new_cif = i_cif + 1;
                        END IF;
                        v_nomor = TRIM(to_char(i_new_cif,\'00000000\'));
                        v_cif_no = v_branch_code||v_nomor;
                        UPDATE kop_anggota SET no_anggota = v_cif_no WHERE id = NEW.id;
                        RETURN NEW;
                    END
            $BODY$
            LANGUAGE plpgsql VOLATILE COST 100;
            ALTER FUNCTION insert_anggota() OWNER TO postgres;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DROP FUNCTION uuid(); DROP FUNCTION insert_anggota();');
    }
}
