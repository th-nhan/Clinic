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
    
    
    const idsInput = document.getElementById('idsToDelete'); 
    const countDisplayModal = document.getElementById('countDisplay'); 

    let selectedIds = []; 
    rowCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedIds.push(checkbox.value); 
        }
    });

        
    selectedCountSpan.textContent = selectedIds.length;
    if(countDisplayModal) countDisplayModal.innerText = selectedIds.length;

    
    if(idsInput) idsInput.value = selectedIds.join(',');

    // Ẩn hiện nút Xóa to
    if (selectedIds.length > 0) {
        batchDeleteArea.style.display = 'flex'; 
    } else {
        batchDeleteArea.style.display = 'none';
    }

    // Cập nhật trạng thái checkbox tổng (Check All)
    const totalRows = rowCheckboxes.length;
    if (totalRows > 0) {
        checkAll.checked = (selectedIds.length === totalRows);
        checkAll.indeterminate = (selectedIds.length > 0 && selectedIds.length < totalRows);
    } else {
        checkAll.checked = false;
        checkAll.indeterminate = false;
    }
}


document.addEventListener('DOMContentLoaded', function() {
        // Ẩn nút xóa lúc đầu
        const batchDeleteArea = document.getElementById('batchDeleteArea');
        if(batchDeleteArea) batchDeleteArea.style.display = 'none';
    });

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('#controlButtons .btn');
    const collapses = document.querySelectorAll('#collapseContainer .collapse');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            // Xóa class active khỏi tất cả nút
            buttons.forEach(btn => btn.classList.remove('active'));
            // Thêm class active cho nút được nhấn
            this.classList.add('active');
        });
    });

    // Cập nhật trạng thái active khi collapse được mở
    collapses.forEach(collapse => {
        collapse.addEventListener('shown.bs.collapse', function () {
            const targetId = this.id;
            buttons.forEach(btn => {
                if (btn.getAttribute('data-bs-target') === `#${targetId}`) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        });
    });
});






