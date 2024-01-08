function deleteRoom(id) {
    if (confirm('Are you sure that you want to delete this room?')) {
        $.ajax({
            url: '/api/rooms.php',
            type: 'delete',
            data: {
                id: id
            },
            success: function (response) {
                alert('The room was deleted.');
            },
            error: function (response) {
                alert('There was a problem, please try again.');
            }
        });
    } else {

    }
}