<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Book an appointment";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>

    <form id="appointment_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="<?php echo $method; ?>">
        <div class="flex flex-col gap-4 justify-center items-center">
            <select name="department_id" id="department_input" class="my-4 p-2 rounded-md"></select>
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
            <input value="Next" type="submit" class="p-4 rounded-md bg-gray-300">
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
            var xhr = new XMLHttpRequest();
            var d = document.getElementById('department_input');
            xhr.open('GET', '/api/doctors.php?department_id=' + d.options[d.selectedIndex].value, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    console.log(this.responseText);
                    var data = JSON.parse(this.responseText);
                    if (!document.getElementById('doctor_input')) {
                        var select = document.createElement('select');
                        select.classList.add('p-2', 'rounded-md');
                        select.id = 'doctor_input';
                        document.getElementById('department_input').after(select);
                    } else {
                        var select = document.getElementById('doctor_input');
                    }
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
            var date = document.getElementById('date_input');
            if (date) {
                date.value = '';
            }
        }

        function doctorChange() {
            var date = document.getElementById('date_input');
            if (!date) {
                var input = document.createElement('input');
                input.id = 'date_input';
                input.type = 'date';
                input.classList.add('my-2', 'p-2', 'rounded-md');
                document.getElementById('doctor_input').after(input);
                document.getElementById('date_input').addEventListener('change', dateChange);
            } else {
                date.value = '';
            }
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


        // Load data when the document is ready
        $(document).ready(function() {
            loadDepartments();
        });
        document.getElementById('department_input').addEventListener('change', departmentChange);
    </script>
</body>

</html>