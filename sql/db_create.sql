--
-- Δομή πίνακα για τον πίνακα `Admission`
--
CREATE TABLE
	`Admission` (
		`ID` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		`PatientID` INT(11) DEFAULT NULL,
		`DoctorID` INT(11) DEFAULT NULL,
		`NurseID` INT(11) DEFAULT NULL,
		`StartDate` DATE DEFAULT NULL,
		`EndDate` DATE DEFAULT NULL,
		`RoomNumber` INT(11) DEFAULT NULL,
		`Reason` VARCHAR(255) NOT NULL
	);

--
-- Δομή πίνακα για τον πίνακα `Appointment`
--
CREATE TABLE
	`Appointment` (
		`PatientID` INT(11) NOT NULL,
		`DoctorID` INT(11) NOT NULL,
		`Date` DATETIME NOT NULL
	);

ALTER TABLE `Appointment`
ADD PRIMARY KEY (`PatientID`, `DoctorID`, `Date`),
ADD KEY `DoctorID` (`DoctorID`);

--
-- Δομή πίνακα για τον πίνακα `Department`
--
CREATE TABLE
	`Department` (
		`ID` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		`Name` VARCHAR(255) DEFAULT NULL
	);

--
-- Δομή πίνακα για τον πίνακα `Employee`
--
CREATE TABLE
	`Employee` (
		`ID` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		`email` VARCHAR(255) DEFAULT NULL,
		`password` VARCHAR(255) DEFAULT NULL,
		`firstName` VARCHAR(255) DEFAULT NULL,
		`lastName` VARCHAR(255) DEFAULT NULL,
		`type` VARCHAR(255) DEFAULT NULL,
		`departmentID` INT(11) DEFAULT NULL,
		`contactNumber` VARCHAR(255) DEFAULT NULL
	);

--
-- Δομή πίνακα για τον πίνακα `Medication`
--
CREATE TABLE
	`Medication` (
		`ID` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		`PatientID` INT(11) DEFAULT NULL,
		`DoctorID` INT(11) DEFAULT NULL,
		`Name` VARCHAR(255) DEFAULT NULL,
		`Dosage` VARCHAR(255) DEFAULT NULL,
		`Frequency` TEXT DEFAULT NULL,
		`StartDate` DATE DEFAULT NULL,
		`EndDate` DATE DEFAULT NULL,
		`OtherDescription` TEXT DEFAULT NULL
	);

--
-- Δομή πίνακα για τον πίνακα `Patient`
--
CREATE TABLE
	`Patient` (
		`ID` INT(11) PRIMARY KEY NOT NULL,
		`FirstName` VARCHAR(255) DEFAULT NULL,
		`LastName` VARCHAR(255) DEFAULT NULL,
		`DateOfBirth` DATE DEFAULT NULL,
		`Gender` VARCHAR(255) DEFAULT NULL,
		`ContactNumber` VARCHAR(255) DEFAULT NULL,
		`EmailAddress` VARCHAR(255) DEFAULT NULL,
		`Address` VARCHAR(255) DEFAULT NULL
	);

--
-- Δομή πίνακα για τον πίνακα `Room`
--
CREATE TABLE
	`Room` (
		`RoomNumber` INT(11) PRIMARY KEY NOT NULL,
		`DepartmentID` INT(11) DEFAULT NULL
	);

ALTER TABLE `Admission`
ADD CONSTRAINT FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`ID`),
ADD CONSTRAINT FOREIGN KEY (`NurseID`) REFERENCES `Employee` (`ID`),
ADD CONSTRAINT FOREIGN KEY (`DoctorID`) REFERENCES `Employee` (`ID`),
ADD CONSTRAINT FOREIGN KEY (`RoomNumber`) REFERENCES `Room` (`RoomNumber`);

ALTER TABLE `Appointment`
ADD CONSTRAINT FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`ID`),
ADD CONSTRAINT FOREIGN KEY (`DoctorID`) REFERENCES `Employee` (`ID`);

ALTER TABLE `Employee`
ADD CONSTRAINT FOREIGN KEY (`departmentID`) REFERENCES `Department` (`ID`);

ALTER TABLE `Medication`
ADD CONSTRAINT FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`ID`),
ADD CONSTRAINT FOREIGN KEY (`DoctorID`) REFERENCES `Employee` (`ID`);

ALTER TABLE `Room`
ADD CONSTRAINT FOREIGN KEY (`DepartmentID`) REFERENCES `Department` (`ID`);