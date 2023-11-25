<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Book an appointment";

$method = "get";

// if(isset($_GET['department_id'], $_GET['doctor_id'], $_GET['date'])) {
//     $method = 'post';
// } else {
//     $method = 'get';
// }

$stmt = $dbh->prepare('SELECT ID, Name FROM Department');
$stmt->execute();
$departments = $stmt->fetchAll();

$department_html = <<< html
    <div class="my-4 flex gap-2 items-center">
            <p class="font-bold text-xl">Department:</p>
            <select id="department_id" name="department_id" class="p-2 rounded-md">
                <option>Select a department...</option>            
    html;

foreach ($departments as $department) {
    $department_html .= "<option " . ((isset($_GET['department_id']) && $_GET['department_id'] == $department['ID']) ? "selected" : "") . " value=\"" . $department['ID'] . "\">" . $department['Name'] . "</option>";
}

$department_html .= "</select>
    </div>";

if (isset($_GET['department_id'])) {
    $stmt = $dbh->prepare('SELECT Doctor.ID, Doctor.FirstName, Doctor.LastName FROM Doctor INNER JOIN Department ON Doctor.ID=Department.ID WHERE Doctor.ID=:id');
    $stmt->execute([':id' => $_GET['department_id']]);
    $doctors = $stmt->fetchAll();

    $doctor_html = <<<html
    <div id="doctor_div" class="my-4 flex gap-2 items-center">
        <p class="font-bold text-xl">Doctor:</p>
        <select id="doctor_id" name="doctor_id" class="p-2 rounded-md">
                <option value="default">Select a doctor...</option> 
    html;

    foreach ($doctors as $doctor) {
        $doctor_html .= "<option " . (isset($_GET['doctor_id']) && $_GET['doctor_id'] == $doctor['ID'] ? "selected" : "") . " value=\"" . $doctor['ID'] . "\">" . $doctor['LastName'] . " " . $doctor['FirstName'] . "</option>";
    }

    $doctor_html .= "</select>
        </div>";
}

if (isset($_GET['department_id'], $_GET['doctor_id'])) {
    $stmt = $dbh->prepare('SELECT Doctor.ID, Doctor.FirstName, Doctor.LastName FROM Doctor INNER JOIN Department ON Doctor.DepartmentID=Department.ID WHERE Doctor.DepartmentID=:id');
    $stmt->execute([':id' => $_GET['department_id']]);
    $doctors = $stmt->fetchAll();

    $date_html = <<<html
    <div id="date_div" class="my-4 flex gap-2 items-center">
        <p class="font-bold text-xl">Date:</p>
        <input id="date"
    html;

    if (!empty($_GET['date'])) {
        $date_html .= "value=\"" . $_GET['date'] . "\"";
    }

    $date_html .= <<<html
    type="date" name="date" />
    </div>
    html;
}

if (isset($_GET['department_id'], $_GET['doctor_id'], $_GET['date'])) {
    $stmt = $dbh->prepare('SELECT Appointment.Date FROM Appointment INNER JOIN Doctor ON Appointment.DoctorID=Doctor.ID WHERE CAST(Appointment.Date AS DATE)=:date');
    $stmt->execute([':date' => $_GET['date']]);
    $results = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $unavail_appointments = [];

    foreach ($results as $result) {
        array_push($unavail_appointments, date_format(date_create($result), "H:i"));
    }

    print_r($unavail_appointments);

    $displayed_date = date('l', strtotime($_GET['date'])) . " " . date_format(date_create($_GET['date']), "d/m/Y");

    $time_html = <<<html
    <div id="table_div" class="my-4 flex gap-2 items-center">
        <p class="font-bold text-xl">Time:</p>
        <table class="border-separate border-spacing-y-2">
            <tr>
                <th>
                    Time
                </th>
                <th>
                    Select
                </th>
            </tr>
    html;

    foreach (APPOINTMENT_TIMES as $appointment_time) {
        if (in_array($appointment_time, $unavail_appointments)) {
            $table_class = "opacity-20 bg-gray-300";
            $radio_class = "disabled";
        } else {
            $table_class = "";
            $radio_class = "";
        }
        $time_html .= <<<html
        <tr class="{$table_class}">
            <td class="p-2 text-center">
                {$appointment_time}
            </td>
            <td>
            <div class="flex justify-center">
                    <input id="time" {$radio_class} name="time" type="radio" value="{$appointment_time}"/>
                </div>
            </td>
        </tr>
        html;
        // $time_html .= "<p>" . $unavail_appointment['Date'] . "</p>";
    }

    $time_html .= <<<html
        </table>
    </div>
    html;
}

// if (isset($_GET['department_id'], $_GET['doctor_id'], $GET_['appointment_date'], $_GET['appointment_time'], $_GET['insurance_number'])) {
//     $stmt = $dbh->prepare('SELECT name FROM departments WHERE id = :id');
//     $stmt->execute([':id' => $_GET['department_id']]);
//     $test = $stmt->fetchAll();
// } elseif (isset($_GET['department_id'])) {
//     $stmt = $dbh->prepare('SELECT name FROM departments WHERE id = :id');
//     $stmt->execute([':id' => $_GET['department_id']]);
//     $department = $stmt->fetch();
//     if (!$department) {
//         $html = <<<HTML
//         <p class="my-4 text-center font-bold text-xl">There is no department with this id!</p>
//         HTML;
//     } else {
//         $html = <<<HTML
//         <p>Selected</p>
//         HTML;
//     }
// }

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
            <?php echo $department_html; ?>
            <?php if (isset($doctor_html)) echo $doctor_html; ?>
            <?php if (isset($date_html)) echo $date_html; ?>
            <?php if (isset($time_html)) echo $time_html; ?>

            <input value="Next" type="submit" class="p-4 rounded-md bg-gray-300">
        </div>
    </form>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
    <script>
        window.onload = function() {
            var triggerField = document.getElementById("department_id");
            var resetFields = ["doctor_id", "date", "time"];

            document.getElementById("department_id").addEventListener('change', function() {
                document.getElementById('doctor_id').value = 'default';
                document.getElementById('date').value = '';
                document.getElementById("doctor_div").classList.add("hidden");
                document.getElementById("date_div").classList.add("hidden");
                document.getElementById("table_div").classList.add("hidden");
            });
            document.getElementById("doctor_id").addEventListener('change', function() {
                document.getElementById('date').value = '';

                document.getElementById("table_div").classList.add("hidden");
            });
        };
    </script>
</body>

</html>