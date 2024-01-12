<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Book an appointment";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datetime = date_format(date_create($_POST['appointment_date'] . ' ' . $_POST['appointment_time']), 'Y-m-d H:i:s');

    $stmt = $dbh->prepare('SELECT * FROM Appointment WHERE PatientID = ? AND DoctorID = ? AND Date = ?');
    $stmt->execute(array($_POST['patient_id'], $_POST['doctor_id'], $datetime));

    if ($stmt->rowCount() < 1) {

        $stmt = $dbh->prepare('INSERT INTO Appointment (PatientID, DoctorID, Date) VALUES (?, ?, ?)');
        $stmt->execute(array($_POST['patient_id'], $_POST['doctor_id'], $datetime));
        echo "<script>alert('Your appointment has been created!')</script>";
        $_POST = array();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>

    <div id="patient_div" class="flex flex-row gap-2 justify-center items-center my-4">
        <p>Have you visited our hospital again?</p>
        <div class="flex flex-row gap-2 items-center">
            <div class="p-2 rounded-md">
                <label for="yes">Yes</label>
                <input id="previous_patient_yes" name="previous_patient" type="radio" value="yes">
            </div>
            <div class="p-2 rounded-md">
                <label for="no">No</label>
                <input id="previous_patient_no" name="previous_patient" type="radio" value="no">
            </div>
        </div>
    </div>



    <form id="appointment_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div id="form_div" class="flex flex-col gap-4 justify-center items-center">
            <input id="patient_input" name="patient_id" type="text" class="hidden">
            <select name="department_id" id="department_input" class="my-2 p-2 rounded-md hidden"></select>
            <select name="doctor_id" id="doctor_input" class="my-2 p-2 rounded-md hidden"></select>
            <input name="appointment_date" id="date_input" type="date" class="p-2 rounded-md hidden">
            <table id="timetable" class="hidden">
                <thead>
                    <tr>
                        <th scope="col" class="p-2">Time</th>
                        <th scope="col" class="p-2">Select</th>
                    </tr>
                </thead>
                <tbody id="timetable_body">
                </tbody>
            </table>
            <input id="form_submit" value="Submit" type="submit" class="hidden p-4 rounded-md bg-gray-300">
        </div>
    </form>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
    <script>
        var appointment_times = <?php echo json_encode(APPOINTMENT_TIMES); ?>;

        function loadDepartments() {
            $.ajax({
                url: "/api/departments.php",
                data: {},
                success: function(result) {
                    if (true) {
                        var data = JSON.parse(result);
                        var select = document.getElementById('department_input');

                        // Clear existing options
                        select.innerHTML = '';

                        // Add placeholder option
                        var option = document.createElement('option');
                        option.value = 'default';
                        option.textContent = 'Select a department';
                        select.appendChild(option);

                        // Add new options
                        data.results.forEach(function(item) {
                            var option = document.createElement('option');
                            option.value = item.ID;
                            option.textContent = item.Name;
                            select.appendChild(option);
                        });
                    }
                }
            });
        }


        function departmentChange() {
            $('#timetable').addClass('hidden');
            var xhr = new XMLHttpRequest();
            var d = document.getElementById('department_input');
            xhr.open('GET', '/api/doctors.php?department_id=' + d.options[d.selectedIndex].value, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);

                    select = $('#doctor_input')[0];
                    // Clear existing options
                    select.innerHTML = '';

                    // Add placeholder option
                    var option = document.createElement('option');
                    option.value = 'default';
                    option.textContent = 'Select a doctor';
                    select.appendChild(option);

                    // Add new options
                    data.results.forEach(function(item) {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.LastName + ' ' + item.FirstName;
                        select.appendChild(option);
                    });
                    select.addEventListener('change', doctorChange);
                }
            };
            xhr.send();
            $('#doctor_input').removeClass('hidden');
            var date = document.getElementById('date_input');
            if (date) {
                date.value = '';
            }
        }

        function doctorChange() {
            $('#timetable').addClass('hidden');
            var date = document.getElementById('date_input');
            $('#date_input').removeClass('hidden');
            $('#date_input').change(dateChange);

            $('#date_input').val('');
        }

        function dateChange() {
            var doctor = document.getElementById('doctor_input');
            var date = document.getElementById('date_input');
            $.ajax({
                url: "/api/appointments.php",
                data: {
                    'scope': 'patient',
                    'doctor_id': doctor.options[doctor.selectedIndex].value,
                    'appointment_date': date.value
                },
                success: function(result) {
                    var data = JSON.parse(result);

                    var unavail_appointments = [];
                    data.results.forEach(function(item) {
                        unavail_appointments.push(item.Date);
                    });
                    var table = document.getElementById('timetable');
                    var body = document.getElementById('timetable_body');

                    // Clear existing options
                    body.innerHTML = '';

                    // Add new options
                    appointment_times.forEach(function(item) {
                        var row = document.createElement('tr');
                        body.appendChild(row);
                        var left_cell = document.createElement('th');
                        left_cell.classList.add('p-2');
                        left_cell.innerText = item;
                        row.appendChild(left_cell);
                        var right_cell = document.createElement('td');
                        right_cell.classList.add('text-center');
                        right_cell.classList.add('p-2');
                        row.appendChild(right_cell);
                        var input = document.createElement('input');
                        input.classList.add('mx-auto');
                        input.type = 'radio';
                        input.name = "appointment_time";
                        input.value = item;
                        if (unavail_appointments.includes(item)) {
                            input.setAttribute('disabled', '');
                            row.classList.add('opacity-20', 'bg-gray-400');
                        }
                        right_cell.appendChild(input);
                    });

                    $('input[type=radio][name=appointment_time]').change(function() {
                        $('#form_submit').removeClass('hidden');
                        this.parentElement.parentElement.classList.add('bg-blue-500');
                        $('input[type=radio][name=appointment_time]').each(function() {
                            if (!this.checked) {
                                this.parentElement.parentElement.classList.remove('bg-blue-500');
                            }
                        });
                    });
                    table.classList.remove('hidden');
                }
            });
        }

        $('#previous_patient_yes').change(function() {
            $('#patient_details').remove();
            if (!($('#insurance_div').length)) {
                var div = document.createElement('div');
                div.id = 'insurance_div';
                $('#patient_div').after(div);
                $('#insurance_div').addClass("flex flex-row gap-2 justify-center items-center my-4");
                var label = document.createElement('label');
                label.id = 'insurance_label';
                label.append('Please enter your Insurance ID:');
                $('#insurance_div').append(label);
                var input = document.createElement('input');
                input.type = 'text';
                input.id = "insurance_input";
                $('#insurance_label').after(input);
                $('#insurance_input').addClass("p-2 rounded-md");
                var button = document.createElement('button');
                button.id = 'insurance_button';
                $('#insurance_input').after(button);
                $('#insurance_button').html('Search').addClass('p-2 bg-blue-400 rounded-md');

                $('#insurance_button').on('click', function() {
                    $.ajax({
                        url: "/api/patients.php",
                        data: {
                            'insurance_id': $('#insurance_input').val(),
                            'scope': 'appointment'
                        },
                        success: function(result) {
                            var data = JSON.parse(result);
                            if (data.results.length) {
                                setPatient(data.results[0].ID, data.results[0].LastName, data.results[0].FirstName);
                            } else {
                                alert('This insurance ID doesn\'t correspond to a patient. Try again.');
                                $('#insurance_input').val('');
                            }
                        }
                    });
                });

            }
        });

        $('#previous_patient_no').change(function() {
            $('#insurance_div').remove();
            $('#patient_div').after('<div id="patient_details" class="flex flex-col items-center gap-4"></div>');
            $('#patient_details').prepend('<p class="font-bold text-xl">Patient Details</p>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="insurance_number">Insurance Number</label><input type="text" id="insuranceid_input" name="insurance_number" class="p-2 rounded-md"></div>');
            $('#patient_details').append('<p id="insurance_error" class="hidden font-bold text-red-500">Please enter a number consisting of 5 digits</p>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="last_name">Last Name</label><input type="text" id="lastname_input" name="last_name" class="p-2 rounded-md"></div>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="first_name">First Name</label><input type="text" id="firstname_input" name="last_name" class="p-2 rounded-md"></div>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="date_of_birth">Date of Birth</label><input type="date" id="dateofbirth_input" name="date_of_birth" class="p-2 rounded-md"></div>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="Gender">Gender</label><select id="gender_input" name="gender" class="p-2 rounded-md"></select></div>');
            $('select[name=gender]').append('<option value="male" selected>Male</option><option value="female">Female</option>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="contact_number">Contact Number</label><input type="text" id="contactnumber_input" name="contact_number" class="p-2 rounded-md"></div>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="email_address">Email Address</label><input type="text" id="emailaddress_input" name="email_address" class="p-2 rounded-md"></div>');
            $('#patient_details').append('<div class="flex flex-row gap-2 items-center"><label for="address">Address</label><input type="text" id="address_input" name="address" class="p-2 rounded-md"></div>');
            $('#patient_details').append('<button id="patient_register" class="p-2 rounded-md bg-blue-500">Register</button>');


            function patientRegister() {
                if (!$('#insuranceid_input').val() || !$('#firstname_input').val() || !$('#lastname_input').val() || !$('#dateofbirth_input').val() || !$('#gender_input').val() || !$('#contactnumber_input').val() || !$('#emailaddress_input').val() || !$('#address_input').val()) {
                    alert('Please fill all the fields!');
                } else {
                    $.post('/api/patients.php', {
                        insurance_number: $('#insuranceid_input').val(),
                        first_name: $('#firstname_input').val(),
                        last_name: $('#lastname_input').val(),
                        date_of_birth: $('#dateofbirth_input').val(),
                        gender: $('#gender_input').val(),
                        contact_number: $('#contactnumber_input').val(),
                        email_address: $('#emailaddress_input').val(),
                        address: $('#address_input').val(),
                    }).done(function(response) {
                        var data = JSON.parse(response);
                        setPatient(data.results[0].ID, data.results[0].LastName, data.results[0].FirstName);
                        $('#patient_details').remove();
                    });
                }
            }
            $('#patient_register').click(patientRegister);

            $('#insuranceid_input').on('input', function() {
                regex = new RegExp("^[0-9]{5}$");

                if (regex.test($('#insuranceid_input').val())) {
                    $('#insurance_error').addClass('hidden');
                    $('#patient_register').click(patientRegister);
                } else {
                    $('#insurance_error').removeClass('hidden');
                    $('#patient_register').unbind("click");
                }

            });


        });

        function setPatient(insuranceId, lastName, firstName) {
            $('#patient_input').val(insuranceId);
            $('#insurance_div').remove();
            $('#patient_div').empty().append('<p>Hi</p>');
            $('#patient_div').append('<p class="font-bold">' + lastName + ' ' + firstName + '</p>');
            $('#department_input').removeClass('hidden');
            loadDepartments();
            $('#department_input').change(departmentChange);
        }


        // Load data when the document is ready
        $(document).ready(function() {
            var today = new Date().toISOString().split('T')[0];
            $('#date_input').attr('min', today);

            $(document).on("keypress", function(e) {
                if (e.which == 13) {
                    $('#insurance_button').click();
                }
            });
        });
    </script>
</body>

</html>