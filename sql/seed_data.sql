INSERT INTO `Department` (`ID`, `Name`) VALUES
(1, 'Cardiology'),
(2, 'Neurology'),
(3, 'Oncology'),
(4, 'Pediatrics'),
(5, 'Orthopedics'),
(6, 'Dermatology'),
(7, 'Gastroenterology'),
(8, 'Urology'),
(9, 'Emergency Medicine'),
(10, 'Endocrinology'),
(11, 'Cardiology'),
(12, 'Neurology'),
(13, 'Oncology'),
(14, 'Pediatrics'),
(15, 'Orthopedics'),
(16, 'Dermatology'),
(17, 'Gastroenterology'),
(18, 'Urology'),
(19, 'Emergency Medicine'),
(20, 'Endocrinology');

INSERT INTO `Employee` (`ID`, `email`, `password`, `firstName`, `lastName`, `type`, `departmentID`, `contactNumber`) VALUES
(1, 'd@d.com', '$2y$10$7hXvG4Pe.Ur70kUYBLFBlO18zsf5WMGfRFrpBoKFXXwGqSEXo.M6m', 'Alice', 'Hamilton', 'doctor', 1, '69453636'),
(2, 'n@n.com', '$2y$10$QMVycXG8LWtLLWFQiw2Eruc.zIh3x0KnmZ9ux1TIB48GLbzn.DqVq', 'John', 'Morrison', 'nurse', NULL, '69453635367'),
(3, 's@s.com', '$2y$10$TiRsTK7YEp0BhYBppVUkwOI7X.FwI1cuUBn8MXbI4OWbqfUWmoNWO', 'George', 'Jackson', 'secretary', NULL, '69453696579');

INSERT INTO `Patient` (`ID`, `FirstName`, `LastName`, `DateOfBirth`, `Gender`, `ContactNumber`, `EmailAddress`, `Address`) VALUES
(1, 'John', 'Doe', '1980-01-01', 'Male', '555-0101', 'john.doe@example.com', '123 Main St'),
(2, 'Jane', 'Smith', '1990-05-15', 'Female', '555-0102', 'jane.smith@example.com', '456 Maple Ave'),
(3, 'Michael', 'Brown', '1975-07-20', 'Male', '555-0103', 'michael.brown@example.com', '789 Oak Rd'),
(4, 'Emily', 'Jones', '1988-03-30', 'Female', '555-0104', 'emily.jones@example.com', '101 Pine St'),
(5, 'David', 'Miller', '1992-11-08', 'Male', '555-0105', 'david.miller@example.com', '202 Elm St'),
(6, 'Sarah', 'Wilson', '1985-06-04', 'Female', '555-0106', 'sarah.wilson@example.com', '303 Birch Rd'),
(7, 'James', 'Taylor', '1970-02-17', 'Male', '555-0107', 'james.taylor@example.com', '404 Cedar Ln'),
(8, 'Anna', 'Anderson', '2002-08-22', 'Female', '555-0108', 'anna.anderson@example.com', '505 Oak St'),
(9, 'Robert', 'Harris', '1999-12-05', 'Male', '555-0109', 'robert.harris@example.com', '606 Pine Ave'),
(10, 'Laura', 'Clark', '1983-09-10', 'Female', '555-0110', 'laura.clark@example.com', '707 Maple Rd'),
(4747, 'dg', 'dhdh', '2023-11-29', 'male', 'ddh', 'dhdh', 'ddhdj');

INSERT INTO `Room` (`RoomNumber`, `DepartmentID`) VALUES
(101, 1),
(102, 2),
(103, 3);

INSERT INTO `Admission` (`ID`, `PatientID`, `DoctorID`, `NurseID`, `StartDate`, `EndDate`, `RoomNumber`, `Reason`) VALUES
(1, 1, 1, 2, '2023-11-01', '2024-12-29', 101, 'ety'),
(2, 2, 1, 2, '2023-11-02', '2024-12-27', 102, 'rhrh'),
(3, 3, 1, 2, '2023-11-03', '2023-11-13', 103, 'rhrh');

INSERT INTO `Appointment` (`PatientID`, `DoctorID`, `Date`) VALUES
(1, 1, '2023-11-15 10:00:00'),
(1, 1, '2023-11-15 11:30:00'),
(2, 1, '2023-11-15 11:00:00'),
(3, 1, '2023-11-15 09:30:00');

INSERT INTO `Medication` (`ID`, `PatientID`, `DoctorID`, `Name`, `Dosage`, `Frequency`, `StartDate`, `EndDate`, `OtherDescription`) VALUES
(1, 1, 1, 'Medication A', '100mg', 'Twice a day', '2023-11-01', '2023-11-10', 'Take with food'),
(2, 2, 1, 'Medication B', '200mg', 'Once a day', '2023-11-02', '2023-11-12', 'Take on empty stomach');

