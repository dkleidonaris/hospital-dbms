<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Admissions";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar-secretary.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>

    <div class="my-4 max-w-md flex gap-2 items-center mx-auto">
        <input id="search" placeholder="Enter the insurance number of the patient" type="text" class="w-full rounded-md p-2">
    </div>

    <div class="px-4 my-8">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="insurance_number" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Patient Insurance Number</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="insurance_number" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Patient Name</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="doctor_last_name" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Doctor in charge</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="nurse_last_name" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Nurse in charge</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="start_date" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Admission Date</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="end_date" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Discharge</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="room_number" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Room Number</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div id="reason" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Reason</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <span class="sr-only">Delete</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
        </div>

    </div>


    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
    <script src="/assets/js/admission.js"></script>
    <script>
        showAdmissions();

        $('#search').on('input', showAdmissions);
        // $('#search').on('keypress', (event) => {
        //     if (event.keyCode == 13) {
        //         showAdmissions();
        //     }
        // });

        function showAdmissions() {
            var data = {
                order_by: 'AdmissionID',
                order_direction: 'ASC'
            };
            if ($('#search').val()) {
                data.insurance_id = $('#search').val();
            }
            $.ajax({
                url: '/api/admissions.php',
                data: data,
                success: function(response) {
                    data = JSON.parse(response);

                    $('#tbody').html('');

                    if (data.results.length) {
                        data.results.forEach(function(item, i) {
                            const options = {
                                year: 'numeric',
                                month: 'numeric',
                                day: 'numeric',
                            };
                            var admissionDate = new Date(item.StartDate);
                            var dischargeDate = new Date(item.EndDate);

                            $('#tbody').append('<tr row-num="' + i + '" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"></tr>');
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4">' + item.InsuranceNumber + '</th>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.PatientLastName + ' ' + item.PatientFirstName + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.DoctorLastName + ' ' + item.DoctorFirstName + '</td>');
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4">' + item.NurseLastName + '</th>');
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4">' + admissionDate.toLocaleDateString('el-GR', options) + '</th>');
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4">' + dischargeDate.toLocaleDateString('el-GR', options) + '</th>');
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4">' + item.RoomNumber + '</th>');
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4">' + item.Reason + '</th>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4 text-right"><a href="/secretary/admissions/edit.php?id=' + item.AdmissionID + '" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a></td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4 text-right"><svg onclick="deleteAction(' + item.AdmissionID + ')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 fill-red-500 cursor-pointer"><g><path fill="none" d="M0 0h24v24H0z" /><path d="M7 4V2h10v2h5v2h-2v15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6H2V4h5zM6 6v14h12V6H6zm3 3h2v8H9V9zm4 0h2v8h-2V9z" /></g></svg></td>');
                        });
                    } else {
                        $('#tbody').append('<p class="py-4 mx-auto font-bold text-2xl">No results found!</p>');
                    }
                }
            });
        }

        function deleteAction(id) {
            deleteAdmission(id);
            showAdmissions();
        }
    </script>
</body>

</html>