async function getCurrentLoginUser() {
    try {
        const response = await $.ajax({
            url: "./controller/AuthController.php",
            type: "POST",
            dataType: "json",
            data: { func: "getCurrentLoginUser" },
        });
        return response.userInfor;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getKhaoSatById(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/KhaoSatController.php",
            type: "POSt",
            dataType: "json",
            data: {
                func: "getChiTietKsById",
                id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getAllMucKhaoSat(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getMucKhaoSat",
                ks_id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllCauHoi(mks_ids) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getCauHoi",
                mks_ids: mks_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getKqksByUserId(ks_id, user_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getByIdKhaoSatAndIdUser",
                ks_id: ks_id,
                user_id: user_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getTraLoiByKqksId(kqks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getTraLoiByKqksId",
                kqks_id: kqks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadDuLieu(ks_id) {

    const currentLoginUser = await getCurrentLoginUser();
    if (!currentLoginUser || !currentLoginUser.dtId) {
        Swal.fire({
            title: "Thông báo",
            text: "Bạn chưa đăng nhập!",
            icon: "warning"
        });
        return;
    }

    // 0. Lấy chi tiết khảo sát
    const khaoSat = await getKhaoSatById(ks_id);
    if (khaoSat?.status === false && khaoSat?.message) {
        Swal.fire({
            title: "Thông báo",
            text: khaoSat.message,
            icon: "warning"
        });
        return;
    }

    // 1. Lấy danh sách mục khảo sát
    const mucKhaoSat = await getAllMucKhaoSat(ks_id);
    const mks_ids = mucKhaoSat.map(item => item.mks_id);

    // 2. Lấy danh sách câu hỏi theo mks_ids
    const cauHoi = await getAllCauHoi(mks_ids);

    // 3. Lấy kết quả khảo sát
    const kqks = await getKqksByUserId(ks_id, currentLoginUser.dtId);

    // 4. Lấy danh sách trả lời
    const traLoi = await getTraLoiByKqksId(kqks.kqks_id);

    console.log(currentLoginUser);
    console.log(mucKhaoSat);
    console.log(cauHoi);
    console.log(kqks);
    console.log(traLoi);


    // 6. Tạo tiêu đề bảng
    const cauhoiList = document.getElementById('cauhoi-list');
    cauhoiList.innerHTML = ''; // Xóa nội dung cũ

    const headerRow = document.createElement('tr');
    const cauHoiTh = document.createElement('th');
    cauHoiTh.textContent = 'Câu hỏi';
    headerRow.appendChild(cauHoiTh);
    const thangDiem = document.createElement('th');
    thangDiem.textContent = 'Thang điểm';
    thangDiem.colSpan = khaoSat.thang_diem;
    thangDiem.style.textAlign = "center";
    headerRow.appendChild(thangDiem);
    cauhoiList.appendChild(headerRow);

    const headerRow2 = document.createElement('tr');
    const space = document.createElement('th');
    headerRow2.appendChild(space);
    for (let diem = 1; diem <= khaoSat.thang_diem; diem++) {
        const th = document.createElement('th');
        th.textContent = diem;
        th.style.textAlign = "center";
        headerRow2.appendChild(th);
    }
    cauhoiList.appendChild(headerRow2);

    // 7. Tạo nội dung bảng
    const traloiList = document.getElementById('traloi-list');
    traloiList.innerHTML = '';

    // Duyệt qua từng mục khảo sát
    mucKhaoSat.forEach(mks => {
        // Dòng tiêu đề mục
        const mksRow = document.createElement('tr');
        mksRow.classList.add('hover');
        const mksTd = document.createElement('td');
        mksTd.textContent = mks.ten_muc;
        mksTd.colSpan = khaoSat.thang_diem + 1;
        mksTd.style.fontWeight = 'bold';
        mksRow.appendChild(mksTd);
        traloiList.appendChild(mksRow);

        // Tìm các câu hỏi thuộc mục khảo sát này
        const relatedQuestions = cauHoi.filter(ch => ch.mks_id === mks.mks_id);

        relatedQuestions.forEach(ch => {
            const row = document.createElement('tr');
            row.classList.add('hover');

            // Cột câu hỏi
            const cauHoiTd = document.createElement('td');
            cauHoiTd.textContent = ch.noi_dung;
            row.appendChild(cauHoiTd);

            // Tạo các ô radio tương ứng với mỗi mức điểm
            for (let diem = 1; diem <= khaoSat.thang_diem; diem++) {
                const td = document.createElement('td');
                td.style.textAlign = "center";

                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = `ch_${ch.ch_id}`;
                // radio.disabled = true;
                radio.className = 'radio radio-accent';

                // Nếu có ít nhất 1 người chọn mức điểm này
                const count = traLoi.filter(tl =>
                    Number(tl.ch_id) === Number(ch.ch_id) &&
                    Number(tl.ket_qua) === diem
                ).length;

                if (count > 0) {
                    radio.checked = true;
                } else {
                    radio.disabled = true;
                }

                td.appendChild(radio);
                row.appendChild(td);
            }

            traloiList.appendChild(row);
        });
    });
}

function xuatExel(ks_id) {
    $.ajax({
        url: './controller/ketQuaKhaoSatController.php',
        type: 'GET',
        data: {
            func: "xuatExel",
            ks_id: ks_id
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            if (response?.status === false && response?.message) {
                Swal.fire({
                    title: "Thông báo",
                    text: response.message,
                    icon: "warning"
                });
            } else {
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `survey_export_${ks_id}.xlsx`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        },
        error: function (xhr, status, error) {
            console.error("Đã xảy ra lỗi khi xuất Excel:", error);
        }
    });
}

$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const ks_id = urlParams.get('id');
    console.log(ks_id);
    loadDuLieu(ks_id);

    $('#excel').on('click', function () {
        xuatExel(ks_id);
    });
    $('.table').addClass('table-striped');
});