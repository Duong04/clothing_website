var email = document.getElementById("email");
var password = document.getElementById("psw");

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
    }else if (password.value.length < 7){
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


function validateForm() {
    var isValid = true;

    // Kiểm tra hợp lệ của email
    var emailValid = validateEmail();

    // Kiểm tra hợp lệ của mật khẩu
    var passwordValid = validatePassword();
    isValid = emailValid && passwordValid;

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
document.getElementById("email").addEventListener('blur', validateEmail);
document.getElementById("psw").addEventListener('blur', validatePassword);



// Thêm trình lắng nghe sự kiện để xóa thông báo lỗi khi người dùng thay đổi nội dung

email.addEventListener('input', function () {
    document.getElementById("email-error").textContent = "";
    email.style.borderColor = '#ccc';
});
password.addEventListener('input', function () {
    document.getElementById("psw-error").textContent = "";
    password.style.borderColor = '#ccc';
});

const eye = document.getElementById("eye");
eye.addEventListener('click', function () {
    const psw = document.getElementById("psw");
    if (psw.type == 'text') {
        psw.type = 'password';
        eye.className = "fa-regular fa-eye-slash";
    }else if (psw.type == 'password') {
        psw.type = 'text';
        eye.className = "fa-regular fa-eye";
    }
});
