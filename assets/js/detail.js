$(document).ready(function() {
        // Lấy giá trị hiện tại
        var currentQuantity = parseInt($('#quantityInput').val());

        // Bắt sự kiện nút giảm
        $('.decrease').on('click', function() {
            if (currentQuantity > 1) {
                currentQuantity--;
                $('#quantityInput').val(currentQuantity);
            }
        });

        // Bắt sự kiện nút tăng
        $('.increase').on('click', function() {
            if (currentQuantity < 10) {
                currentQuantity++;
                $('#quantityInput').val(currentQuantity);
            }
        });
    });
