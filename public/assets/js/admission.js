function deleteAdmission(id) {
    if (confirm('Are you sure that you want to delete this admission?')) {
        $.ajax({
            url: '/api/admissions.php',
            type: 'delete',
            data: {
                id: id
            },
            success: function (response) {
                alert('The admission was deleted.');
                return (true);
            },
            error: function (response) {
                alert('There was a problem, please try again.');
                return (false);
            }
        });
    } else {
        return (false);
    }
}