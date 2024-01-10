function deleteDepartment(id) {
    if (confirm('Are you sure that you want to delete this department?')) {
        $.ajax({
            url: '/api/departments.php',
            type: 'delete',
            data: {
                id: id
            },
            success: function(response) {
                alert('The department was deleted.');
                return(true);
            },
            error: function(response) {
                alert('There was a problem, please try again.');
                return(false);
            }
        });
    } else {
        return(false);
    }
}