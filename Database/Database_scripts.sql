-- CREAZIONE UTENTE

CREATE ROLE www WITH
	LOGIN
	SUPERUSER
	CREATEDB
	CREATEROLE
	INHERIT
	NOREPLICATION
	BYPASSRLS
	CONNECTION LIMIT -1
	PASSWORD 'xxxxxx';

-- CREAZIONE DATABASE

CREATE DATABASE gruppo38
    WITH
    OWNER = www
    ENCODING = 'UTF8'
    LOCALE_PROVIDER = 'libc'
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

-- CREAZIONE TABELLA UTENTE

DROP TABLE IF EXISTS utente cascade;
CREATE TABLE utente(
id serial PRIMARY KEY,
username varchar(255),
email varchar(255),
password varchar(255)
);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

-- CREAZIONE TABELLA COMMENTI

CREATE TABLE commenti (
    id SERIAL PRIMARY KEY,
    nome_utente VARCHAR(50) NOT NULL,
    testo TEXT NOT NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CREAZIONE TABELLA COMMENTI SEZIONI

CREATE TABLE commenti_sezioni (
    id SERIAL PRIMARY KEY,
    home TEXT NOT NULL,
	disegno TEXT NOT NULL,
	videogiochi TEXT NOT NULL,
	musica TEXT NOT NULL,
	cinema TEXT NOT NULL,
	menzioni TEXT NOT NULL,
	forum TEXT NOT NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CREAZIONE TABELLA DELLE IMMAGINI PREFERITE

CREATE TABLE preferiti (
    id SERIAL PRIMARY KEY,
    email_utente VARCHAR(255) NOT NULL,
    percorso_immagine TEXT NOT NULL,
    data_aggiunta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Questo vincolo permette immagini diverse per lo stesso utente
    UNIQUE(email_utente, percorso_immagine) 
);

-- INSERIMENTO TABELLA

INSERT INTO utente (username, email, password)
VALUES (Michele, michelepio44@gmail.com, $2y$10$rCvNW1/ZIFfP6eoIbZq15.4bJZ60hDg6QpSUQb9XMLm5/tLbqhHkG); --1234