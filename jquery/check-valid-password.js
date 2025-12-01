function checkValidPassword(admin_password) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "../backend/admin/verifyPassword.php",
            method: "post",
            data: {
                admin_password
            },
            success: function(response) {
                if (response === 'valid') {
                    resolve(true);
                } else {
                    resolve(false);
                }
            },
            error: function() {
                alert("Connection Error");
                reject(new Error("Connection Error"));
            }
        });
    });
}