$('#password_confirm').on('input', pwdCheck);
$('#password').on('input', pwdCheck);

$('#type').on('input', showDepartments);

showDepartments();

function showDepartments() {
    if ($('#type').val() == 'doctor') {
        $.ajax({
            url: "/api/departments.php",
            data: {},
            success: function (result) {
                var data = JSON.parse(result);


                $('#department').remove();
                $('#department-div').removeClass('hidden');
                $('#department-div').append('<select name="department_id" id="department" class="flex-1 rounded-md p-2" required></select>');
                data.results.forEach(function (item) {
                    if(typeof DepartmentID !== 'undefined') {
                    $('#department').append('<option value="' + item.Id + '" ' + (item.Id == DepartmentID ? 'selected' : '') + '>' + item.Name + '</option>');
                    } else {
                        $('#department').append('<option value="' + item.Id + '">' + item.Name + '</option>');
                    }
                });
            }
        });
    } else {
        $('#department-div').addClass('hidden');
        $('#department').remove();
    }
}



function deleteEmployee(id) {
    if (confirm('Are you sure that you want to delete this employee?')) {
        $.ajax({
            url: '/api/employees.php',
            type: 'delete',
            data: {
                id: id
            },
            success: function (response) {
                alert('The patient was deleted.');
                return(true);
            },
            error: function (response) {
                alert('There was a problem, please try again.');
                return(false);
            }
        });
    } else {
        return(false);
    }
}

function pwdCheck() {
    if ($('#password').val() && $('#password_confirm').val()) {
        if ($('#password').val() != $('#password_confirm').val()) {
            $("form").submit(function (e) {
                e.preventDefault();
            });
            $('#pwd_error').removeClass('hidden');
        } else {
            $("form").unbind('submit');
            $('#pwd_error').addClass('hidden');
        }
    }
}