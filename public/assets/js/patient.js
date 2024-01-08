function deletePatient(id) {
    if (confirm('Are you sure that you want to delete this patient?')) {
        $.ajax({
            url: '/api/patients.php',
            type: 'delete',
            data: {
                id: id
            },
            success: function(response) {
                alert('The patient was deleted.');
                return(true);
            },
            error: function(response) {
                alert('There was a problem, please try again.');
                return(false);
            }
        });
    } else {

    }
}