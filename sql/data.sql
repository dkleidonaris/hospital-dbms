INSERT INTO departments (name) VALUES('Pediatric');
INSERT INTO departments (name) VALUES('Opthalmologic');
INSERT INTO departments (name) VALUES('Pathologic');

INSERT INTO rooms (room_number, department_id, is_empty) VALUES(304, 1, 1);
INSERT INTO rooms (room_number, department_id, is_empty) VALUES(202, 2, 1);
INSERT INTO rooms (room_number, department_id, is_empty) VALUES(105, 3, 1);

INSERT INTO doctors (name, department_id) VALUES('John Locke', 1);
INSERT INTO doctors (name, department_id) VALUES('Mariah Carey', 2);
INSERT INTO doctors (name, department_id) VALUES('Jim Murray', 2);

INSERT INTO nurses (name) VALUES('Maria');
INSERT INTO nurses (name) VALUES('John');
INSERT INTO nurses (name) VALUES('Aggelos');

INSERT INTO patients (name, insurance_id) VALUES('Aggelos', 0001);
INSERT INTO patients (name, insurance_id) VALUES('George', 0090);
INSERT INTO patients (name, insurance_id) VALUES('Jim', 0002);

INSERT INTO stays (patient_id, nurse_id, start_date, end_date, diagnose_name, room_id) VALUES(1, 1, '2023-11-10', '2023-11-15', 'Fever', 304);
INSERT INTO stays (patient_id, nurse_id, start_date, end_date, diagnose_name, room_id) VALUES(2, 2, '2023-10-09', '2023-10-13', 'COVID-19', 202);

INSERT INTO medicine (barcode, name, description, stock) VALUES(12456, 'Depon', 'For fever', 20);
INSERT INTO medicine (barcode, name, description, stock) VALUES(5658758, 'Algofren', 'For pain', 30);

INSERT INTO prescriptions(date) VALUES('2023-11-20');
INSERT INTO prescriptions(date) VALUES('2023-4-10');

INSERT INTO medicine_prescription (prescription_id, medicine_name, instructions, quantity) VALUES(1, 'Depon', '',2);
INSERT INTO medicine_prescription (prescription_id, medicine_name, instructions, quantity) VALUES(2, 'Algofren', '', 3);


INSERT INTO appointments (date, patient_id, doctor_id, prescription_id, diagnose_name) VALUES('2023-10-03', 1, 1, 1, 'Fever2');
INSERT INTO appointments (date, patient_id, doctor_id, prescription_id, diagnose_name) VALUES('2023-11-02', 2, 2, 2, 'Corona');





