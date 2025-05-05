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
async function getAllKqks(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllByKsId",
                ks_id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllTraLoi(kqks_ids) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getTraLoi",
                kqks_ids: kqks_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadDuLieu(ks_id) {

    // 0. Lấy chi tiết khảo sát
    const khaoSat = await getKhaoSatById(ks_id);

    // 1. Lấy danh sách mục khảo sát
    const mucKhaoSat = await getAllMucKhaoSat(ks_id);
    const mks_ids = mucKhaoSat.map(item => item.mks_id);

    // 2. Lấy danh sách câu hỏi theo mks_ids
    const cauHoi = await getAllCauHoi(mks_ids);

    // 3. Lấy kết quả khảo sát
    const kqks = await getAllKqks(ks_id);
    const kqks_ids = kqks.data.map(item => item.kqks_id);
    const doiTuong_ids = kqks.data.map(item => item.nguoi_lamks_id);

    // 4. Lấy danh sách trả lời
    const traLoi = await getAllTraLoi(kqks_ids);

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
            const cauHoiTd = document.createElement('td');
            cauHoiTd.textContent = ch.noi_dung;
            row.appendChild(cauHoiTd);

            // Đếm số trả lời theo từng điểm
            for (let diem = 1; diem <= khaoSat.thang_diem; diem++) {
                const count = traLoi.filter(tl => tl.ch_id === ch.ch_id && tl.ket_qua === diem).length;
                const td = document.createElement('td');
                td.textContent = count;
                td.style.textAlign = "center";
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
        success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `survey_export_${ks_id}.xlsx`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
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