-- Create the database
CREATE DATABASE IF NOT EXISTS database01;
USE database01;

-- Table "patient" creation
CREATE TABLE IF NOT EXISTS patient (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    pn VARCHAR(11) DEFAULT NULL,
    first VARCHAR(15) DEFAULT NULL,
    last VARCHAR(25) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    PRIMARY KEY (_id)
);

-- Table "insurance" creation
CREATE TABLE IF NOT EXISTS insurance (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_id INT(10) UNSIGNED NOT NULL,
    iname VARCHAR(40) DEFAULT NULL,
    from_date DATE DEFAULT NULL,
    to_date DATE DEFAULT NULL,
    PRIMARY KEY (_id),
    FOREIGN KEY (patient_id) REFERENCES patient(_id)
);

-- Dummy data for the "patient" table
INSERT INTO patient (pn, first, last, dob) VALUES
    ('PN001', 'Andreas', 'Õun', '2000-11-29'),
    ('PN002', 'Marten', 'Tamm', '1995-03-25'),
    ('PN003', 'Joosep', 'Tata', '1982-11-30'),
    ('PN004', 'Hanna', 'Toots', '1998-09-05'),
    ('PN005', 'Ene', 'Rull', '2002-04-18');

-- Dummy data for the "insurance" table
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES
    (1, 'Seesam Insurers', '2023-06-01', '2024-05-31'),
    (1, 'BTA Insurance', '2023-03-15', '2026-09-15'),
    (2, 'PZU insurance', '2022-12-20', '2027-12-19'),
    (2, 'Ergo Insure', '2023-01-10', '2025-07-10'),
    (3, 'Inges Insurance', '2023-02-25', '2024-08-25'),
    (3, 'CGI', '2022-11-10', '2029-11-09'),
    (4, 'LifeWise', '2023-05-15', '2024-05-14'),
    (5, 'SecureLife Ins.', '2023-03-05', '2027-09-04');
