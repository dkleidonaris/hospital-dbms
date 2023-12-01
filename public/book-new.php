<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Book an appointment";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);
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
                <input name="previous_patient_input" type="radio" value="yes">
            </div>
            <div class="p-2 rounded-md">
                <label for="no">No</label>
                <input name="previous_patient_input" type="radio" value="no">
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
            <input id="form_submit" value="Submit" type="submit" class="p-4 rounded-md bg-gray-300">
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
                    console.log(result);
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
                            option.value = item.Id;
                            option.textContent = item.Name;
                            select.appendChild(option);
                        });
                    }
                }
            });
            // var xhr = new XMLHttpRequest();
            // xhr.open('GET', '/api/departments.php', true);
            // xhr.onload = function() {
            //     if (this.status == 200) {
            //         var data = JSON.parse(this.responseText);
            //         var select = document.getElementById('department_input');

            //         // Clear existing options
            //         select.innerHTML = '';

            //         // Add placeholder option
            //         var option = document.createElement('option');
            //         option.value = 'default';
            //         option.textContent = 'Select a department';
            //         select.appendChild(option);

            //         // Add new options
            //         data.results.forEach(function(item) {
            //             var option = document.createElement('option');
            //             option.value = item.Id;
            //             option.textContent = item.Name;
            //             select.appendChild(option);
            //         });
            //     }
            // };
            // xhr.send();
        }


        function departmentChange() {
            $('#timetable').addClass('hidden');
            var xhr = new XMLHttpRequest();
            var d = document.getElementById('department_input');
            xhr.open('GET', '/api/doctors.php?department_id=' + d.options[d.selectedIndex].value, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    console.log(this.responseText);
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

                $('#date_input').val() = '';
        }

        function dateChange() {
            var xhr = new XMLHttpRequest();
            var doctor = document.getElementById('doctor_input');
            var date = document.getElementById('date_input');
            xhr.open('GET', '/api/appointments.php?doctor_id=' + doctor.options[doctor.selectedIndex].value + '&appointment_date=' + date.value, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);

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
                        this.parentElement.parentElement.classList.add('bg-blue-500');
                        $('input[type=radio][name=appointment_time]').each(function() {
                            if (!this.checked) {
                                this.parentElement.parentElement.classList.remove('bg-blue-500');
                            }
                        });
                    });
                    table.classList.remove('hidden');
                }
            };
            xhr.send();
        }

        $('input[type=radio][name=previous_patient_input]').change(function() {
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

                $('#insurance_button').click(function() {
                    $.ajax({
                        url: "/api/patient.php",
                        data: {
                            'insurance_id': $('#insurance_input').val(),
                            'scope': 'appointment'
                        },
                        success: function(result) {
                            var data = JSON.parse(result);
                            if (data.results.length) {
                                $('#insurance_div').remove();

                                $('#patient_div').empty().append('<p>Hi</p>');
                                $('#patient_div').append('<p class="font-bold">' + data.results[0].LastName + ' ' + data.results[0].FirstName + '</p>');

                                $('#department_input').removeClass('hidden');
                                loadDepartments();
                                $('#department_input').change(departmentChange);
                            }
                        }
                    });
                });
            }
        });


        // Load data when the document is ready
        $(document).ready(function() {

        });
    </script>
</body>

</html>