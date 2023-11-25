<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");

$PAGE_TITLE = "Book an appointment";

$stmt = $dbh->prepare('SELECT DepartmentID, DepartmentName FROM Department');
$stmt->execute();
$departments = $stmt->fetchAll();

$department_html = <<< html
    <div class="my-4 flex gap-2 items-center">
            <p class="font-bold text-xl">Department:</p>
            <select name="department_id" class="p-2 rounded-md">
                <option>Select a department...</option>            
    html;

foreach ($departments as $department) {
    $department_html .= "<option " . ((isset($_GET['department_id']) && $_GET['department_id'] == $department['DepartmentID']) ? "selected" : "") . " value=\"" . $department['DepartmentID'] . "\">" . $department['DepartmentName'] . "</option>";
}

$department_html .= "</select>
    </div>";

if (isset($_GET['department_id'])) {
    $stmt = $dbh->prepare('SELECT Doctor.DoctorID, Doctor.FirstName, Doctor.LastName FROM Doctor INNER JOIN Department ON Doctor.DepartmentID=Department.DepartmentID WHERE Doctor.DepartmentID=:id');
    $stmt->execute([':id' =>$_GET['department_id']]);
    $doctors = $stmt->fetchAll();

    $doctor_html = <<<html
    <div class="my-4 flex gap-2 items-center">
        <p class="font-bold text-xl">Doctor:</p>
        <select name="doctor_id" class="p-2 rounded-md">
                <option>Select a doctor...</option> 
    html;

    foreach ($doctors as $doctor) {
        $doctor_html .= "<option " . (isset($_GET['doctor_id']) && $_GET['doctor_id'] == $doctor['DoctorID'] ? "selected" : "") . " value=\"" . $doctor['DoctorID'] . "\">" . $doctor['LastName'] . " " . $doctor['FirstName'] . "</option>";
    }

    $doctor_html .= "</select>
        </div>";
}

if (isset($_GET['department_id'], $_GET['doctor_id'])) {
    $stmt = $dbh->prepare('SELECT Doctor.DoctorID, Doctor.FirstName, Doctor.LastName FROM Doctor INNER JOIN Department ON Doctor.DepartmentID=Department.DepartmentID WHERE Doctor.DepartmentID=:id');
    $stmt->execute([':id' =>$_GET['department_id']]);
    $doctors = $stmt->fetchAll();

    $date_html = <<<html
    <div class="my-4 flex gap-2 items-center">
        <p class="font-bold text-xl">Date:</p>
        <input 
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
    $stmt = $dbh->prepare('SELECT Appointment.Date FROM Appointment INNER JOIN Doctor ON Appointment.DoctorID=Doctor.DoctorID WHERE CAST(Appointment.Date AS DATE)=:date');
    $stmt->execute([':date' => $_GET['date']]);
    $unavail_appointments = $stmt->fetchAll();

    $time_html = "";

    foreach($unavail_appointments as $unavail_appointment) {
    $time_html .= "<p>" . $unavail_appointment['Date'] . "</p>";
    }
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

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="flex flex-col gap-4 justify-center items-center">
            <?php echo $department_html; ?>
            <?php if (isset($doctor_html)) echo $doctor_html; ?>
            <?php if (isset($date_html)) echo $date_html; ?>
            <?php if (isset($time_html)) echo $time_html; ?>

            <input value="Next" type="submit" class="p-4 rounded-md bg-gray-300">
        </div>
    </form>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
</body>

</html>