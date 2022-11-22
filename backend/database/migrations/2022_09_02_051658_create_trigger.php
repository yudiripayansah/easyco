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

        CREATE OR REPLACE FUNCTION insert_reg_pembiayaan()
            RETURNS trigger AS $BODY$
                DECLARE
                    i_count INTEGER;
                    i_reg_no INTEGER;
                    v_reg_no VARCHAR(20);
                    v_nomor VARCHAR(5);
                    v_tahun varchar(4);
                    v_branch_code VARCHAR(10);
                    BEGIN
                        SELECT INTO v_branch_code kode_cabang FROM kop_anggota WHERE no_anggota = NEW.no_anggota;
                        SELECT INTO i_count COUNT(*) FROM kop_cabang_serial WHERE kode_cabang = v_branch_code;
                        SELECT INTO i_reg_no reg_pyd FROM kop_cabang_serial WHERE kode_cabang = v_branch_code;
                        IF i_count = 0 THEN
                            INSERT INTO kop_cabang_serial(kode_cabang,no_serial,reg_pyd) VALUES (v_branch_code,1,1);
                            i_reg_no = 1;
                        ELSE
                            UPDATE kop_cabang_serial SET reg_pyd = reg_pyd + 1 WHERE kode_cabang = v_branch_code;
                            i_reg_no = i_reg_no + 1;
                        END IF;
                        v_nomor = trim(to_char(i_reg_no,\'0000\'));
                        v_tahun = substring(CAST(EXTRACT(YEAR FROM NOW()) AS VARCHAR(4)),3,2);
                        v_reg_no = v_tahun||\'.\'||v_branch_code||\'.\'||v_nomor;
                        UPDATE kop_pengajuan SET no_pengajuan = v_reg_no WHERE id = NEW.id;
                        RETURN NEW;
                    END
            $BODY$
        LANGUAGE plpgsql VOLATILE COST 100;
        ALTER FUNCTION insert_reg_pembiayaan() OWNER TO postgres;
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
