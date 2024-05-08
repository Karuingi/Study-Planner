// Function to check for expired reminders
function checkReminders() {
    setInterval(function() {
        // Send AJAX request to check for expired reminders
        $.ajax({
            type: "GET",
            url: "check_reminders.php",
            dataType: "json",
            success: function(data) {
                // Display notifications for expired reminders
                if (data.length > 0) {
                    data.forEach(function(reminder) {
                        // Display notification for each expired reminder
                        alert("Reminder: " + reminder.notification_message + " is overdue!");
                    });
                }
            }
        });
    }, 60000); // Check every minute (adjust as needed)
}

// Call the function when the page loads
$(document).ready(function() {
    checkReminders();
});
