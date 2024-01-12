INSERT INTO `Department` (`Name`) VALUES
('Cardiology'),
('Neurology'),
('Oncology'),
('Pediatrics'),
('Orthopedics'),
('Dermatology'),
('Gastroenterology'),
('Urology'),
('Emergency Medicine'),
('Endocrinology');

INSERT INTO `Employee` (`email`, `password`, `firstName`, `lastName`, `type`, `departmentID`, `contactNumber`) VALUES
('d@d.com', '$2y$10$7hXvG4Pe.Ur70kUYBLFBlO18zsf5WMGfRFrpBoKFXXwGqSEXo.M6m', 'Alice', 'Hamilton', 'doctor', 1, '69453636'),
('d1@d.com', '$2y$10$TiRsTK7YEp0BhYBppVUkwOI7X.FwI1cuUBn8MXbI4OWbqfUWmoNWO', 'Maria', 'Bella', 'doctor', 2, '69453696579'),
('d2@d.com', '$2y$10$TiRsTK7YEp0BhYBppVUkwOI7X.FwI1cuUBn8MXbI4OWbqfUWmoNWO', 'Nick', 'Obama', 'doctor', 3, '69453696579'),
('d3@d.com', '$2y$10$TiRsTK7YEp0BhYBppVUkwOI7X.FwI1cuUBn8MXbI4OWbqfUWmoNWO', 'Jack', 'Mario', 'doctor', 4, '69453696579'),
('n@n.com', '$2y$10$QMVycXG8LWtLLWFQiw2Eruc.zIh3x0KnmZ9ux1TIB48GLbzn.DqVq', 'John', 'Morrison', 'nurse', NULL, '69453635367'),
('n2@n.com', '$2y$10$QMVycXG8LWtLLWFQiw2Eruc.zIh3x0KnmZ9ux1TIB48GLbzn.DqVq', 'Bill', 'Camerin', 'nurse', NULL, '69453635367'),
('n3@n.com', '$2y$10$QMVycXG8LWtLLWFQiw2Eruc.zIh3x0KnmZ9ux1TIB48GLbzn.DqVq', 'Giorgio', 'Armani', 'nurse', NULL, '69453635367'),
('s@s.com', '$2y$10$TiRsTK7YEp0BhYBppVUkwOI7X.FwI1cuUBn8MXbI4OWbqfUWmoNWO', 'George', 'Jackson', 'secretary', NULL, '69453696579');

INSERT INTO `Patient` (`ID`, `FirstName`, `LastName`, `DateOfBirth`, `Gender`, `ContactNumber`, `EmailAddress`, `Address`) VALUES
(11111, 'John', 'Doe', '1980-01-01', 'Male', '555-0101', 'john.doe@example.com', '123 Main St'),
(22222, 'Jane', 'Smith', '1990-05-15', 'Female', '555-0102', 'jane.smith@example.com', '456 Maple Ave'),
(33333, 'Michael', 'Brown', '1975-07-20', 'Male', '555-0103', 'michael.brown@example.com', '789 Oak Rd'),
(44444, 'Emily', 'Jones', '1988-03-30', 'Female', '555-0104', 'emily.jones@example.com', '101 Pine St'),
(55555, 'David', 'Miller', '1992-11-08', 'Male', '555-0105', 'david.miller@example.com', '202 Elm St'),
(66666, 'Sarah', 'Wilson', '1985-06-04', 'Female', '555-0106', 'sarah.wilson@example.com', '303 Birch Rd'),
(77777, 'James', 'Taylor', '1970-02-17', 'Male', '555-0107', 'james.taylor@example.com', '404 Cedar Ln'),
(88888, 'Anna', 'Anderson', '2002-08-22', 'Female', '555-0108', 'anna.anderson@example.com', '505 Oak St'),
(99999, 'Robert', 'Harris', '1999-12-05', 'Male', '555-0109', 'robert.harris@example.com', '606 Pine Ave'),
(18956, 'Laura', 'Clark', '1983-09-10', 'Female', '555-0110', 'laura.clark@example.com', '707 Maple Rd');

INSERT INTO `Room` (`RoomNumber`, `DepartmentID`) VALUES
(101, 1),
(102, 2),
(103, 3),
(104, 4),
(105, 5),
(106, 6),
(107, 7),
(108, 8),
(109, 9),
(110, 10);

INSERT INTO `Admission` (`PatientID`, `DoctorID`, `NurseID`, `StartDate`, `EndDate`, `RoomNumber`, `Reason`) VALUES
(11111, 1, 5, '2024-01-01', '2024-01-30', 101, 'Fever'),
(22222, 2, 5, '2023-01-15', NULL, 102, 'COVID-19'),
(33333, 3, 5, '2023-11-03', NULL, 103, 'Virus');

INSERT INTO `Appointment` (`PatientID`, `DoctorID`, `Date`) VALUES
(11111, 1, '2024-01-30 10:00:00'),
(22222, 1, '2024-01-30 11:30:00'),
(33333, 1, '2024-01-30 11:00:00'),
(44444, 1, '2024-01-30 09:30:00');

INSERT INTO `Medication` (`PatientID`, `DoctorID`, `Name`, `Dosage`, `Frequency`, `StartDate`, `EndDate`, `OtherDescription`) VALUES
(11111, 1, 'Medication A', '100mg', 'Twice a day', '2023-11-01', '2023-11-10', 'Take with food'),
(22222, 1, 'Medication B', '200mg', 'Once a day', '2023-11-02', '2023-11-12', 'Take on empty stomach');

