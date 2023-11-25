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

INSERT INTO `Doctor` (`FirstName`, `LastName`, `DepartmentID`, `ContactNumber`, `email`) VALUES
('Alice', 'Hamilton', 1, '1111111111', 'aliceh@hospital.com'),
('Brian', 'Clark', 2, '2222222222', 'brianc@hospital.com'),
('Catherine', 'Adams', 3, '3333333333', 'catherinea@hospital.com'),
('Daniel', 'Baker', 4, '4444444444', 'danielb@hospital.com'),
('Evelyn', 'Lewis', 5, '5555555555', 'evelynl@hospital.com'),
('Frank', 'White', 6, '6666666666', 'frankw@hospital.com'),
('Grace', 'Harris', 7, '7777777777', 'graceh@hospital.com'),
('Henry', 'Martin', 8, '8888888888', 'henrym@hospital.com'),
('Isabel', 'Thompson', 9, '9999999999', 'isabelt@hospital.com'),
('Jacob', 'Garcia', 10, '1010101010', 'jacobg@hospital.com');

INSERT INTO `Nurse` (`FirstName`, `LastName`, `ContactNumber`, `email`) VALUES
('Nora', 'Jones', '1231231234', 'noraj@hospital.com'),
('Oliver', 'King', '2342342345', 'oliverk@hospital.com'),
('Patricia', 'Lee', '3453453456', 'patricial@hospital.com'),
('Quinn', 'Walker', '4564564567', 'quinnw@hospital.com'),
('Ryan', 'Scott', '5675675678', 'ryans@hospital.com'),
('Sophia', 'Young', '6786786789', 'sophiay@hospital.com'),
('Tyler', 'Allen', '7897897890', 'tylera@hospital.com'),
('Ursula', 'Hill', '8908908901', 'ursulah@hospital.com'),
('Victor', 'Lopez', '9019019012', 'victorl@hospital.com'),
('Wendy', 'Hall', '0120120123', 'wendyh@hospital.com');

INSERT INTO `Appointment` (`PatientID`, `DoctorID`, `Date`) VALUES
(1, 1, '2023-11-15 10:00:00'),
(2, 2, '2023-11-16 11:00:00'),
(3, 3, '2023-11-17 09:30:00');

INSERT INTO `Admission` (`PatientID`, `NurseID`, `AdmissionStartDate`, `AdmissionEndDate`, `RoomNumber`) VALUES
(1, 1, '2023-11-01', '2023-11-10', 101),
(2, 2, '2023-11-02', '2023-11-12', 102),
(3, 3, '2023-11-03', '2023-11-13', 103);

INSERT INTO `Medication` (`PatientID`, `DoctorID`, `Name`, `Dosage`, `Frequency`, `StartDate`, `EndDate`, `OtherDescription`) VALUES
(1, 1, 'Medication A', '100mg', 'Twice a day', '2023-11-01', '2023-11-10', 'Take with food'),
(2, 2, 'Medication B', '200mg', 'Once a day', '2023-11-02', '2023-11-12', 'Take on empty stomach');




