CREATE TABLE `Department` (
  `DepartmentID` integer PRIMARY KEY AUTO_INCREMENT,
  `DepartnameName` varchar(255)
);

CREATE TABLE `Patient` (
  `PatientID` integer PRIMARY KEY,
  `FirstName` varchar(255),
  `LastName` varchar(255),
  `DateOfBirth` date,
  `Gender` varchar(255),
  `ContactNumber` integer,
  `EmailAddress` varchar(255),
  `Address` varchar(255)
);

CREATE TABLE `Doctor` (
  `DoctorID` integer PRIMARY KEY AUTO_INCREMENT,
  `FirstName` varchar(255),
  `LastName` varchar(255),
  `DepartmentID` integer,
  `ContactNumber` integer,
  `email` varchar(255)
);

CREATE TABLE `Nurse` (
  `NurseID` integer PRIMARY KEY AUTO_INCREMENT,
  `FirstName` varchar(255),
  `LastName` varchar(255),
  `ContactNumber` integer,
  `email` varchar(255)
);

CREATE TABLE `Appointment` (
  `AppointmentID` integer PRIMARY KEY,
  `PatientID` integer,
  `DoctorID` integer,
  `AppointmentDate` datetime
);

CREATE TABLE `Admission` (
  `AdmissionID` integer PRIMARY KEY,
  `PatientID` integer,
  `NurseID` integer,
  `AdmissionStartDate` date,
  `AdmissionEndDate` date,
  `RoomNumber` integer
);

CREATE TABLE `Medication` (
  `MedicationID` integer PRIMARY KEY AUTO_INCREMENT,
  `PatientID` integer,
  `DoctorID` integer,
  `MedicationName` varchar(255),
  `Dosage` varchar(255),
  `Frequency` text,
  `StartDate` date,
  `EndDate` date,
  `OtherDescription` text
);

CREATE TABLE `Room` (
  `RoomNumber` integer PRIMARY KEY AUTO_INCREMENT,
  `DepartmentID` integer
);

ALTER TABLE `Doctor` ADD FOREIGN KEY (`DepartmentID`) REFERENCES `Department` (`DepartmentID`);

ALTER TABLE `Appointment` ADD FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`);

ALTER TABLE `Appointment` ADD FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`);

ALTER TABLE `Admission` ADD FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`);

ALTER TABLE `Admission` ADD FOREIGN KEY (`NurseID`) REFERENCES `Nurse` (`NurseID`);

ALTER TABLE `Admission` ADD FOREIGN KEY (`RoomNumber`) REFERENCES `Room` (`RoomNumber`);

ALTER TABLE `Medication` ADD FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`);

ALTER TABLE `Medication` ADD FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`);

ALTER TABLE `Room` ADD FOREIGN KEY (`DepartmentID`) REFERENCES `Department` (`DepartmentID`);
