#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

    CREATE TABLE ingredients (
        uuid uuid NOT NULL DEFAULT uuid_generate_v4(),
        name varchar(40) NOT NULL,
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (uuid)
    );

    CREATE TABLE units (
        uuid uuid NOT NULL DEFAULT uuid_generate_v4(),
        name varchar(40) NOT NULL,
        abbreviation varchar(10) NOT NULL,
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (uuid)
    );

    CREATE TABLE equipment (
        uuid uuid NOT NULL DEFAULT uuid_generate_v4(),
        name varchar(40) NOT NULL,
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (uuid)
    );

    CREATE TABLE recipes (
        uuid uuid NOT NULL DEFAULT uuid_generate_v4(),
        name varchar(40) NOT NULL,
        description varchar(1024) NOT NULL,
        timing interval hour to minute NOT NULL,
        serving_size smallint NOT NULL,        
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (uuid)
    );

    CREATE TABLE recipe_ingredient (
        recipe_id uuid REFERENCES recipes(uuid),
        ingredient_id uuid REFERENCES ingredients(uuid),
        unit_id uuid REFERENCES units(uuid),
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (recipe_id, ingredient_id)
    );

    CREATE TABLE photos (
        uuid uuid NOT NULL DEFAULT uuid_generate_v4(),
        title varchar(40) NOT NULL,
        url varchar(1024) NOT NULL,
        recipe_id uuid REFERENCES recipes(uuid) NOT NULL,
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (uuid)
    );

    CREATE TABLE steps (
        uuid uuid NOT NULL DEFAULT uuid_generate_v4(),
        index smallint NOT NULL,
        instruction varchar(1024) NOT NULL,
        recipe_id uuid REFERENCES recipes(uuid) NOT NULL, 
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (uuid)
    );

    CREATE TABLE labels (
        uuid uuid NOT NULL DEFAULT uuid_generate_v4(),
        name varchar(40) NOT NULL,
        colour varchar(40) NOT NULL,
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (uuid)
    );

    CREATE TABLE recipe_label (
        label_id uuid REFERENCES labels(uuid) NOT NULL, 
        recipe_id uuid REFERENCES recipes(uuid) NOT NULL, 
        created_at timestamp with time zone NOT NULL DEFAULT now(),
        updated_at timestamp with time zone NOT NULL DEFAULT now(),
        PRIMARY KEY (recipe_id, label_id)
    );

EOSQL
