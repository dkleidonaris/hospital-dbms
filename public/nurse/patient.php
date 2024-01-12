<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/nurse.php");


$PAGE_TITLE = "Patient Tab";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar-nurse.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>
    <div class="flex flex-col gap-4 items-center">
        <div class="flex flex-row gap-2 justify-center items-center">
            <label for="insurance_id">Please enter the patient's insurance ID:</label>
            <input id="patient_input" type="text" class="p-2 rounded-md">
            <button id="patient_submit" class="relative p-2 bg-blue-500 rounded-md">Submit</button>
        </div>
        <div id="tab_div" class="w-full px-4 flex flex-row gap-2"></div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
    <script>
        function patientSearch() {
            $.ajax({
                url: "/api/patients.php",
                data: {
                    'insurance_id': $('#patient_input').val(),
                    'scope': 'nurse'
                },
                success: function(result) {
                    var data = JSON.parse(result);

                    $('#tab_div').html('');

                    if (data.results.patient) {
                        $('#tab_div').append('<div id="details_div" class="flex flex-col gap-4 bg-gray-200 p-4 rounded-md shadow-md"></div>');
                        $('#details_div').append('<p class="text-2xl font-bold">Patient Information</p>');
                        $('#details_div').append('<div class="sm:grid sm:grid-cols-3 sm:gap-2 items-center"><p class="font-bold">LastName: </p><p class="col-span-2">' + data.results.patient.LastName + '</p></div>');
                        $('#details_div').append('<div class="sm:grid sm:grid-cols-3 sm:gap-2 items-center"><p class="font-bold">First Name: </p><p class="col-span-2">' + data.results.patient.FirstName + '</p></div>');
                        $('#details_div').append('<div class="sm:grid sm:grid-cols-3 sm:gap-2 items-center"><p class="font-bold">Gender: </p><p class="col-span-2">' + data.results.patient.Gender + '</p></div>');

                        var d = new Date(data.results.patient.DateOfBirth);
                        const options = {
                            year: 'numeric',
                            month: 'numeric',
                            day: 'numeric'
                        };
                        $('#details_div').append('<div class="sm:grid sm:grid-cols-3 sm:gap-2 items-center"><p class="font-bold">Date of Birth: </p><p class="col-span-2">' + d.toLocaleDateString('en-US', options) + '</p></div>');

                        $('#details_div').append('<div class="sm:grid sm:grid-cols-3 sm:gap-2 items-center"><p class="font-bold">Contact Number: </p><a href="' + data.results.patient.ContactNumber + '" class="col-span-2 text-blue-600 hover:text-blue-700"><p class="col-span-2">' + data.results.patient.ContactNumber + '</p></a></div>');
                        $('#details_div').append('<div class="sm:grid sm:grid-cols-3 gap-2 items-center"><p class="font-bold">Email Address: </p><a href="mailto:' + data.results.patient.EmailAddress + '" class="col-span-2 text-blue-600 hover:text-blue-700"><p>' + data.results.patient.EmailAddress + '</p></a></div>');
                        $('#details_div').append('<div class="sm:grid sm:grid-cols-3 gap-2 items-center"><p class="font-bold">Address: </p><p>' + data.results.patient.Address + '</p></div>');

                        $('#tab_div').append('<div id="medication_div" class="grow flex flex-col gap-4 bg-gray-200 p-4 rounded-md shadow-md"></div>');
                        $('#medication_div').append('<p class="font-bold text-2xl">Medication History</p>');
                        data.results.medication.forEach(function(m, i) {
                            const options = {
                                day: 'numeric',
                                month: 'numeric',
                                year: 'numeric'
                            };
                            var startDate = new Date(m.StartDate);
                            var endDate = new Date(m.EndDate);

                            $('#medication_div').append('<div id="medication-' + (i + 1) + '" class="relative flex flex-col gap-2"><div id="medication-' + (i + 1) + '-details"></div></div>');
                            $('#medication-' + (i + 1) + '-details').append('<div id="medication-' + (i + 1) + '-name" class="flex gap-1"><p class="font-bold text-xl">' + m.Name + '</p></div>');
                            $('#medication-' + (i + 1) + '-details').append('<div class="ml-4 flex flex-row gap-2"><p class="font-bold">Dosage: </p><p>' + m.Dosage + '</p></div>');
                            $('#medication-' + (i + 1) + '-details').append('<div class="ml-4 flex flex-row gap-2"><p class="font-bold">Frequency: </p><p>' + m.Frequency + '</p></div>');
                            $('#medication-' + (i + 1) + '-details').append('<div class="ml-4 flex flex-row gap-2"><p class="font-bold">Prescribing Doctor: </p><p>' + m.DoctorLastName + '</p></div>');

                            $('#medication-' + (i + 1) + '-details').append('<div class="ml-4 flex flex-row gap-2"><p class="font-bold">Start Date: </p><p>' + startDate.toLocaleDateString('el-GR', options) + '</p></div>');
                            $('#medication-' + (i + 1) + '-details').append('<div class="ml-4 flex flex-row gap-2"><p class="font-bold">End Date: </p><p>' + endDate.toLocaleDateString('el-GR', options) + '</p></div>');
                            $('#medication-' + (i + 1) + '-details').append('<div class="ml-4 flex flex-row gap-2"><p class="font-bold">Notes: </p><p>' + m.OtherDescription + '</p></div>');


                            var currDate = new Date();
                            if (currDate >= endDate) {
                                $('#medication-' + (i + 1) + '-details').addClass('opacity-30');
                                $('#medication-' + (i + 1) + '-details').after('<span class="absolute top-1 left-36 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-red-400">Inactive</span>');
                            } else {
                                $('#medication-' + (i + 1) + '-details').after('<span class="absolute top-1 left-36 bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-green-400">Active</span>');

                            }


                        });

                        $('#tab_div').append('<div id="admissions_div" class="grow flex flex-col gap-4 bg-gray-200 p-4 rounded-md shadow-md"></div>');
                        $('#admissions_div').append('<p class="font-bold text-2xl">Admissions</p>');
                        data.results.admissions.forEach(function(a, i) {
                            const options = {
                                day: 'numeric',
                                month: 'numeric',
                                year: 'numeric'
                            };
                            var startDate = new Date(a.StartDate);
                            var currDate = new Date();
                            if (a.EndDate & currDate <= endDate) {
                                $('#admissions_div').append('<div id="admission-' + (i + 1) + '" class="p-2 relative flex flex-col gap-2 border-green-500 border-2"><div id="admission-' + (i + 1) + '-details"></div></div>');
                            } else {
                                $('#admissions_div').append('<div id="admission-' + (i + 1) + '" class="p-2 relative flex flex-col gap-2 border-gray-300 border-2"><div id="admission-' + (i + 1) + '-details"></div></div>');
                            }
                            $('#admission-' + (i + 1) + '-details').append('<div id="startdate_div" class="grid grid-cols-3"><p class="font-bold">Start Date:</p><p>' + startDate.toLocaleDateString('el-GR', options) + '</p></div>');
                            if (a.EndDate && currDate <= endDate) {
                                $('#startdate_div').append('<div class="flex"><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-green-400">Active</span></div>');
                            }
                            if(a.EndDate) {
                                var endDate = new Date(a.EndDate);
                                $('#admission-' + (i + 1) + '-details').append('<div class="grid grid-cols-3"><p class="font-bold">End Date:</p><p class="col-span-2">' + endDate.toLocaleDateString('el-GR', options) + '</p></div>');

                            } else {
                                $('#admission-' + (i + 1) + '-details').append('<div class="grid grid-cols-3"><p class="font-bold">End Date:</p><p class="col-span-2">-</p></div>');

                            }
                            $('#admission-' + (i + 1) + '-details').append('<div class="grid grid-cols-3"><p class="font-bold">Reason:</p><p class="col-span-2">' + a.Reason + '</p></div>');
                            $('#admission-' + (i + 1) + '-details').append('<div class="grid grid-cols-3"><p class="font-bold">Assigned Nurse:</p><p class="col-span-2">' + a.NurseLastName + '</p></div>');
                            $('#admission-' + (i + 1) + '-details').append('<div class="grid grid-cols-3"><p class="font-bold">Room:</p><p class="col-span-2">' + a.RoomNumber + '</p></div>');


                        });
                    } else {
                        alert('There is no patient with this insurance ID, please try again!');
                        $('#patient_input').val('');
                    }

                }
            });
        }

        $('#patient_submit').click(patientSearch);
        $(document).on("keypress", function(e) {
            if (e.which == 13) {
                patientSearch();
            }
        });

        $(document).ready(function() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            if (urlParams.get('insurance_id')) {
                $('#patient_input').val(urlParams.get('insurance_id'));
                patientSearch();
            }
        });
    </script>
</body>

</html>