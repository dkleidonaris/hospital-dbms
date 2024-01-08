<?php
include($_SERVER['DOCUMENT_ROOT'] . "/../includes/beginScripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/dbHandler.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/auth/secretary.php");

$PAGE_TITLE = "Rooms";
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
        <input id="search" placeholder="Search for a certain room" type="text" class="w-full rounded-md p-2">
    </div>

    <div class="px-4 my-8">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('RoomNumber')" id="room_number" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>ID</p>
                            </div>
                        </th>
                        <th scope="col" class="w-52 px-6 py-3">
                            <div onclick="orderByF('DepartmentName')" id="department_id" class="cursor-pointer order-by-div flex gap-2 items-center">
                                <p>Name</p>
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
    <script src="/assets/js/room.js"></script>
    <script>
        let orderBy = '';
        let orderDirection = 'ASC';
        orderByF('ID');

        $('#search').on('input', function() {
            fetchRooms();
        });

        function deleteAction(id) {
            deleteRoom(id);
            fetchRooms();
        }

        function orderByF(orderByNew) {
            if (orderByNew == orderBy) {
                toggleOrderDirection();
            } else {
                orderDirection = 'ASC';
                orderBy = orderByNew;
            }
            fetchRooms();

            $(".order-by").remove();
            $('.order-by-div').each(function() {
                switch (this.id) {
                    case 'room_number':
                        if (orderBy == 'RoomNumber') {
                            if (orderDirection == 'ASC') {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            } else {
                                $(this).append('<svg data-name="1-Arrow Up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="rotate-180 order-by transition w-4"><path d="m26.71 10.29-10-10a1 1 0 0 0-1.41 0l-10 10 1.41 1.41L15 3.41V32h2V3.41l8.29 8.29z" /></svg>');
                            }
                        }
                        break;
                    case 'department_id':
                        if (orderBy == 'DepartmentID') {
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

        function fetchRooms() {
            var data = {};
            data = {
                order_by: orderBy,
                order_direction: orderDirection
            };

            if ($('#search').val()) {
                data.q = $('#search').val()
            }
            $.ajax({
                url: '/api/rooms.php',
                data: data,
                success: function(response) {
                    console.log(response);
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
                            $("tr[row-num='" + i + "']").append('<th class="px-6 py-4 font-medium text-gray-900 dark:text-white">' + item.RoomNumber + '</th>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4">' + item.DepartmentName + '</td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4 text-right"><a href="/secretary/rooms/edit.php?id=' + item.RoomNumber + '" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a></td>');
                            $("tr[row-num='" + i + "']").append('<td class="px-6 py-4 text-right"><svg onclick="deleteAction(' + item.RoomNumber + ')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 fill-red-500 cursor-pointer"><g><path fill="none" d="M0 0h24v24H0z" /><path d="M7 4V2h10v2h5v2h-2v15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6H2V4h5zM6 6v14h12V6H6zm3 3h2v8H9V9zm4 0h2v8h-2V9z" /></g></svg></td>');
                        });
                    } else {
                        $('#tbody').append('<p class="py-4 mx-auto font-bold text-2xl">The room that you are looking for does not exist!</p>');
                    }
                }
            });
        }
    </script>
</body>

</html>