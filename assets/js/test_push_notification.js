function checkNotificationPromise() {
    try {
        Notification.requestPermission().then();
    } catch (e) {
        return false;
    }

    return true;
}

askNotificationPermission()

function askNotificationPermission() {
    // function to actually ask the permissions
    function handlePermission(permission) {
        // set the button to shown or hidden, depending on what the user answers
        if (Notification.permission === 'denied' || Notification.permission === 'default') {
            console.log('block');
        } else {
            console.log('none');
        }
    }

    // Let's check if the browser supports notifications
    if (!('Notification' in window)) {
        console.log("This browser does not support notifications.");
    } else {
        if (checkNotificationPromise()) {
            Notification.requestPermission()
                .then((permission) => {
                    handlePermission(permission);
                })
        } else {
            Notification.requestPermission(function (permission) {
                handlePermission(permission);
            });
        }
    }
}

// var img = '/to-do-notifications/img/icon-128.png'; , icon: img
var text = 'Hello! appointment has been applied please open the browser to check.';
var notification = new Notification('Appointment has been applied', { body: text });