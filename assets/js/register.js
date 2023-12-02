var userName = document.getElementById("user-name");
var email = document.getElementById("email");
var password = document.getElementById("psw");
var confirmPassword = document.getElementById("confirm-psw");


function validateUserName() {
    var userNameError = document.getElementById("user-name-error");
    if (userName.value === "") {
        userNameError.textContent = "Vui lòng nhập tên người dùng";
        userName.style.borderColor = 'red';
        return false;
    } else {
        userNameError.textContent = "";
        userName.style.borderColor = '#ccc';
        return true;
    }
}

function validateEmail() {
    var emailError = document.getElementById("email-error");
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email.value === "") {
        emailError.textContent = "Vui lòng nhập địa chỉ email";
        email.style.borderColor = 'red';
        return false;
    } else if (!regex.test(email.value)) {
        emailError.textContent = "Vui lòng nhập đúng định dạng email";
        email.style.borderColor = 'red';
        return false;
    } else {
        emailError.textContent = ""; 
        email.style.borderColor = '#ccc';
        return true;
    }
}

function validatePassword() {
    var passwordError = document.getElementById("psw-error");
    if (password.value === "") {
        passwordError.textContent = "Vui lòng nhập mật khẩu";
        password.style.borderColor = 'red';
        return false;
    }else if(password.value.length < 7){
        passwordError.textContent = "Vui lòng nhập độ dài hơn 6 ";
        password.style.borderColor = 'red';
        return false;
    }
     else {
        passwordError.textContent = ""; 
        password.style.borderColor = '#ccc';
        return true;
    }
}

function validateConfirmPassword() {
    var confirmPasswordError = document.getElementById("confirm-psw-error");
    if (confirmPassword.value === "") {
        confirmPasswordError.textContent = "Vui lòng nhập lại mật khẩu";
        confirmPassword.style.borderColor = 'red';
        return false;
    } else if (password.value !== confirmPassword.value) {
        confirmPasswordError.textContent = "Mật khẩu không khớp";
        confirmPassword.style.borderColor = 'red';
        return false;
    } else {
        confirmPasswordError.textContent = ""; 
        confirmPassword.style.borderColor = '#ccc';
        return true;
    }
}

function validateForm() {
    var isValid = true;

    // Kiểm tra hợp lệ của tên người dùng
    var userNameValid = validateUserName();

    // Kiểm tra hợp lệ của email
    var emailValid = validateEmail();


    // Kiểm tra hợp lệ của mật khẩu
    var passwordValid = validatePassword();


    // Kiểm tra hợp lệ của việc nhập lại mật khẩu
    var confirmPasswordValid = validateConfirmPassword();


    // Kiểm tra hợp lệ của checkbox
    var checkbox = document.getElementById("checkbox").checked;
    var checkboxError = document.getElementById("checkbox-error");
    var isChecked = true;
    if (!checkbox) {
        checkboxError.textContent = "Vui lòng đồng ý với các điều khoản";
        isChecked = false;
    } else {
        checkboxError.textContent = ""; 
        isChecked = true;
    }

    isValid = userNameValid && emailValid && passwordValid && confirmPasswordValid && isChecked;
    if (isValid) {
        return true;
    }else {
        return false;
    }

}

document.getElementById("registration-form").addEventListener('submit', function(event) {
    var isValid = validateForm();
    if (!isValid) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của sự kiện submit trên biểu mẫu
    }
});

// Thêm trình lắng nghe sự kiện để kiểm tra hợp lệ khi người dùng rời khỏi trường nhập liệu
document.getElementById("user-name").addEventListener('blur', validateUserName);
document.getElementById("email").addEventListener('blur', validateEmail);
document.getElementById("psw").addEventListener('blur', validatePassword);
document.getElementById("confirm-psw").addEventListener('blur', validateConfirmPassword);


// Thêm trình lắng nghe sự kiện để xóa thông báo lỗi khi người dùng thay đổi nội dung
userName.addEventListener('input', function () {
    document.getElementById("user-name-error").textContent = "";
    userName.style.borderColor = '#ccc';
});
email.addEventListener('input', function () {
    document.getElementById("email-error").textContent = "";
    email.style.borderColor = '#ccc';
});
password.addEventListener('input', function () {
    document.getElementById("psw-error").textContent = "";
    password.style.borderColor = '#ccc';
});
confirmPassword.addEventListener('input', function () {
    document.getElementById("confirm-psw-error").textContent = "";
    confirmPassword.style.borderColor = '#ccc';
});

document.getElementById("checkbox").addEventListener('change', function () {
    document.getElementById("checkbox-error").textContent = "";
});

// ---------------------------------
function togglePasswordVisibility(inputField, eyeIcon) {
    if (inputField.type === "password") {
        inputField.type = "text";
        eyeIcon.classList = "fa-regular fa-eye";
    } else if (inputField.type === "text") {
        inputField.type = "password";
        eyeIcon.classList = "fa-regular fa-eye-slash";
    }
} 

let psw = document.getElementById('psw');
let psw2 = document.getElementById('confirm-psw');
let eye = document.getElementById('eye');
let eye2 = document.getElementById('eye_2');

eye.addEventListener('click', function() {
    togglePasswordVisibility(psw, eye);
});

eye2.addEventListener('click', function() {
    togglePasswordVisibility(psw2, eye2);
});