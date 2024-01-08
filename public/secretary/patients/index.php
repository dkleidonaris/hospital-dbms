<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Patients";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/head-contents.php"); ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/navbar-secretary.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"); ?>

    <div class="my-4 max-w-xl mx-auto">
        <input id="search" placeholder="Search by insurance number" type="text" class="w-full rounded-md p-2">
    </div>

    <div class="px-4 my-8">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('ID')" id="insurance_number" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Insurance ID</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('LastName')" id="last_name" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Last Name</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('FirstName')" id="first_name" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>First Name</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('Gender')" id="gender" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Gender</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('DateOfBirth')" id="date_of_birth" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Date of Birth</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('ContactNumber')" id="contact_number" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Contact Number</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('EmailAddress')" id="email_address" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Email Address</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('Address')" id="address" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Address</p>
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
    <script src="/assets/js/patient.js"></script>
    <script>
        let orderBy = '';
        let orderDirection = 'ASC';
        fetchPatients();
        orderByF('ID');

        $('#search').on('input', function() {
            fetchPatients();
        });

        function deleteAction(id) {
            if (deletePatient(id)) {
                fetchPatients();
            }

        }

        function orderByF(orderByNew) {
            if (orderByNew == orderBy) {
                toggleOrderDirection();
                fetchPatients();
            } else {
                orderDirection = 'ASC';
                orderBy = orderByNew;
                fetchPatients();
            }
            $(".order-by").remove();
            $('.order-by-div').each(function() {
                switch (this.id) {
                    case 'insurance_number':
                        if (orderBy == 'ID') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'last_name':
                        if (orderBy == 'LastName') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'first_name':
                        if (orderBy == 'FirstName') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'gender':
                        if (orderBy == 'Gender') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'date_of_birth':
                        if (orderBy == 'DateOfBirth') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'email_address':
                        if (orderBy == 'EmailAddress') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'address':
                        if (orderBy == 'Address') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'contact_number':
                        if (orderBy == 'ContactNumber') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                }
            });
        }

        function toggleOrderDirection() {
            if (orderDirection == 'ASC') {
                orderDirection = 'DESC';
            } else {
                orderDirection = 'ASC';
            }
        }

        function fetchPatients() {
            $.ajax({
                url: '/api/patients.php',
                data: {
                    scope: 'secretary',
                    insurance_id: $('#search').val(),
                    order_by: orderBy,
                    order_direction: orderDirection
                },
                success: function(response) {
                    $('#tbody').html('');
                    data = JSON.parse(response);
                    console.log(data);

                    if (data.results.length) {
                        data.results.forEach(function(item, i) {
                            const options = {
                                year: 'numeric',
                                month: 'numeric',
                                day: 'numeric',
                            };
                            var dateOfBirth = new Date(item.DateOfBirth);
                            $('#tbody').append('<tr row-num="' + i + '" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"></tr>');
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4 font-medium text-gray-900 dark:text-white">' + item.ID + '</th>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.LastName + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.FirstName + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.Gender + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + dateOfBirth.toLocaleDateString('en-GR', options) + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.ContactNumber + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.EmailAddress + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.Address + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4 text-right"><a href="/secretary/patients/edit.php?id=' + item.ID + '" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a></td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4 text-right"><svg onclick="deleteAction(' + item.ID + ')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 fill-red-500 cursor-pointer"><g><path fill="none" d="M0 0h24v24H0z" /><path d="M7 4V2h10v2h5v2h-2v15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6H2V4h5zM6 6v14h12V6H6zm3 3h2v8H9V9zm4 0h2v8h-2V9z" /></g></svg></td>');
                        });
                    } else {
                        $('#tbody').append('<p class="py-4 mx-auto font-bold text-2xl">No patients found with the ID that you provided!</p>');
                    }
                }


            });
        }
    </script>
</body>

</html>