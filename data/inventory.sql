CREATE DATABASE inventory;
USE inventory;

CREATE TABLE inventory (
    engine_number INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(255) NOT NULL,
    color VARCHAR(50) NOT NULL,
    date_of_arrival DATE NOT NULL,
    delivery_area VARCHAR(255) NOT NULL,
    location_of_clearance VARCHAR(255) NOT NULL,
    date_sent_out DATE NOT NULL
);

INSERT INTO inventory (engine_number, model, color, date_of_arrival, delivery_area, location_of_clearance, date_sent_out) VALUES
(27130, 'BOLT125', 'RED BLACK', '2026-02-01', 'MASBATE', 'MASBATE', '2026-02-05'),
(27131, 'BOLT125', 'RED BLACK', '2026-02-02', 'MASBATE', 'MASBATE', '2026-02-06'),
(27132, 'BOLT125', 'RED BLACK', '2026-02-03', 'MASBATE', 'MASBATE', '2026-02-07'),
(27133, 'BOLT125', 'RED BLACK', '2026-02-04', 'MASBATE', 'MASBATE', '2026-02-08'),
(27134, 'BOLT125', 'RED BLACK', '2026-02-05', 'MASBATE', 'MASBATE', '2026-02-09');
    