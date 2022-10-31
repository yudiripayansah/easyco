--
-- PostgreSQL database dump
--

-- Dumped from database version 9.2.1
-- Dumped by pg_dump version 9.2.1
-- Started on 2022-10-10 11:07:19

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 175 (class 3079 OID 11727)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2017 (class 0 OID 0)
-- Dependencies: 175
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 188 (class 1255 OID 739670)
-- Name: uuid(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION uuid() RETURNS text
    LANGUAGE plpgsql
    AS $$

-- Description  : 
-- example : 1. select uuid();
-- select replace(CAST(uuid_generate_v4() as varchar(42)),'-','');

DECLARE

   vUUID VARCHAR(50);
   vReturn VARCHAR(32);

BEGIN 
	SELECT INTO vUUID CAST(md5(current_database()|| user ||current_timestamp ||random()) as uuid); 
	vReturn := replace(vUUID,'-',''); 

	RETURN vReturn;

END

$$;


ALTER FUNCTION public.uuid() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 168 (class 1259 OID 769040)
-- Name: kis_anggota; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kis_anggota (
    id character varying(32) DEFAULT uuid() NOT NULL,
    noanggota character varying(20) NOT NULL,
    nama character varying(50),
    majelis character varying(50),
    desa character varying(50),
    status character(1) DEFAULT 0,
    simpok numeric(15,2) DEFAULT 0,
    simwa numeric(15,2) DEFAULT 0,
    sukarela numeric(15,2) DEFAULT 0
);


ALTER TABLE public.kis_anggota OWNER TO postgres;

--
-- TOC entry 2018 (class 0 OID 0)
-- Dependencies: 168
-- Name: TABLE kis_anggota; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE kis_anggota IS 'SELECT
a.idanggota AS noanggota,
a.nama,
b.namamajelis AS majelis,
c.namadesa AS desa,
a.stsanggota AS status,
(d.swtlwk + d.swblwk + d.slmlwk + d.slslwk) AS simpok,
(d.swtmgo + d.swbmgo + d.slmmgo + d.slsmgo) AS simwa,
(d.swtskr + d.swbskr + d.slmskr + d.slsskr) AS sukarela
FROM anggota AS a
LEFT JOIN majelis AS b ON a.idmajelis = b.idmajelis
LEFT JOIN desa AS c ON c.iddesa = b.iddesa
LEFT JOIN ang_reke AS d ON a.idanggota = d.idanggota
ORDER BY 1';


--
-- TOC entry 2019 (class 0 OID 0)
-- Dependencies: 168
-- Name: COLUMN kis_anggota.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN kis_anggota.status IS '0 = Baru Regis, 1 = Aktif, 3 = Keluar';


--
-- TOC entry 169 (class 1259 OID 769054)
-- Name: kis_deposito; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kis_deposito (
    id character varying(32) DEFAULT uuid() NOT NULL,
    nomrek character varying(20) NOT NULL,
    noanggota character varying(20),
    status character(1) DEFAULT 0,
    produk character varying(50),
    tgl_buka date,
    jk_waktu integer,
    tgl_jtempo date,
    saldo numeric(15,2) DEFAULT 0,
    bagihasil numeric(15,2) DEFAULT 0
);


ALTER TABLE public.kis_deposito OWNER TO postgres;

--
-- TOC entry 2020 (class 0 OID 0)
-- Dependencies: 169
-- Name: TABLE kis_deposito; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE kis_deposito IS 'SELECT
a.rekdep AS nomrek,
a.idanggota AS noanggota,
a.stsdep AS status,
c.nmprod AS produk,
a.tglval AS tgl_buka,
a.jwaktu AS jk_waktu,
a.tgjtmp AS tgl_jtempo,
a.valdep AS saldo,
(b.sbhslalu + b.sbhssek) AS bagihasil
FROM depo_mast AS a
LEFT JOIN depo_saldo AS b ON a.rekdep = b.rekdep
LEFT JOIN pap_depo AS c ON a.kdprod = c.kdprod
ORDER BY 1';


--
-- TOC entry 2021 (class 0 OID 0)
-- Dependencies: 169
-- Name: COLUMN kis_deposito.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN kis_deposito.status IS '0 = Baru Regis, 1 = Aktif, 3 = Sudah Cair';


--
-- TOC entry 170 (class 1259 OID 769060)
-- Name: kis_pembiayaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kis_pembiayaan (
    id character varying(32) DEFAULT uuid() NOT NULL,
    nomrek character varying(20) NOT NULL,
    noanggota character varying(20),
    status character(1) DEFAULT 0,
    produk character varying(50),
    tgl_droping date,
    pokok numeric(15,2) DEFAULT 0,
    margin numeric(15,2) DEFAULT 0,
    jk_waktu integer,
    cnt_bayar integer,
    bayar_pkk numeric(15,2) DEFAULT 0,
    bayar_mgn numeric(15,2) DEFAULT 0,
    saldo_pkk numeric(15,2) DEFAULT 0,
    saldo_mgn numeric(15,2) DEFAULT 0
);


ALTER TABLE public.kis_pembiayaan OWNER TO postgres;

--
-- TOC entry 2022 (class 0 OID 0)
-- Dependencies: 170
-- Name: TABLE kis_pembiayaan; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE kis_pembiayaan IS 'SELECT
a.idanggota AS noanggota,
a.nompyd AS nomrek,
a.stspyd AS status,
a.tgdrop AS tgl_akad,
d.nmprod AS produk,
a.plafon AS pokok,
a.margin,
a.jwaktu AS jk_waktu,
(c.cnbthn + c.cnbbln + c.cnbmem + c.cnbsek) AS cnt_bayar,
(c.tbpthn + c.tbpbln + c.tbpmem + c.tbpsek) AS bayar_pkk,
(c.tbmthn + c.tbmbln + c.tbmmem + c.tbmsek) AS bayar_mgn,
(a.plafon-(c.tbpthn + c.tbpbln + c.tbpmem + c.tbpsek)) AS saldo_pkk,
(a.margin-(c.tbmthn + c.tbmbln + c.tbmmem + c.tbmsek)) AS saldo_mgn
FROM pyd_mast AS a
LEFT JOIN anggota AS b ON a.idanggota = b.idanggota
LEFT JOIN pyd_saldo AS c ON a.nompyd = c.nompyd
LEFT JOIN pap_prpb AS d ON a.kdprod = d.kdprod
ORDER BY 1';


--
-- TOC entry 2023 (class 0 OID 0)
-- Dependencies: 170
-- Name: COLUMN kis_pembiayaan.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN kis_pembiayaan.status IS '0 = Baru Regis, 1 = Aktif, 3 = Lunas';


--
-- TOC entry 171 (class 1259 OID 769095)
-- Name: kis_trx_deposito; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kis_trx_deposito (
    id character varying(32) DEFAULT uuid() NOT NULL,
    notran character varying(20) NOT NULL,
    nomrek character varying(20),
    nourut integer,
    trx_date date,
    saldo_awal numeric(15,2) DEFAULT 0,
    amount_trx numeric(15,2) DEFAULT 0,
    saldo numeric(15,2) DEFAULT 0
);


ALTER TABLE public.kis_trx_deposito OWNER TO postgres;

--
-- TOC entry 2024 (class 0 OID 0)
-- Dependencies: 171
-- Name: TABLE kis_trx_deposito; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE kis_trx_deposito IS 'SELECT
rekdep||nourut AS notran,
rekdep AS nomrek,
nourut,
tglbyr AS trx_date,
salawl AS saldo_awal,
jumtra AS jumlah,
(salawl + jumtra) AS saldo
FROM depo_htrn';


--
-- TOC entry 172 (class 1259 OID 769111)
-- Name: kis_trx_pembiayaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kis_trx_pembiayaan (
    id character varying(32) DEFAULT uuid() NOT NULL,
    notran character varying(20) NOT NULL,
    nomrek character varying(20),
    angs_ke integer,
    tgl_jtempo date,
    angs_pokok numeric(15,2) DEFAULT 0,
    angs_margin numeric(15,2) DEFAULT 0,
    saldo_pokok numeric(15,2) DEFAULT 0,
    saldo_margin numeric(15,2) DEFAULT 0,
    sts_bayar character(1),
    tgl_bayar date
);


ALTER TABLE public.kis_trx_pembiayaan OWNER TO postgres;

--
-- TOC entry 2025 (class 0 OID 0)
-- Dependencies: 172
-- Name: TABLE kis_trx_pembiayaan; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE kis_trx_pembiayaan IS 'SELECT
a.nompyd||a.conang AS id_trx,
a.nompyd AS nomrek,
a.tglang AS tgl_jtempo,
a.conang AS angs_ke,
a.angpkk AS angs_pkk,
a.angmgn AS angs_mgn,
a.salpkk AS saldo_pkk,
a.salmgn AS saldo_mgn,
b.flangs AS sts_bayar,
b.tglbyr AS tgl_bayar
FROM pyd_tabang AS a
LEFT JOIN pyd_angs AS b ON a.nompyd = b.nompyd AND a.conang = b.conang
LEFT JOIN pyd_mast AS c ON a.nompyd = c.nompyd
WHERE (c.tgdrop >= ''2022-01-01'') OR (c.tgdrop < ''2022-01-01'' and c.stspyd=''1'' )';


--
-- TOC entry 173 (class 1259 OID 769128)
-- Name: kis_trx_simpanan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kis_trx_simpanan (
    id character varying(32) DEFAULT uuid() NOT NULL,
    notran character varying(20) NOT NULL,
    noanggota character varying(20),
    trx_date date,
    jenis_trx character(1),
    saldo_awal numeric(15,2) DEFAULT 0,
    dc_trx character(1),
    amount_trx numeric(15,2) DEFAULT 0,
    saldo numeric(15,2) DEFAULT 0,
    keterangan text
);


ALTER TABLE public.kis_trx_simpanan OWNER TO postgres;

--
-- TOC entry 2026 (class 0 OID 0)
-- Dependencies: 173
-- Name: TABLE kis_trx_simpanan; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE kis_trx_simpanan IS 'SELECT
traled AS notran,
idanggota AS noanggota,
tglbyr AS trx_date,
jnapli AS jenis_trx,
salawl AS saldo_awal,
kdmnem AS dc_trx,
jumtra AS amount_trx,
(salawl + jumtra) AS saldo,
ketera AS keterangan
FROM ang_htrn WHERE tglbyr >= ''2022-01-01''
ORDER BY jnapli';


--
-- TOC entry 2027 (class 0 OID 0)
-- Dependencies: 173
-- Name: COLUMN kis_trx_simpanan.jenis_trx; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN kis_trx_simpanan.jenis_trx IS '1 = Simpok / LWK, 2 = Simwa / Tab 5%, 3 = Simwa / Minggon, 4 = Sukarela';


--
-- TOC entry 174 (class 1259 OID 769147)
-- Name: kis_user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kis_user (
    id character varying(32) DEFAULT uuid() NOT NULL,
    id_user character varying(20) NOT NULL,
    tipe_user integer,
    password character varying(50),
    token text,
    last_login timestamp without time zone
);


ALTER TABLE public.kis_user OWNER TO postgres;

--
-- TOC entry 2028 (class 0 OID 0)
-- Dependencies: 174
-- Name: COLUMN kis_user.tipe_user; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN kis_user.tipe_user IS '1 = Anggota 2 = Pengelola';


--
-- TOC entry 2003 (class 0 OID 769040)
-- Dependencies: 168
-- Data for Name: kis_anggota; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY kis_anggota (id, noanggota, nama, majelis, desa, status, simpok, simwa, sukarela) FROM stdin;
f91159b78a4040b0b7b2b97dd3d612c1	0101010101	NINING SUNENGSIH	TALAS	CIHERANG	3	0.00	0.00	0.00
bea0629d68044b9383520f2efaf3839b	0101010105	TARSIH	TALAS 2	CIHERANG	1	10000.00	0.00	8385.00
\.


--
-- TOC entry 2004 (class 0 OID 769054)
-- Dependencies: 169
-- Data for Name: kis_deposito; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY kis_deposito (id, nomrek, noanggota, status, produk, tgl_buka, jk_waktu, tgl_jtempo, saldo, bagihasil) FROM stdin;
\.


--
-- TOC entry 2005 (class 0 OID 769060)
-- Dependencies: 170
-- Data for Name: kis_pembiayaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY kis_pembiayaan (id, nomrek, noanggota, status, produk, tgl_droping, pokok, margin, jk_waktu, cnt_bayar, bayar_pkk, bayar_mgn, saldo_pkk, saldo_mgn) FROM stdin;
\.


--
-- TOC entry 2006 (class 0 OID 769095)
-- Dependencies: 171
-- Data for Name: kis_trx_deposito; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY kis_trx_deposito (id, notran, nomrek, nourut, trx_date, saldo_awal, amount_trx, saldo) FROM stdin;
\.


--
-- TOC entry 2007 (class 0 OID 769111)
-- Dependencies: 172
-- Data for Name: kis_trx_pembiayaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY kis_trx_pembiayaan (id, notran, nomrek, angs_ke, tgl_jtempo, angs_pokok, angs_margin, saldo_pokok, saldo_margin, sts_bayar, tgl_bayar) FROM stdin;
\.


--
-- TOC entry 2008 (class 0 OID 769128)
-- Dependencies: 173
-- Data for Name: kis_trx_simpanan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY kis_trx_simpanan (id, notran, noanggota, trx_date, jenis_trx, saldo_awal, dc_trx, amount_trx, saldo, keterangan) FROM stdin;
\.


--
-- TOC entry 2009 (class 0 OID 769147)
-- Dependencies: 174
-- Data for Name: kis_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY kis_user (id, id_user, tipe_user, password, token, last_login) FROM stdin;
dd979dcd052e49aaa40ec7db892ae1b1	pengelola	2	e54ed4620a7bd18d551fd66afc91e7a664d6e7c5	eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF91c2VyIjoicGVuZ2Vsb2xhIiwicGFzc3dvcmQiOiJlNTRlZDQ2MjBhN2JkMThkNTUxZmQ2NmFmYzkxZTdhNjY0ZDZlN2M1IiwibGFzdF9sb2dpbiI6IjIwMjItMTAtMDkgMjE6NTA6MDQifQ.H7L3Y2dU2CnEByIali8K_r8JLzPe3utS_iKAJp_JY2c	2022-10-09 21:50:04
15d23db296c74dc5a98afc5f90324e5d	0101010105	1	d8bbfa8e7af130d365e4c68b41b1a637a1b42417	eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF91c2VyIjoiMDEwMTAxMDEwNSIsInRpcGVfdXNlciI6IjEiLCJwYXNzd29yZCI6ImQ4YmJmYThlN2FmMTMwZDM2NWU0YzY4YjQxYjFhNjM3YTFiNDI0MTciLCJsYXN0X2xvZ2luIjoiMjAyMi0xMC0xMCAwOTo1MjoxMiJ9.lYPVZnnaU6nHOwaCqdGC87hKby011MhWDHBPJ-s1-Kw	2022-10-10 09:52:12
\.


--
-- TOC entry 1993 (class 2606 OID 769136)
-- Name: kis_trx_simpanan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_trx_simpanan
    ADD CONSTRAINT kis_trx_simpanan_pkey PRIMARY KEY (notran);


--
-- TOC entry 1973 (class 2606 OID 769045)
-- Name: pk_id_anggota; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_anggota
    ADD CONSTRAINT pk_id_anggota PRIMARY KEY (id);


--
-- TOC entry 1977 (class 2606 OID 769059)
-- Name: pk_id_deposito; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_deposito
    ADD CONSTRAINT pk_id_deposito PRIMARY KEY (id);


--
-- TOC entry 1981 (class 2606 OID 769065)
-- Name: pk_id_pembiayaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_pembiayaan
    ADD CONSTRAINT pk_id_pembiayaan PRIMARY KEY (id);


--
-- TOC entry 1985 (class 2606 OID 769100)
-- Name: pk_id_trx_deposito; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_trx_deposito
    ADD CONSTRAINT pk_id_trx_deposito PRIMARY KEY (id);


--
-- TOC entry 1989 (class 2606 OID 769116)
-- Name: pk_id_trx_pembiayaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_trx_pembiayaan
    ADD CONSTRAINT pk_id_trx_pembiayaan PRIMARY KEY (id);


--
-- TOC entry 1997 (class 2606 OID 769155)
-- Name: pk_kis_user; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_user
    ADD CONSTRAINT pk_kis_user PRIMARY KEY (id_user);


--
-- TOC entry 1975 (class 2606 OID 769047)
-- Name: uq_noanggota; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_anggota
    ADD CONSTRAINT uq_noanggota UNIQUE (noanggota);


--
-- TOC entry 1979 (class 2606 OID 769068)
-- Name: uq_nomrek_deposito; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_deposito
    ADD CONSTRAINT uq_nomrek_deposito UNIQUE (nomrek);


--
-- TOC entry 1983 (class 2606 OID 769070)
-- Name: uq_nomrek_pembiayaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_pembiayaan
    ADD CONSTRAINT uq_nomrek_pembiayaan UNIQUE (nomrek);


--
-- TOC entry 1987 (class 2606 OID 769110)
-- Name: uq_notran_deposito; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_trx_deposito
    ADD CONSTRAINT uq_notran_deposito UNIQUE (notran);


--
-- TOC entry 1991 (class 2606 OID 769127)
-- Name: uq_notran_trx_pembiayaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_trx_pembiayaan
    ADD CONSTRAINT uq_notran_trx_pembiayaan UNIQUE (notran);


--
-- TOC entry 1995 (class 2606 OID 769146)
-- Name: uq_notran_trx_simpanan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kis_trx_simpanan
    ADD CONSTRAINT uq_notran_trx_simpanan UNIQUE (notran);


--
-- TOC entry 1998 (class 2606 OID 769084)
-- Name: fk_noanggota_deposito; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY kis_deposito
    ADD CONSTRAINT fk_noanggota_deposito FOREIGN KEY (noanggota) REFERENCES kis_anggota(noanggota) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 1999 (class 2606 OID 769090)
-- Name: fk_noanggota_pembiayaan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY kis_pembiayaan
    ADD CONSTRAINT fk_noanggota_pembiayaan FOREIGN KEY (noanggota) REFERENCES kis_anggota(noanggota) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2002 (class 2606 OID 769157)
-- Name: fk_noanggota_trx_simpanan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY kis_trx_simpanan
    ADD CONSTRAINT fk_noanggota_trx_simpanan FOREIGN KEY (noanggota) REFERENCES kis_anggota(noanggota) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2000 (class 2606 OID 769104)
-- Name: fk_nomrek_trx_deposito; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY kis_trx_deposito
    ADD CONSTRAINT fk_nomrek_trx_deposito FOREIGN KEY (nomrek) REFERENCES kis_deposito(nomrek) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2001 (class 2606 OID 769121)
-- Name: fk_nomrek_trx_pembiayaan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY kis_trx_pembiayaan
    ADD CONSTRAINT fk_nomrek_trx_pembiayaan FOREIGN KEY (nomrek) REFERENCES kis_pembiayaan(nomrek) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2016 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2022-10-10 11:07:19

--
-- PostgreSQL database dump complete
--

