function deleteMedication(id) {
    if (confirm('Are you sure that you want to delete this medication?')) {
        $.ajax({
            url: '/api/medications.php',
            type: 'delete',
            data: {
                id: id
            },
            success: function (response) {
                alert('The medication was deleted.');
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