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

INSERT INTO `Room` (`RoomNumber`, `DepartmentID`) VALUES
(101, 1),
(102, 2),
(103, 3);

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
(10, 'Laura', 'Clark', '1983-09-10', 'Female', '555-0110', 'laura.clark@example.com', '707 Maple Rd');

-- INSERT INTO `Employee` (`email`, `password`, `FirstName`, `LastName`, `type`, `DepartmentID`, `ContactNumber`) VALUES
-- ('d@d.com',  'Alice', 'Hamilton', 1, '1111111111', 'aliceh@hospital.com'),
-- ('Nora', 'Jones', '1231231234', 'noraj@hospital.com');

INSERT INTO `Appointment` (`PatientID`, `DoctorID`, `Date`) VALUES
(1, 1, '2023-11-15 10:00:00'),
(2, 1, '2023-11-15 11:00:00'),
(3, 1, '2023-11-15 09:30:00');

INSERT INTO `Admission` (`PatientID`, `DoctorID`, `NurseID`, `AdmissionStartDate`, `AdmissionEndDate`, `RoomNumber`) VALUES
(1, 1, 2, '2023-11-01', '2023-11-10', 101),
(2, 1, 2, '2023-11-02', '2023-11-12', 102),
(3, 1, 2, '2023-11-03', '2023-11-13', 103);

INSERT INTO `Medication` (`PatientID`, `DoctorID`, `Name`, `Dosage`, `Frequency`, `StartDate`, `EndDate`, `OtherDescription`) VALUES
(1, 1, 'Medication A', '100mg', 'Twice a day', '2023-11-01', '2023-11-10', 'Take with food'),
(2, 1, 'Medication B', '200mg', 'Once a day', '2023-11-02', '2023-11-12', 'Take on empty stomach');




