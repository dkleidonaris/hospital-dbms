<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/nurse.php");


$PAGE_TITLE = "My Shift";

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
        <div id="shift-div" class="p-2 flex flex-row justify-center  rounded-md bg-gray-200">
            <div id="tabs" class="flex flex-col gap-2"></div>
            <div id="tab-content" class="py-2 pl-4 pr-8 bg-white"></div>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/body-scripts.php"); ?>
    <script>
        let shifts = [];

        $(document).ready(function() {
            $.ajax({
                url: "/api/nurses.php",
                data: {
                    scope: 'shift'
                },
                async: false,
                success: function(result) {
                    var data = JSON.parse(result);
                    shifts = data.results;

                    console.log(shifts);

                    data.results.forEach(function(item, i) {
                        $('#tabs').append('<p id="tab-' + i + '" onclick="changeTab(' + i + ')" class="p-4 text-xl hover:bg-gray-300 cursor-pointer tab">' + item.PatientLastName + ' ' + item.PatientFirstName + '</p>');
                    });

                    changeTab(0);
                }
            });
        });

        function changeTab(index) {
            $('#tab-content').html('');
            $('#tab-content').append('<div class="mb-4 grid grid-cols-3 gap-4"><p class="font-bold">Insurance ID: </p><p class="col-span-2">' + shifts[index].InsuranceID + '</p></div>');
            $('#tab-content').append('<div class="mb-4 grid grid-cols-2 gap-4"><div class="flex gap-2"><p class="font-bold">Last Name: </p><p class="col-span-2">' + shifts[index].PatientLastName + '</p></div><div class="flex gap-2"><p class="font-bold">First Name: </p><p class="col-span-2">' + shifts[index].PatientFirstName + '</p></div></div>');
            
            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            };
            var DateOfBirth = new Date(shifts[index].DateOfBirth);
            $('#tab-content').append('<div class="mb-4 grid grid-cols-3 gap-4"><p class="font-bold">Date of Birth: </p><p class="col-span-2">' + DateOfBirth.toLocaleDateString('el-GR', options) + '</p></div>');

            $('#tab-content').append('<div class="mb-4 grid grid-cols-3 gap-4"><p class="font-bold">Gender: </p><p class="col-span-2">' + shifts[index].Gender + '</p></div>');
            $('#tab-content').append('<div class="mb-4 mt-8 grid grid-cols-3 gap-4"><p class="font-bold">Doctor in charge: </p><p class="col-span-2">' + shifts[index].DoctorLastName + '</p></div>');
            $('#tab-content').append('<div class="mb-4 grid grid-cols-3 gap-4"><p class="font-bold">Diagnosis: </p><p class="col-span-2">' + shifts[index].Reason + '</p></div>');

            var AdmissionDate = new Date(shifts[index].StartDate);
            if (shifts[index].EndDate) {
                var DischargeDate = new Date(shifts[index].EndDate);
                $('#tab-content').append('<div class="mb-4 grid grid-cols-2 gap-4"><div class="flex gap-2"><p class="font-bold">Admission: </p><p>' + AdmissionDate.toLocaleDateString('el-GR', options) + '</p></div><div class="flex gap-2"><p class="font-bold">Discharge: </p><p>' + DischargeDate.toLocaleDateString('el-GR', options) + '</p></div></div>');

            } else {
                $('#tab-content').append('<div class="mb-4 grid grid-cols-2 gap-4"><div class="flex gap-2"><p class="font-bold">Admission: </p><p>' + AdmissionDate.toLocaleDateString('el-GR', options) + '</p></div><div class="flex gap-2"><p class="font-bold">Discharge: </p><p>-</p></div></div>');
            }


            $('.tab').each(function(i) {
                $(this).addClass('hover:bg-gray-300 cursor-pointer').removeClass('bg-white border-b-2 border-blue-500');
            });
            $('#tab-' + index).addClass('bg-white border-b-2 border-blue-500').removeClass('hover:bg-gray-300 cursor-pointer');
        }
    </script>
</body>

</html>