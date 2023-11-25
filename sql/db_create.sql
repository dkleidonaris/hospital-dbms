CREATE TABLE `Department` (
  `ID` integer PRIMARY KEY AUTO_INCREMENT,
  `Name` varchar(255)
);

CREATE TABLE `Patient` (
  `ID` integer PRIMARY KEY,
  `FirstName` varchar(255),
  `LastName` varchar(255),
  `DateOfBirth` date,
  `Gender` varchar(255),
  `ContactNumber` varchar(255),
  `EmailAddress` varchar(255),
  `Address` varchar(255)
);

CREATE TABLE `Doctor` (
  `ID` integer PRIMARY KEY AUTO_INCREMENT,
  `FirstName` varchar(255),
  `LastName` varchar(255),
  `DepartmentID` integer,
  `ContactNumber` varchar(255),
  `email` varchar(255)
);

CREATE TABLE `Nurse` (
  `ID` integer PRIMARY KEY AUTO_INCREMENT,
  `FirstName` varchar(255),
  `LastName` varchar(255),
  `ContactNumber` varchar(255),
  `email` varchar(255)
);

CREATE TABLE `Appointment` (
  `PatientID` integer,
  `DoctorID` integer,
  `Date` datetime,

  PRIMARY KEY (PatientID, DoctorID, Date)
);

CREATE TABLE `Admission` (
  `ID` integer PRIMARY KEY AUTO_INCREMENT,
  `PatientID` integer,
  `NurseID` integer,
  `AdmissionStartDate` date,
  `AdmissionEndDate` date,
  `RoomNumber` integer
);

CREATE TABLE `Medication` (
  `ID` integer PRIMARY KEY AUTO_INCREMENT,
  `PatientID` integer,
  `DoctorID` integer,
  `Name` varchar(255),
  `Dosage` varchar(255),
  `Frequency` text,
  `StartDate` date,
  `EndDate` date,
  `OtherDescription` text
);

CREATE TABLE `Room` (
  `RoomNumber` integer PRIMARY KEY,
  `DepartmentID` integer
);

ALTER TABLE `Doctor` ADD FOREIGN KEY (`DepartmentID`) REFERENCES `Department` (`ID`);

ALTER TABLE `Appointment` ADD FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`ID`);

ALTER TABLE `Appointment` ADD FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`ID`);

ALTER TABLE `Admission` ADD FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`ID`);

ALTER TABLE `Admission` ADD FOREIGN KEY (`NurseID`) REFERENCES `Nurse` (`ID`);

ALTER TABLE `Admission` ADD FOREIGN KEY (`RoomNumber`) REFERENCES `Room` (`RoomNumber`);

ALTER TABLE `Medication` ADD FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`ID`);

ALTER TABLE `Medication` ADD FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`ID`);

ALTER TABLE `Room` ADD FOREIGN KEY (`DepartmentID`) REFERENCES `Department` (`ID`);
