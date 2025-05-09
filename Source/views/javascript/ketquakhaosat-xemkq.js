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
    var khaoSat = await getKhaoSatById(ks_id);
    if (khaoSat?.status === false && khaoSat?.message) {
        Swal.fire({
            title: "Thông báo",
            text: khaoSat.message,
            icon: "warning"
        });
        return;
    }

    // 1. Lấy danh sách mục khảo sát
    var mucKhaoSat = await getAllMucKhaoSat(ks_id);
    var mks_ids = mucKhaoSat.map(item => item.mks_id);

    // 2. Lấy danh sách câu hỏi theo mks_ids
    var cauHoi = await getAllCauHoi(mks_ids);

    // 3. Lấy kết quả khảo sát
    var kqks = await getAllKqks(ks_id);
    var kqks_ids = kqks.data.map(item => item.kqks_id);

    // 4. Lấy danh sách trả lời
    var traLoi = await getAllTraLoi(kqks_ids);

    console.log(mucKhaoSat);
    console.log(cauHoi);
    console.log(kqks.data);
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
                const count = traLoi.filter(tl => Number(tl.ch_id) === Number(ch.ch_id) &&
                                                    Number(tl.ket_qua) === Number(diem)).length;
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
    Swal.fire({
        title: 'Đang xử lý...',
        text: 'Vui lòng chờ trong giây lát',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
    }});
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
            Swal.close();
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