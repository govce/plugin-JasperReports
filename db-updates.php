<?php
namespace JasperReports;
use MapasCulturais\App;

$app = App::i();
$em = $app->em;
$conn = $em->getConnection();

function __table_exists($table_name) {
    $app = App::i();
    $em = $app->em;
    $conn = $em->getConnection();

    if($conn->fetchAll("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_name = '$table_name';")){
        return true;
    } else {
        return false;
    }
}

function __sequence_exists($sequence_name) {
    $app = App::i();
    $em = $app->em;
    $conn = $em->getConnection();

    if($conn->fetchAll("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = 'public' AND sequence_name = '$sequence_name';")){
        return true;
    } else {
        return false;
    }
}

return [    
    'JASPER REPORT PLUGIN create report table ' => function() use ($conn) {
        if(__table_exists('report')){
            echo "TABLE report ALREADY EXISTS";
        } else {
            $conn->executeQuery("CREATE TABLE report (
                id integer NOT NULL,
                name character varying(255) NOT NULL,
                description text,
                sql text,
                params text,
                view_agent boolean NOT NULL DEFAULT false,
                view_agent_ids varying(255),
                view_event boolean NOT NULL DEFAULT false,
                view_event_ids varying(255),
                view_space boolean NOT NULL DEFAULT false,
                view_space_ids varying(255),
                view_project boolean NOT NULL DEFAULT false,
                view_project_ids varying(255),
                view_opportunity boolean NOT NULL DEFAULT false,
                view_opportunity_ids varying(255),
                create_timestamp timestamp without time zone NOT NULL,
                update_timestamp timestamp without time zone,
                status smallint NOT NULL,
                subsite_id integer,
                agent_id integer,
                CONSTRAINT report_pkey PRIMARY KEY(id)
            );");
        }
        if(__sequence_exists('report_id_seq')){
            echo "SEQUENCE report_id_seq ALREADY EXISTS";
        } else {
            $last_id = $conn->fetchColumn ('SELECT max(id) FROM report;');
            $last_id++;
            $conn->executeQuery("CREATE SEQUENCE report_id_seq
                                    START WITH $last_id
                                    INCREMENT BY 1
                                    NO MINVALUE
                                    NO MAXVALUE
                                    CACHE 1;");

            $conn->executeQuery("ALTER TABLE ONLY report ALTER COLUMN id SET DEFAULT nextval('report_id_seq'::regclass);");
        }
        
    },
    'JASPER REPORT PLUGIN create report_meta table ' => function() use ($conn) {
        if(__table_exists('report_meta')){
            echo "TABLE report ALREADY EXISTS";
        } else {
            $conn->executeQuery("CREATE TABLE report_meta (
                id integer NOT NULL,
                key character varying(255) NOT NULL,
                value text,
                object_id integer NOT NULL,
                CONSTRAINT report_meta_pkey PRIMARY KEY(id),
                CONSTRAINT fk_report_meta_object_id FOREIGN KEY (object_id)
                    REFERENCES report (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE CASCADE
            );");
        }
        if(__sequence_exists('report_meta_id_seq')){
            echo "SEQUENCE report_meta_id_seq ALREADY EXISTS";
        } else {
            $last_id = $conn->fetchColumn ('SELECT max(id) FROM report;');
            $last_id++;
            $conn->executeQuery("CREATE SEQUENCE report_meta_id_seq
                                    START WITH $last_id
                                    INCREMENT BY 1
                                    NO MINVALUE
                                    NO MAXVALUE
                                    CACHE 1;");

            $conn->executeQuery("ALTER TABLE ONLY report_meta ALTER COLUMN id SET DEFAULT nextval('report_meta_id_seq'::regclass);");
        }
        
    }, 
    'JASPER REPORT PLUGIN create report_field_configuration table ' => function() use ($conn) {
        if(__table_exists('report_field_configuration')){
            echo "TABLE report ALREADY EXISTS";
        } else {
            $conn->executeQuery("CREATE TABLE report_field_configuration
            (
                id integer NOT NULL,
                report_id integer,
                title character varying(255) NOT NULL,
                description text,
                categories text,
                required boolean NOT NULL,
                field_type character varying(255) NOT NULL,
                field_options text NOT NULL,
                max_size text,
                display_order bigint DEFAULT 255,
                config text,
                mask text,
                mask_options text,
                CONSTRAINT report_field_configuration_pkey PRIMARY KEY (id),
                CONSTRAINT fk_report_field_configuration_report_id FOREIGN KEY (report_id)
                    REFERENCES report (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE CASCADE
            );");
        }
        if(__sequence_exists('report_field_configuration_id_seq')){
            echo "SEQUENCE report_field_configuration_id_seq ALREADY EXISTS";
        } else {
            $last_id = $conn->fetchColumn ('SELECT max(id) FROM report;');
            $last_id++;
            $conn->executeQuery("CREATE SEQUENCE report_field_configuration_id_seq
                                    START WITH $last_id
                                    INCREMENT BY 1
                                    NO MINVALUE
                                    NO MAXVALUE
                                    CACHE 1;");

            $conn->executeQuery("ALTER TABLE ONLY report_field_configuration ALTER COLUMN id SET DEFAULT nextval('report_field_configuration_id_seq'::regclass);");
        }
        
    },   
    'JASPER REPORT PLUGIN add jasper report type to object_type ' => function() use ($conn) {
        if($conn->fetchAll("SELECT *  FROM (SELECT unnest(enum_range(NULL::object_type)) as values) as obj WHERE obj.values IN ( 'MapasCulturais\Entities\Report');")){
            return true;
        } else {
            $conn->executeQuery("ALTER TYPE object_type ADD VALUE 'MapasCulturais\Entities\Report'; ");
        }
    }

    

];