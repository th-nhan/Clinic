document.addEventListener("DOMContentLoaded", () => {
  function updateTime() {
    const timenow = new Date();
    const options = {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    };
    document.getElementById('currentTime').innerHTML =
      timenow.toLocaleString('vi-VN', options);
  }

  updateTime();
  setInterval(updateTime, 1000);
});





// Đặt ngày tối thiểu cho bộ chọn ngày là ngày hiện tại
const today = new Date().toISOString().split('T')[0];
document.getElementById('dateTimePicker').setAttribute('min', today);

//check khi checkbox "Chọn tất cả" được thay đổi
function toggleAllCheckboxes(masterCheckbox) {
    const isChecked = masterCheckbox.checked;
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');

    rowCheckboxes.forEach(checkbox => {
        checkbox.checked = isChecked;
    });
    updateDeleteButton();
}

//Cập nhật trạng thái nút xóa dựa trên các checkbox được chọn
function updateDeleteButton() {
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const checkAll = document.getElementById('checkAll');
    const batchDeleteArea = document.getElementById('batchDeleteArea');
    const selectedCountSpan = document.getElementById('selectedCount');

    let selectedCount = 0;

    rowCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedCount++;
        }
    });


    selectedCountSpan.textContent = selectedCount;


    if (selectedCount > 0) {
        batchDeleteArea.classList.add('show');
    } else {
        batchDeleteArea.classList.remove('show');
    }


    const totalRows = rowCheckboxes.length;
    if (totalRows > 0) {
        checkAll.checked = (selectedCount === totalRows);
        checkAll.indeterminate = (selectedCount > 0 && selectedCount < totalRows);
    } else {
        checkAll.checked = false;
        checkAll.indeterminate = false;
    }
}


document.addEventListener('DOMContentLoaded', updateDeleteButton);


// Danh sách tất cả các khối nội dung (collapse)
const allCollapseIds = [
    '#themLichLamViec',
    '#xemLichLamViec',
    '#timKiemLichLamViec',
    '#xoaLichLamViec'
];

//  để mở/đóng khối nội dung 
function toggleExclusiveCollapse(buttonElement, targetId) {
    const targetElement = document.querySelector(targetId);
    const isTargetOpening = !targetElement.classList.contains('show');

    // bỏ Active cho tất cả các nút
    const allButtons = document.querySelectorAll('#controlButtons button');
    allButtons.forEach(btn => btn.classList.remove('active-tab'));

    if (isTargetOpening) {
        // Đóng tất cả các khối nội dung khác
        allCollapseIds.forEach(id => {
            if (id !== targetId) {
                const element = document.querySelector(id);
                if (element && element.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(element) || new bootstrap.Collapse(
                        element, {
                            toggle: false
                        });
                    bsCollapse.hide();
                }
            }
        });

        // Mở khối mục tiêu
        const bsTarget = bootstrap.Collapse.getInstance(targetElement) || new bootstrap.Collapse(targetElement, {
            toggle: false
        });
        bsTarget.show();

        // Đặt nút mục tiêu là active
        buttonElement.classList.add('active-tab');

    } else {
        // Nếu đang mở và click lần nữa (để đóng)
        const bsTarget = bootstrap.Collapse.getInstance(targetElement) || new bootstrap.Collapse(targetElement, {
            toggle: false
        });
        bsTarget.hide();
    }
}




// ----- SCRIPT CHO MODAL "XEM CHI TIẾT" (#doctorDetailModal) -----

// 1. Lấy tham chiếu đến Modal "Xem chi tiết

var doctorDetailModal = document.getElementById('doctorDetailModal');

// 2. Thêm "người nghe" sự kiện khi modal CHUẨN BỊ hiển thị
doctorDetailModal.addEventListener('show.bs.modal', function (event) {
    
    // 3. Lấy ra cái nút "Xem" vừa được bấm
    var button = event.relatedTarget;

    // 4. Lấy dữ liệu từ các thuộc tính data-* của nút đó
    var id = button.dataset.id;
    var ten = button.dataset.ten;
    var ngay = button.dataset.ngay;
    var ca = button.dataset.ca;
    var email = button.dataset.email;
    var sdt = button.dataset.sdt;
    var trangthaiText = button.dataset.trangthai;
    var ghichu = button.dataset.ghichu;

    // 5. Tìm các thẻ <span> trong modal để điền thông tin
    var modalBody = doctorDetailModal.querySelector('.modal-body');
    modalBody.querySelector('#detail-id').innerText = id;
    modalBody.querySelector('#detail-ten').innerText = ten;
    modalBody.querySelector('#detail-ngay').innerText = ngay;
    modalBody.querySelector('#detail-ca').innerText = ca;
    modalBody.querySelector('#detailemail').innerText = email || "N/A"; // (Nếu thiếu)
    modalBody.querySelector('#detailsdt').innerText = sdt || "N/A"; // (Nếu thiếu)
    modalBody.querySelector('#detail-ghichu').innerText = ghichu;

    modalBody.querySelector('#detail-ten-display').innerText = "BS. " + ten;
    
    // 6. Xử lý "Tình trạng" để tạo badge cho đẹp
    var trangthaiSpan = modalBody.querySelector('#detail-trangthai');
    var badgeClass = 'bg-secondary'; // Mặc định
    if (trangthaiText === 'Đã duyệt') {
        badgeClass = 'bg-success';
    } else if (trangthaiText === 'Đã hủy') {
        badgeClass = 'bg-danger';
    } else if (trangthaiText === 'Chờ duyệt') {
        badgeClass = 'bg-warning text-dark';
    }
    trangthaiSpan.innerHTML = `<span class="badge ${badgeClass}">${trangthaiText}</span>`;
});










// ----- SCRIPT CHO MODAL "CẬP NHẬT" (#capNhatLichLamViec) -----

// 1. Lấy tham chiếu đến Modal "Cập nhật"
var capNhatLichLamViecModal = document.getElementById('capNhatLichLamViec');

// 2. Thêm "người nghe" sự kiện khi modal CHUẨN BỊ hiển thị
capNhatLichLamViecModal.addEventListener('show.bs.modal', function (event) {
    
    // 3. Lấy ra cái nút "Sửa" vừa được bấm
    var button = event.relatedTarget;

    // 4. Lấy dữ liệu từ các thuộc tính data-* của nút đó
    var ten = button.dataset.ten;
    var ngay = button.dataset.ngay;
    var caValue = button.dataset.ca;
    var trangthaiValue = button.dataset.trangthai;
    var ghichu = button.dataset.ghichu;
    // (Bạn có thể thêm data-id, data-email, data-sdt... nếu cần)

    // 5. Tìm các trường <input>, <select> trong form
    var modalForm = capNhatLichLamViecModal.querySelector('form');
    
    modalForm.querySelector('#doctorDataList').value = ten;
    modalForm.querySelector('#dateTimePicker').value = ngay;
    modalForm.querySelector('#status').value = trangthaiValue;
    modalForm.querySelector('#floatingTextarea').value = ghichu;
    
    // 6. Xử lý Radio button "Ca làm việc"
    // Tìm đúng radio có value (ca1, ca2, ca3) khớp với data-ca-value
    var caRadio = modalForm.querySelector(`input[name="caLamViec"][value="${caValue}"]`);
    if (caRadio) {
        caRadio.checked = true;
    }
});