CREATE TABLE `departments` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `rooms` (
  `room_number` integer PRIMARY KEY,
  `department_id` integer,
  `is_empty` boolean
);

CREATE TABLE `patients` (
  `insurance_id` integer PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `doctors` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `department_id` integer
);

CREATE TABLE `nurses` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `stays` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `patient_id` integer,
  `nurse_id` integer,
  `room_id` integer,
  `start_date` date,
  `end_date` date,
  `diagnose_name` varchar(255)
);

CREATE TABLE `appointments` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `date` date,
  `patient_id` integer,
  `doctor_id` integer,
  `prescription_id` integer,
  `diagnose_name` varchar(255)
);

CREATE TABLE `prescriptions` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `date` date
);

CREATE TABLE `medicine` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `barcode` varchar(255),
  `name` varchar(255),
  `description` longtext,
  `stock` integer
);

CREATE TABLE `medicine_prescription` (
  `prescription_id` integer,
  `medicine_name` varchar(255),
  `instructions` longtext,
  `quantity` integer,
  PRIMARY KEY (`prescription_id`, `medicine_name`)
);

ALTER TABLE `patients` COMMENT = 'Stores patient info';

ALTER TABLE `doctors` COMMENT = 'Stores doctor info';

ALTER TABLE `nurses` COMMENT = 'Stores nurse info';

ALTER TABLE `stays` COMMENT = 'Stores stay (hospitalization) info';

ALTER TABLE `appointments` COMMENT = 'Stores appointment info';

ALTER TABLE `prescriptions` COMMENT = 'Stores prescription info';

ALTER TABLE `medicine` COMMENT = 'Stores medication info';

ALTER TABLE `medicine_prescription` COMMENT = 'Stores quantity of each type of medicine in prescriptions';

ALTER TABLE `rooms` ADD FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

ALTER TABLE `doctors` ADD FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

ALTER TABLE `stays` ADD FOREIGN KEY (`patient_id`) REFERENCES `patients` (`insurance_id`);

ALTER TABLE `stays` ADD FOREIGN KEY (`nurse_id`) REFERENCES `nurses` (`id`);

ALTER TABLE `stays` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_number`);

ALTER TABLE `appointments` ADD FOREIGN KEY (`patient_id`) REFERENCES `patients` (`insurance_id`);

ALTER TABLE `appointments` ADD FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

ALTER TABLE `appointments` ADD FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

ALTER TABLE `medicine_prescription` ADD FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);
