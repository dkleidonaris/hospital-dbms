<nav>
    <div class="grid md:grid-cols-3 justify-center bg-orange-200 py-2">
        <div class="mb-2 md:mb-0">
            <a href="/"><img src="/assets/img/logo_full.png" width="600" height="100" class="h-16 w-auto mx-auto object-contain"></a>
        </div>
        <div class="md:col-span-2 flex flex-row gap-8 items-center">
            <a class="text-center md:text-xl hover:text-blue-500" href="/secretary/index.php">Dashboard</a>
            <div @mouseover="open=true" @mouseleave="open=false" x-data="{open:false}" class="relative">
                <p class="text-center md:text-xl hover:text-blue-500">Departments</p>
                <div x-show="open" class="absolute top-full bg-white shadow-md whitespace-nowrap" x-cloak>
                    <ul>
                    <a href="/secretary/departments/index.php"><li class="p-2 pr-20 hover:bg-blue-500">View all</li></a>
                    <a href="/secretary/departments/create.php"><li class="p-2 pr-20 hover:bg-blue-500">Create</li></a>
                    </ul>
                </div>
            </div>
            <div @mouseover="open=true" @mouseleave="open=false" x-data="{open:false}" class="relative">
                <p class="text-center md:text-xl hover:text-blue-500">Rooms</p>
                <div x-show="open" class="absolute top-full bg-white shadow-md whitespace-nowrap" x-cloak>
                    <ul>
                    <a href="/secretary/rooms/index.php"><li class="p-2 pr-20 hover:bg-blue-500">View all</li></a>
                    <a href="/secretary/rooms/create.php"><li class="p-2 pr-20 hover:bg-blue-500">Create</li></a>
                    </ul>
                </div>
            </div>
            <div @mouseover="open=true" @mouseleave="open=false" x-data="{open:false}" class="relative">
                <p class="text-center md:text-xl hover:text-blue-500">Employees</p>
                <div x-show="open" class="absolute top-full bg-white shadow-md whitespace-nowrap" x-cloak>
                    <ul>
                    <a href="/secretary/employees/index.php"><li class="p-2 pr-20 hover:bg-blue-500">View all</li></a>
                    <a href="/secretary/employees/create.php"><li class="p-2 pr-20 hover:bg-blue-500">Create</li></a>
                    </ul>
                </div>
            </div>
            <div @mouseover="open=true" @mouseleave="open=false" x-data="{open:false}" class="relative">
                <a class="text-center md:text-xl hover:text-blue-500">Patients</a>
                <div x-show="open" class="absolute top-full bg-white shadow-md whitespace-nowrap" x-cloak>
                    <ul>
                    <a href="/secretary/patients/index.php"><li class="p-2 pr-20 hover:bg-blue-500">View all</li></a>
                    <a href="/secretary/patients/create.php"><li class="p-2 pr-20 hover:bg-blue-500">Create</li></a>
                    </ul>
                </div>
            </div>
            <div @mouseover="open=true" @mouseleave="open=false" x-data="{open:false}" class="relative">
                <a class="text-center md:text-xl hover:text-blue-500">Admissions</a>
                <div x-show="open" class="absolute top-full bg-white shadow-md whitespace-nowrap" x-cloak>
                    <ul>
                    <a href="/secretary/admissions/index.php"><li class="p-2 pr-20 hover:bg-blue-500">View</li></a>
                    <a href="/secretary/admissions/create.php"><li class="p-2 pr-20 hover:bg-blue-500">Create</li></a>
                    </ul>
                </div>
            </div>
            <div class="ml-auto pl-10 mr-8 flex gap-1 items-center">
                <p class="md:text-xl italic">Hello Sec.</p>
                <p class="font-bold italic md:text-xl"><?php echo $_SESSION['last_name'] ?></p>
                <p>|</p>
                <a href="/logout.php" class="md:text-xl text-blue-600">Logout</a>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['message_type'], $_SESSION['message'])) {
        include($_SERVER["DOCUMENT_ROOT"] . "/includes/message.inc.php");
    }
    unset($_SESSION["message_type"]);
    unset($_SESSION["message"]);
    ?>
</nav>